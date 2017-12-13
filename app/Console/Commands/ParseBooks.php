<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;
use DB;

class ParseBooks extends Command
{
    /**
     * bwb image url
     *
     * @var string
     */
    const BWB_IMAGE_URL = 'https://images.betterworldbooks.com';

    /**
     * bwb ignore category names
     *
     * @var array
     */
    const BWB_IGNORE_CATEGORY_NAMES = [
        'Bargain Bin',
        'Clearance Sale',
    ];

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
        ini_set("memory_limit", "4096M");
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
                $this->error(sprintf('There is no data in this file,%s', $file));
                continue;
            }

            foreach ($books as $book) {
                // $this->info(sprintf('This book insert start,%s', $book->Isbn13));
//                if ('9780811857826' != $book->Isbn13) {
//                    continue;
//                }

                DB::beginTransaction();
                try {
                    // author
                    $authorIds = [];
                    $authorNames = $book->Authors;
                    foreach ($authorNames as $name) {
                        $model = new \App\Models\Author();
                        $slug = \Cviebrock\EloquentSluggable\Services\SlugService::createSlug(\App\Models\Book::class, 'slug', $name, ['unique' => false]);
                        $author = $model->where('slug', $slug)->first();
                        if (null === $author) {
                           $author = new \App\Models\Author();
                           $author->name = $name;
                           $author->save();
                        }
                        $authorIds[] = $author->id;
                    }
                    $firstAuthor = current($authorNames);

                    // category
                    $categoryIds = [];
                    $categoryStr = '';
                    $hasCategory = false;
                    for ($i = 2; $i >= 0; $i--) {
                        $propertyStr = sprintf('lvl%d', $i);

                        // is exist
                        if (empty($book->Categories->$propertyStr)) {
                            continue;
                        }

                        // ignore category name
                        $pattern = sprintf('#^(?:%s)#i', implode('|', static::BWB_IGNORE_CATEGORY_NAMES));
                        foreach ($book->Categories->$propertyStr as $tempIndex => $tempStr) {
                            preg_match($pattern, $tempStr, $matches);
                            if (empty($matches)) {
                                $categoryStr = $tempStr;
                                $hasCategory = true;
                                break 2;
                            }
                        }
                    }
                    if ($hasCategory) {
                        // Non-Classifiable special treatment
                        if (str_contains($categoryStr, 'Non-Classifiable')) {
                            $categoryStr = 'Non-Classifiable';
                        }

                        $categoryNames = explode(' > ', $categoryStr);
                        $parentCategory = null;
                        foreach ($categoryNames as $name) {
                            $model = new \App\Models\Category();
                            $currentCategory = $model->where('name', $name)->where('parent_id', empty($parentCategory) ? null : $parentCategory->id)->first();
                            if (null === $currentCategory) {
                               $currentCategory = new \App\Models\Category();
                               $currentCategory->name = $name;
                            }
                            if (!empty($parentCategory)) {
                                $currentCategory->parent_id = $parentCategory->id;
                                // $currentCategory->appendToNode($parentCategory)->save();
                            }
                            $currentCategory->save();
                            $categoryIds[] = $currentCategory->id;
                            $parentCategory = $currentCategory;
                        }
                    }

                    // book
                    $bwbId = $book->objectID;
                    $model = new \App\Models\Book();
                    $currentBook = $model->where('bwb_id', $bwbId)->first();
                    if (null === $currentBook) {
                        $currentBook = new \App\Models\Book();
                    }
                    $currentBook->title = $book->Title;
                    $currentBook->slug = \Cviebrock\EloquentSluggable\Services\SlugService::createSlug(\App\Models\Book::class, 'slug', sprintf('%s-%s-%s', $book->Title, $firstAuthor, $book->Isbn13));
                    $currentBook->bwb_id = $bwbId;
                    $currentBook->isbn10 = $book->Isbn10;
                    $currentBook->isbn13 = $book->Isbn13;
                    $currentBook->format = $book->Format;
                    $currentBook->weight = $book->Weight;
                    $currentBook->save();
                    $bookId = $currentBook->id;

                    // condition (delete before adding)
                    $availableCopies = $book->AvailableCopies;

                    $newCondition = null;
                    if (empty($availableCopies)) {
                        throw new \Exception('There is no condition for this book');
                        // $this->info(sprintf('There is no condition for this book,%s', $book->Isbn13));
                        // continue;
                    }
                    foreach ($availableCopies as $availableCopy) {
                        if ($availableCopy->IsNew) {
                            $newCondition = $availableCopy;
                        }
                    }
                    if (null === $newCondition) {
                        throw new \Exception('There is no new condition for this book');
                        // $this->info(sprintf('There is no new condition for this book,%s', $book->Isbn13));
                        // continue;
                    }
                    $model = new \App\Models\BookCondition();
                    $model->where('book_id', $bookId)->delete();
                    $bookCondition = new \App\Models\BookCondition();
                    $bookCondition->condition = 'new';
                    $bookCondition->quantity = $newCondition->Quantity;
                    $bookCondition->price = $newCondition->UnitPrice;
                    $bookCondition->in_stock = 1;
                    $bookCondition->book_id = $bookId;
                    $bookCondition->save();

                    // image (delete before adding)
                    $model = new \App\Models\BookImage();
                    $model->where('book_id', $bookId)->delete();
                    $bookImage = new \App\Models\BookImage();
                    $bookImage->book_id = $bookId;
                    $bookImage->file = sprintf('%s/%s', static::BWB_IMAGE_URL, $book->ImageURL);
                    $bookImage->save();

                    // book_author (delete before adding)
                    $model = new \App\Models\BookAuthor();
                    $model->where('book_id', $bookId)->delete();
                    foreach ($authorIds as $authorId) {
                        $bookAuthor = new \App\Models\BookAuthor();
                        $bookAuthor->book_id = $bookId;
                        $bookAuthor->author_id = $authorId;
                        $bookAuthor->save();
                    }

                    // book_category (delete before adding)
                    $model = new \App\Models\BookCategory();
                    $model->where('book_id', $bookId)->delete();
                    foreach ($categoryIds as $categoryId) {
                        $bookCategory = new \App\Models\BookCategory();
                        $bookCategory->book_id = $bookId;
                        $bookCategory->category_id = $categoryId;
                        $bookCategory->save();
                    }
                } catch (\Exception $e) {
                    DB::rollback();
                    $this->error(sprintf('%s,%s', $e->getMessage(), $book->Isbn13));

                    // return;
                    continue;
                }
                DB::commit();

                $this->info(sprintf('This book insert done,%s', $book->Isbn13));
            }
            // dd('1000 done.');
        }
    }

    private function getDate()
    {
        return $this->argument('date') ? $this->argument('date'): (new \DateTime())->format('Ymd');
    }

    public function info($string, $verbosity = null)
    {
        // log
        // $this->logOutputInfo(sprintf('info,%s', $string));

        parent::info($string, $verbosity);
    }

    public function error($string, $verbosity = null)
    {
        // log
        $this->logOutputInfo(sprintf('error,%s', $string));

        parent::error($string, $verbosity);
    }

    protected function logOutputInfo($string)
    {
        file_put_contents(sprintf('%s/parse_book.log', storage_path('logs')), $string . "\n", FILE_APPEND);
    }

}
