<?php

namespace App\Services;

class PaymentService
{
    public function pay(array $data = [], string $gatewayName = '')
    {
        // get user with gateway
        if (empty($data['user_id'])) {
            throw new Exception('Can not get user');
        }
        $model = new \App\Models\User();
        $user = $model->with('gateway')->find($data['user_id']);
        if (null === $user) {
            throw new Exception('Can not get user');
        }

        // get payment gateway
        $gateway = $this->gatewayFactory($user, $gatewayName);
        if (null === $gateway) {
            throw new Exception('Can not get payment gateway');
        }

        try {
            $result = $gateway->pay($data, $user);
        } catch (\Exception $e) {
            // $result = false;
            throw $e;
        }
        return $result;
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
                $gateway = $this->getGatewayByWeight();
                if (null === $gateway) {
                    return null;
                }
            }

            // set user gateway
            $user->gateway_id = $gateway->id;
            $user->save();
        }

        // get payment gateway
        $className = sprintf('\App\Services\Gateways\%s', $gateway->factory);
        return new $className($gateway);
    }

    protected function getGatewayByWeight()
    {
        $model = new \App\Models\Gateway();
        $gateways = $model->all();
        if (empty($gateways)) {
            return null;
        }

        $gatewayPair = [];
        $sum = 0;
        foreach ($gateways as $gateway) {
            $sum += $gateway->weight;
            $gatewayPair[$gateway->id] = $gateway;
        }

        $rand = rand(1, $sum);
        foreach ($gatewayPair as $id => $gateway) {
            if (($sum -= $gateway->weight) < $rand) {
                return $gateway;
            }
        }
        return null;
    }

    public function testGatewayWeight($count = 100)
    {
        $result = array();
        for ($i = 0; $i < $count; $i++) {
            $gateway = $this->getGatewayByWeight();
            @$result[$gateway->name]++;
        }
        dd($result);
    }

}
