<?php

namespace App\Services\Gateways;

abstract class Gateway
{
    protected $gateway;
    protected $user;
    protected $inputData;
    protected $paymentProfile;
    protected $errorMessage;

    public function __construct(\App\Models\Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function pay(array $inputData = [], \App\Models\User $user)
    {
        $this->user = $user;
        $this->inputData = $inputData;

        try {
            $this->init();
            $this->createCustomer();
            $this->createCard();
            $this->charge();
            $this->createTransaction();
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }

        return;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    abstract protected function init();
    abstract protected function createCustomer();
    abstract protected function createCard();
    abstract protected function charge();

    abstract protected function createTransaction();
}
