<?php

namespace App\Services\Gateways;

use DB;

class Stripe extends Gateway
{
    protected function init()
    {
        $config = json_decode($this->gateway->config);
        \Stripe\Stripe::setApiKey($config->secretKey);
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
        if (empty($this->inputData['card'])) {
            throw new \Exception('No credit card data from input');
        }
        $cardData = $this->inputData['card'];

        // check from payment_profiles
        $isExist = false;
        $model = new \App\Models\PaymentProfiles();
        $paymentProfiles = $model->where('user_id', $this->user->id)->get();
        foreach ($paymentProfiles as $paymentProfile) {
            if ($cardData['number'] == $paymentProfile->card_number && $cardData['exp_month'] == $paymentProfile->expiration_month && $cardData['exp_year'] == $paymentProfile->expiration_year) {
                $this->paymentProfile = $paymentProfile;
                $isExist = true;
                break;
            }
        }

        // if exist, return
        if ($isExist) {
            return;
        }

        // add card
        DB::beginTransaction();
        try {
            // add card to Stripe
            $token = \Stripe\Token::create([
                'card' => $cardData,
                // 'customer' => $customer,
            ]);
            $card = $customer->sources->create([
                'source' => $token->id
            ]);

            // add card to payment_profiles
            $paymentProfile = new \App\Models\PaymentProfiles();
            $paymentProfile->card_type = strtolower($card->brand);
            $paymentProfile->card_number = $cardData['number'];
            $paymentProfile->expiration_month = $cardData['exp_month'];
            $paymentProfile->expiration_year = $cardData['exp_year'];
            $paymentProfile->user_id = $this->user->id;
            $paymentProfile->gateway_id = $this->gateway->id;
            $paymentProfile->external_id = $card->id;
            $paymentProfile->funding_type = strtolower($card->funding);
            $paymentProfile->vault_token = $card->customer;
            $paymentProfile->save();
            $this->paymentProfile = $paymentProfile;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();
        return;
    }

    protected function charge()
    {
        if (null === $this->paymentProfile) {
            throw new \Exception('No PaymentProfile data');
        }

        $this->transaction = \Stripe\Charge::create([
            'amount' => $this->inputData['amount'] * 100,
            'currency' => $this->inputData['currency'],
            'customer' => $this->user->external_id,
            'source' => $this->paymentProfile->external_id,
            'description' => $this->inputData['description']
        ]);
    }

    protected function createTransaction(\Exception $e = null)
    {
        $status = 'succeed';
        $type = 'charge';

        $transaction = new \App\Models\Transaction();
        if ($e instanceof \Exception) {
            $transaction->fail_reason = $e->getMessage();
            $now = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $transaction->failed_at = $now;
            $transaction->traded_at = $now;
            $status = 'failed';
        } else {
            $chargeTime = \Carbon\Carbon::createFromFormat('U', $this->transaction->created)->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s');
            $transaction->charged_at = $chargeTime; // $this->transaction->created;
            $transaction->traded_at = $chargeTime;
        }

        $transaction->user_id = $this->user->id ?? null;
        $transaction->order_id = $this->inputData['order_id'] ?? null;
        $transaction->amount_in_cents = $this->inputData['amount'] * 100 ?? null;
        $transaction->currency = strtoupper($this->inputData['currency']) ?? null;
        $transaction->status = $status;
        $transaction->type = $type;
        $transaction->payment_profile_id = $this->paymentProfile->id ?? null;
        $transaction->gateway_id = $this->gateway->id ?? null;
        $transaction->gateway_transaction_id = $this->transaction->id ?? null;
        $transaction->save();

    }
}

