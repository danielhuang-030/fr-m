<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;
use DB;

class BwbDownloadBookImages extends Command
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

        // handle 1000 at one time
        $model->with(['images' => function($query) {
            $query->where('file', 'like', 'http%');
        }])->chunk(1000, function($books) {
            foreach ($books as $book) {

                $directory = sprintf('books/%s', env('ALGOLIA_DATA_PATH'), $this->getDate());
                Storage::disk('public')->makeDirectory($directory, 0777);

                dd($book);
            }
        });
    }

}
