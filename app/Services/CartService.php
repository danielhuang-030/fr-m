<?php

namespace App\Services;

use Cart;

class CartService
{
    public function add($id = 0, $quantity = 1, $condition = 'new')
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
            $cartData = [
                'id' => $id,
                'name' => $book->title,
                'price' => $bookCondition->price,
                'quantity' => $quantity,
                'attributes' => [
                    'condition' => $condition,
                ],
            ];
            Cart::add($cartData);
        }
        return;
    }

    public function remove($id = 0)
    {
        Cart::remove($id);
    }

}