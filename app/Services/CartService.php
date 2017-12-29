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
        if (null !== $item) {
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
        $bookCondition = $this->validate($id, $quantity, true);

        // check cart, update
        $item = Cart::get($id);
        if (null === $item) {
            throw new \Exception(sprintf('"%s" is not in the cart', $bookCondition->book->title));
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
        if (null !== $item && !$isUpdate) {
            $quantity += $item->quantity;
        }
        if ($bookCondition->quantity < $quantity) {
            throw new \Exception(sprintf('"%s" not enough stock', $bookCondition->book->title));
        }
        return $bookCondition;
    }

    /**
     * add shipping condition
     */
    public function addConditionShipping()
    {
        // reset
        Cart::removeConditionsByType('shipping');
        
        // fixed fee
        $condition = new \Darryldecode\Cart\CartCondition([
            'name' => 'shipping',
            'type' => 'shipping',
            'target' => 'subtotal',
            'value' => '0',
            'order' => 9000,
            'attributes' => [
                'name' => 'Shipping',
                'description' => 'Shipping',
            ],
        ]);
        Cart::condition($condition);
    }

    /**
     * add carbon balance condition
     */
    public function addConditionCarbonBalance()
    {
        // reset
        Cart::removeConditionsByType('carbon_balance');

        // fixed fee
        $condition = new \Darryldecode\Cart\CartCondition([
            'name' => 'carbon_balance',
            'type' => 'carbon_balance',
            'target' => 'subtotal',
            'value' => '+0.05',
            'order' => 9999,
            'attributes' => [
                'name' => 'Carbon Balance',
                'description' => 'Carbon Balance',
            ],
        ]);
        Cart::condition($condition);
    }

    /**
     * add tax condition
     *
     * @param int $stateId
     */
    public function addConditionTax(int $stateId)
    {
        // reset
        Cart::removeConditionsByType('tax');

        // get state data with tax
        $model = new \App\Models\State();
        $state = $model->with(['tax'])->find($stateId);
        if (null === $state || null === $state->tax) {
            return;
        }

        // add tax condition
        $condition = new \Darryldecode\Cart\CartCondition([
            'name' => sprintf('%s_tax', strtolower($state->name)),
            'type' => 'tax',
            'target' => 'subtotal',
            'value' => sprintf('+%s%%', $state->tax->tax),
            'order' => 100,
            'attributes' => [
                'name' => sprintf('State Tax(%s)', $state->name),
                'description' => sprintf('State Tax(%s)', $state->name),
            ],
        ]);
        Cart::condition($condition);
    }

    /**
     * clear items and conditions
     */
    public function clearAll()
    {
        Cart::clear();
        Cart::clearCartConditions();
    }

    /**
     * clear conditions
     */
    public function clearConditions()
    {
        Cart::clearCartConditions();
    }

    /**
     * get all items
     *
     * @return \Darryldecode\Cart\CartCollection
     */
    public function getItems()
    {
        return Cart::getContent();
    }

    /**
     * get all collections
     *
     * @return \Darryldecode\Cart\CartCondition
     */
    public function getConditions()
    {
        return Cart::getConditions();
    }

    /**
     * cart is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return Cart::isEmpty();
    }

    public function getSubTotal()
    {
        return Cart::getSubTotal();
    }

    public function getTotal()
    {
        return Cart::getTotal();
    }
}