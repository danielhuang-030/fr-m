<?php

namespace App\Services\Gateways;

use DB;

abstract class Gateway
{
    protected $gateway;
    protected $user;
    protected $paymentData;
    protected $paymentProfile;
    protected $transaction;

    public function __construct(\App\Models\Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function pay(array $paymentData = [], \App\Models\User $user = null)
    {
        $this->user = $user;
        $this->paymentData = $paymentData;

        try {
            $this->init();
            $this->createCustomer();
            $this->createCard();
            $this->charge();
            $this->createTransaction();
            $this->updateOrder();
        } catch (\Exception $e) {
            $this->createTransaction($e);
            throw $e;
            // return false;
        }

        return $this->transaction->id;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    protected function getCardData()
    {
        $cardData = [];
        if (empty($this->paymentData['card'])) {
            return $cardData;
        }

        return [
            'number' => $this->paymentData['card']['number'],
            'exp_month' => $this->paymentData['card']['exp_month'],
            'exp_year' => $this->paymentData['card']['exp_year'],
            'cvc' => $this->paymentData['card']['cvc'],
        ];
    }

    protected function updateOrder()
    {
        $model = new \App\Models\Order();
        $order = $model->find($this->transaction->order_id);

        // update order
        DB::beginTransaction();
        try {
            // update order status
            if (!$order->updateStatus('processing')) {
                throw new \Exception('Order status update failed');
            }

            // update order detail status
            foreach ($order->details as $orderDetail) {
                $orderDetail->status = 'processing';
                $orderDetail->save();
            }

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    abstract protected function init();
    abstract protected function createCustomer();
    abstract protected function createCard();
    abstract protected function charge();
    abstract protected function createTransaction(\Exception $e = null);

}
