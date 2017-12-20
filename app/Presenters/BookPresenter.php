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

        $images = $book->images;
        if (0 === $images->count()) {
            return $links;
        }
        foreach ($images as $image) {
            $links[] = starts_with($image->file, 'http') ? $image->file : Storage::disk('public')->url(sprintf('%s/%s', config('web.dir.book'), $image->file));
        }
        return $links;
    }

    /**
     * get first images
     *
     * @param Book $book
     * @return string
     */
    public function getCover(Book $book)
    {
        $links = $this->getImageLinks($book);
        return empty($links) ? '' : current($links);
    }

    /**
     * get link
     *
     * @param Book $book
     * @return string
     */
    public function getLink(Book $book)
    {
        return url(sprintf('book/%s', $book->slug));
    }

    /**
     * get lowest price
     *
     * @param Book $book
     * @return float
     */
    public function getPrice(Book $book)
    {
        $conditions = $book->conditions;
        if (0 === $conditions->count()) {
            return 0.0;
        }
        $namePricePair = [];
        foreach ($conditions as $condition) {
            $namePricePair[$condition->name] = $condition->price;
        }
        asort($namePricePair);
        return (float) current($namePricePair);
    }

}