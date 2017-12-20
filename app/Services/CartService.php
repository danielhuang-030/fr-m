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
     * @return void
     * @throws \Exception
     */
    public function add(int $id = 0, int $quantity = 1)
    {
        // validate
        $bookCondition = $this->validate($id, $quantity);
        $book = $bookCondition->book;

        // check cart, upsert
        $item = Cart::get($id);
        if ($item instanceof \Darryldecode\Cart\ItemCollection) {
            Cart::update($id, [
                'quantity' => $quantity,
            ]);
        } else {
            $bookPresenter = new \App\Presenters\BookPresenter();
            $cartData = [
                'id' => $id,
                'name' => $book->title,
                'price' => $bookCondition->price,
                'quantity' => $quantity,
                'attributes' => [
                    'condition' => $bookCondition->condition,
                    'url' => $bookPresenter->getLink($book),
                    'cover' => $bookPresenter->getCover($book),
                    'stock' => $bookCondition->quantity,
                ],
            ];
            Cart::add($cartData);
        }
        return;
    }

    /**
     * update
     *
     * @param int $id
     * @param int $quantity
     * @return void
     * @throws \Exception
     */
    public function update(int $id = 0, int $quantity = 1)
    {
        // validate
        $book = $this->validate($id, $quantity, true);

        // check cart, update
        $item = Cart::get($id);
        if (!$item instanceof \Darryldecode\Cart\ItemCollection) {
            throw new \Exception(sprintf('"%s" is not in the cart', $book->title));
            return;
        }
        Cart::update($id, [
            'quantity' => [
                'relative' => false,
                'value' => $quantity,
            ],
        ]);
        return;
    }

    /**
     * remove
     *
     * @param int $id
     * @return void
     */
    public function remove(int $id = 0)
    {
        Cart::remove($id);
    }

    /**
     * renew
     *
     * @param array $idQtyPair
     * @return void
     */
    public function renew(array $idQtyPair = [])
    {
        if (empty($idQtyPair) || Cart::isEmpty()) {
            Cart::clear();
            return;
        }

        $items = Cart::getContent();
        foreach ($items as $item) {
            $id = $item->id;
            if (!array_key_exists($id, $idQtyPair) || 0 === (int) $idQtyPair[$id]) {
                Cart::remove($id);
                continue;
            }
            $this->update($item->id, $idQtyPair[$id]);
        }
        return;
    }

    /**
     * validate
     *
     * @param int $id
     * @param int $quantity
     * @param bool $isUpdate
     * @return \App\Models\BookCondition
     * @throws \Exception
     */
    protected function validate(int $id = 0, int $quantity = 1, $isUpdate = false)
    {
        // check book exist and in stock
        $model = new \App\Models\BookCondition();
        $bookCondition = $model->with(['book'])->where('id', $id)->inStock()->first();
        if (!$bookCondition instanceof \App\Models\BookCondition) {
            throw new \Exception(sprintf('"%s" does not exist or is not in stock', $bookCondition->book->title));
        }

        // check stock quantity
        $item = Cart::get($id);
        if ($item instanceof \Darryldecode\Cart\ItemCollection && !$isUpdate) {
            $quantity += $item->quantity;
        }
        if ($bookCondition->quantity < $quantity) {
            throw new \Exception(sprintf('"%s" not enough stock', $bookCondition->book->title));
        }
        return $bookCondition;
    }

}