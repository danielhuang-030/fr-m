<?php

namespace App\Services\Gateways;

class Stripe extends Gateway
{
    public function __construct($config)
    {
        parent::__construct($config);

        \Stripe\Stripe::setApiKey($this->config->secretKey);
    }

    protected function createCustomer()
    {
        if (!empty($this->user->external_id)) {
            return;
        }

        $customer = \Stripe\Customer::create([
            'email' => $this->user->email,
        ]);
        if (null === $customer) {
            throw new \Exception('Can not create customer');
        }
        $this->user->external_id = $customer->id;
        $this->user->save();
    }

    protected function createCard()
    {
        $customer = \Stripe\Customer::retrieve($this->user->external_id);
        $token = \Stripe\Token::create([
            'card' => $this->inputData['card'],
            // 'customer' => $customer,
        ]);
        $card = $customer->sources->create([
            'source' => $token->id
        ]);
        dd($card);

    }

    protected function charge()
    {

    }

    protected function createPaymentProfile()
    {}
    protected function createTransaction()
    {}
}

