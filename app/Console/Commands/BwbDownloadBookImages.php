<?php

namespace App\Console\Commands;

use Storage;
use File;

class BwbDownloadBookImages extends BwbCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bwb:download-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'download/update images of books from bwb';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        ini_set("memory_limit", "4096M");
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $model = new \App\Models\Book();

        // handle 500 at one time
        $model->select('books.*')
            ->join('book_images', 'books.id', '=', 'book_images.book_id')
            ->where('book_images.file', 'like', 'http%')
            ->with('images')
            ->chunk(500, function($books) {
                foreach ($books as $book) {
                    $images = $book->images()->get();
                    foreach ($images as $image) {
                        if (!starts_with($image->file, 'http')) {
                            continue;
                        }

                        try {
                            // build dir
                            $dir = $image->getDir();
                            $dirWithBooks = sprintf('%s/%s', config('web.dir.book'), $dir);
                            Storage::disk('public')->makeDirectory($dirWithBooks, 0777);

                            // copy
                            $file = sprintf('%s.%s', $book->slug, File::extension($image->file));
                            if (!File::copy($image->file, sprintf('%s/%s', Storage::disk('public')->path($dirWithBooks), $file))) {
                                throw new Exception('Image download failed');
                            }

                            // update
                            $image->file = sprintf('%s/%s', $dir, $file);
                            $image->save();
                        } catch (\Exception $e) {
                            $this->error(sprintf('%s,%s', $e->getMessage(), $book->isbn13));
                            continue;
                        }
                    }
                    $this->info(sprintf('Image download successfully,%s', $book->isbn13));
                }
        });

    }

}
