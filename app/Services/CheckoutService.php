<?php

namespace App\Services;

use DB;
use App\Services\CartService;

class CheckoutService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function order(array $inputData = [], int $userId = 0)
    {
        // dd($inputData, $userId);
        if (empty($inputData)) {
            return 0;
        }

        // create user by email
        if (0 === $userId) {
            $user = $this->createUserByEmail($email);
            if (null === $user) {
                return 0;
            }
            $userId = $user->id;
        }

        // create order
        DB::beginTransaction();
        try {
            // add order
            $model = new \App\Models\Orders();

            // add order details

            // add order fees

            // add order status

        } catch (\Exception $e) {
            DB::rollBack();
            $e->getMessage();
        }
        DB::commit();

        return $orderId;
    }

    /**
     * create user by email
     *
     * @todo send email
     * @param string $email
     * @return \App\Models\User
     */
    public function createUserByEmail(string $email = '')
    {
        if (empty($email)) {
            return null;
        }

        // check from users
        $model = new \App\Models\User();
        if (null !== $model->where('email', $email)->first()) {
            return null;
        }

        // create user
        preg_match('#^(.*)@#i', $email, $matches);
        $name = $matches[1];
        $password = str_random(12);
        $user = new \App\Models\User();
        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->active_token = str_random(60);
        $user->save();

        // todo: send email
        // email content: active, change password

        return $user;
    }

}