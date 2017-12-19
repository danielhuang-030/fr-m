<?php

namespace App\Services;

use Cart;

class CartService
{
    /**
     * construct
     */
    public function __construct()
    {
        // fix fee
        $condition = new \Darryldecode\Cart\CartCondition([
            'name' => 'FEE',
            'type' => 'misc',
            'target' => 'subtotal',
            'value' => '+0.05',
            'attributes' => [
                'description' => 'Fix fee',
            ],
        ]);
        Cart::condition($condition);
    }

    /**
     * add
     *
     * @param int $id
     * @param int $quantity
     * @param string $condition
     * @throws \Exception
     */
    public function add(int $id = 0, int $quantity = 1, string $condition = 'new')
    {
        // check book exist and in stock
        $model = new \App\Models\Book();
        $book = $model->select('books.*')
            ->with('conditions')
            ->join('book_conditions', 'book_conditions.book_id', '=', 'books.id')
            ->where('books.id', $id)
            ->where('book_conditions.condition', $condition)
            ->where('book_conditions.in_stock', 1)
            ->where('book_conditions.quantity', '>', 0)
            ->first();
        if (!$book instanceof \App\Models\Book) {
            throw new \Exception('Book does not exist or is not in stock');
        }

        // check cart
        $item = Cart::get($id);
        // var_dump($item);exit;
        if ($item instanceof \Darryldecode\Cart\ItemCollection) {
            $quantity += $item->quantity;
        }

        // check stock quantity
        $bookCondition = $book->conditions()->first();
        if ($bookCondition->quantity < $quantity) {
            throw new \Exception('Not enough stock');
        }

        // upsert
        if ($item instanceof \Darryldecode\Cart\ItemCollection) {
            Cart::update($id, [
                'quantity' => [
                    'relative' => false,
                    'value' => $quantity,
                ],
            ]);
        } else {
            $bookPresenter = new \App\Presenters\BookPresenter();
            $cartData = [
                'id' => $id,
                'name' => $book->title,
                'price' => $bookCondition->price,
                'quantity' => $quantity,
                'attributes' => [
                    'condition' => $condition,
                    'url' => $bookPresenter->getLink($book),
                    'cover' => current($bookPresenter->getImageLinks($book)),
                    'stock' => $bookCondition->quantity,
                ],
            ];
            Cart::add($cartData);
        }
        return;
    }

    /**
     * remove
     *
     * @param int $id
     */
    public function remove(int $id = 0)
    {
        Cart::remove($id);
    }

}