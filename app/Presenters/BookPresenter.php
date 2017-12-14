<?php

namespace App\Presenters;

use App\Models\Book;
use Storage;

class BookPresenter
{
    /**
     * get image links
     *
     * @param Book $book
     * @return array
     */
    public function getImageLinks(Book $book)
    {
        $links = [];
        $images = $book->images()->get();
        if (0 === $images->count()) {
            return $links;
        }
        foreach ($images as $image) {
            $links[] = starts_with($image->file, 'http') ? $image->file : Storage::disk('public')->url(sprintf('%s/%s', config('web.dir.book'), $image->file));
        }
        return $links;
    }

    /**
     * get image real path
     *
     * @param Book $book
     * @return string
     */
//    public function getImageRealPath(Book $book)
//    {
//        return sprintf('%s/%s', static::IMAGE_PATH, sprintf('%03d', $book->id % 1000));
//    }

}