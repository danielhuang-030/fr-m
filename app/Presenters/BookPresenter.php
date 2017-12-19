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

    public function getLink(Book $book)
    {
        return url(sprintf('book/%s', $book->slug));
    }

}