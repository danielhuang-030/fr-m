<?php

namespace App\Services\Gateways;

abstract class Gateway
{
    protected $config;
    protected $user;
    protected $inputData;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function pay(array $inputData = [], \App\Models\User $user)
    {
        $this->user = $user;
        $this->inputData = $inputData;

        $this->createCustomer();
        $this->createCard();
        dd($this->user);
        $this->charge();
        $this->createPaymentProfile();
        $this->createTransaction();

        return;
    }

    abstract protected function createCustomer();
    abstract protected function createCard();
    abstract protected function charge();
    abstract protected function createPaymentProfile();
    abstract protected function createTransaction();
}
