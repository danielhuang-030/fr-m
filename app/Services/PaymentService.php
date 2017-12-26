<?php

namespace App\Services;

class PaymentService
{
    public function pay(array $inputData = [], string $gatewayName = '')
    {
        // get user with gateway
        if (empty($inputData['user_id'])) {
            throw new Exception('Can not get user');
        }
        $model = new \App\Models\User();
        $user = $model->with('gateway')->find($inputData['user_id']);
        if (null === $user) {
            throw new Exception('Can not get user');
        }

        // get payment gateway
        $gateway = $this->gatewayFactory($user, $gatewayName);
        if (null === $gateway) {
            throw new Exception('Can not get payment gateway');
        }

//        if (!$gateway->pay($inputData, $user)) {
//            dd($gateway->getErrorMessage());
//        }
//        return true;
        return $gateway->pay($inputData, $user);
    }

    /**
     * gateway factory
     *
     * @param \App\Models\User $user
     * @param string $gatewayName
     * @return \App\Services\Gateways\Gateway
     */
    protected function gatewayFactory(\App\Models\User $user, string $gatewayName = '')
    {
        if (!empty($user->gateway)) {
            // get gateway by user
            $gateway = $user->gateway;
        } else {
            if (!empty($gatewayName)) {
                // get gateway by name
                $model = new \App\Models\Gateway();
                $gateway = $model->where('name', $gatewayName)->first();
                if (null === $gateway) {
                    return null;
                }
            } else {
                // get gateway name by weight

            }

            // set user gateway
            $user->gateway_id = $gateway->id;
            $user->save();
        }

        // get payment gateway
        $className = sprintf('\App\Services\Gateways\%s', $gateway->factory);
        return new $className($gateway);
    }

}
