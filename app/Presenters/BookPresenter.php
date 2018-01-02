<?php

namespace App\Presenters;

use App\Models\Book;
use Storage;

class BookPresenter
{
    /**
     * default image
     *
     * @var string
     */
    const DEFAULT_IMAGE = '/images/no-image.png';

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
            $links[] = url(static::DEFAULT_IMAGE);
            return $links;
        }
        foreach ($images as $image) {
            $link = $image->file;
            if (empty($image->file)) {
                $link = url(static::DEFAULT_IMAGE);
            }
            $links[] = starts_with($link, 'http') ? $link : Storage::disk('public')->url(sprintf('%s/%s', config('web.dir.book'), $image->file));
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