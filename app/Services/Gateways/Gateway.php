<?php

namespace App\Services\Gateways;

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

    abstract protected function init();
    abstract protected function createCustomer();
    abstract protected function createCard();
    abstract protected function charge();
    abstract protected function createTransaction(\Exception $e = null);
}
