<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;
use DB;

class ParseBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bwb:parsebooks {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse books from algolia data files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        ini_set("memory_limit", "3072M");
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = Storage::disk('public')->allFiles(sprintf('%s/%s', env('ALGOLIA_DATA_PATH'), $this->getDate()));
        if (empty($files)) {
            $this->error('No file exists');
            return;
        }

        foreach ($files as $file) {
            $books = json_decode(Storage::disk('public')->get($file));
            if (empty($books)) {
                $this->error(sprintf('There is no data in this file: %s', $file));
                continue;
            }

            foreach ($books as $book) {
                DB::beginTransaction();
                try {
                    // author
                    $authorIds = [];
                    $authors = $book->Authors;
                    foreach ($authors as $author) {
                        $model = new \App\Models\Author();
                        $model->name = $author;
                        $model->save();
                        $authorIds[] = $model->id;
                    }
                    $firstAuthor = current($authors);

                    // category
                    $categoryIds = [];
                    $categoryStr = $book->Categories->lvl2[0];
                    $categoryList = explode(' > ', $categoryStr);
                    $parentCategory = null;
                    foreach ($categoryList as $name) {
                        $categoryData = [
                            'name' => $name,
                        ];
                        $model = new \App\Models\Category();
                        $category = $model->create($categoryData);
                        if (!empty($parentCategory)) {
                            $category->appendToNode($parentCategory)->save();
                        }
                        $categoryIds[] = $category->id;
                        $parentCategory = $category;
                    }

                    // book
                    $model = new \App\Models\Book();
                    $model->title = $book->Title;
                    $model->slug = \Cviebrock\EloquentSluggable\Services\SlugService::createSlug(\App\Models\Book::class, 'slug', sprintf('%s-%s-%s', $book->Title, $firstAuthor, $book->Isbn13));
                    $model->bwb_id = $book->objectID;
                    $model->isbn10 = $book->Isbn10;
                    $model->isbn13 = $book->Isbn13;
                    $model->description = '';
                    $model->format = $book->Format;
                    $model->weight = $book->Weight;
                    $model->save();
                    $bookId = $model->id;

                    // condition
                    $availableCopies = $book->AvailableCopies;
                    $newCondition = null;
                    if (empty($availableCopies)) {
                        throwException('There is no condition for this book');
                    }
                    foreach ($availableCopies as $availableCopy) {
                        if ($availableCopy->IsNew) {
                            $newCondition = $availableCopy;
                        }
                    }
                    if (null === $newCondition) {
                        throwException('There is no new condition for this book');
                    }
                    $model = new \App\Models\BookCondition();
                    $model->condition = 'new';
                    $model->quantity = $newCondition->Quantity;
                    $model->price = $newCondition->UnitPrice;
                    $model->in_stock = 1;
                    $model->book_id = $bookId;
                    $model->save();

                    // image
                    $model = new \App\Models\BookImage();
                    $model->book_id = $bookId;
                    $model->file = sprintf('https://images.betterworldbooks.com/%s', $book->ImageURL);
                    $model->save();

                    // book_author
                    foreach ($authorIds as $authorId) {
                        $model = new \App\Models\BookAuthor();
                        $model->book_id = $bookId;
                        $model->author_id = $authorId;
                        $model->save();
                    }

                    // book_category
                    foreach ($categoryIds as $categoryId) {
                        $model = new \App\Models\BookCategory();
                        $model->book_id = $bookId;
                        $model->category_id = $categoryId;
                        $model->save();
                    }
                } catch (\Exception $e) {
                    DB::rollback();
                    $this->error($e->getMessage());
                    return;
                    continue;
                }
                DB::commit();

                dd($book);
            }
        }

    }

    private function getDate()
    {
        return $this->argument('date') ? $this->argument('date'): (new \DateTime())->format('Ymd');
    }
}
