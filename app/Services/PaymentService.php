<?php

namespace App\Services;

use Cart;

class PaymentService
{
    /**
     * construct
     */
    public function __construct()
    {
    }

    public function pay(array $inputData = [], string $gatewayName = 'stripe')
    {
        // get user
        if (empty($inputData['user_id'])) {
            throw new Exception('Can not get user');
        }
        $model = new \App\Models\User();
        $user = $model->with('gateway')->find($inputData['user_id']);
        if (null === $user) {
            throw new Exception('Can not get user');
        }

        // get payment gateway
        $gateway = $this->gatewayFactory($gatewayName, $user);
        if (null === $gateway) {
            throw new Exception('Can not get payment gateway');
        }
        return $gateway->pay($inputData, $user);
    }

    /**
     * gateway factory
     *
     * @param string $gatewayName
     * @return \App\Services\Gateways\Gateway
     */
    protected function gatewayFactory(string $gatewayName = 'stripe', $user)
    {
        if (!empty($user->gateway)) {
            // get gateway by user
            $gateway = $user->gateway;
        } else {
            // get gateway by name
            $model = new \App\Models\Gateway();
            $gateway = $model->where('name', $gatewayName)->first();
            if (null === $gateway) {
                return null;
            }

            // set user gateway
            $user->gateway_id = $gateway->id;
            $user->save();
        }

        // get payment gateway
        $className = sprintf('\App\Services\Gateways\%s', $gateway->factory);
        return new $className(json_decode($gateway->config));
    }

}
