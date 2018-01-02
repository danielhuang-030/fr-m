<?php

namespace App\Services;

use DB;
use Mail;
use App\Services\CartService;
use App\Services\PaymentService;
use App\Mail\UserCreateWhenCheckout;

class CheckoutService
{
    protected $cartService;
    protected $paymentService;

    protected $errorMessage;

    public function __construct(CartService $cartService, PaymentService $paymentService)
    {
        $this->cartService = $cartService;
        $this->paymentService = $paymentService;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function order(array $inputData = [], int $userId = 0)
    {
        if (empty($inputData)) {
            return 0;
        }

        // create user by email
        if (0 === $userId) {
            $email = (string) $inputData['email'] ?? '';
            $user = $this->createUserByEmail($email);
            if (null === $user) {
                return 0;
            }
            $userId = $user->id;

            // auto login
            auth()->loginUsingId($userId);
        }

        // create order
        $orderId = (int) $inputData['order_id'] ?? 0;
        $model = new \App\Models\Order();
        $order = $model->with(['statuses', 'fees', 'details', 'shippingState', 'billingState'])->find($orderId);
        if (null === $order) {
            DB::beginTransaction();
            try {
                // check cart
                if ($this->cartService->isEmpty()) {
                    throw new \Exception('Cart is empty');
                }

                // add order
                $order = new \App\Models\Order();
                $order->user_id = $userId;

                // shipping and billing
                foreach ($inputData as $inputType => $inputValues) {
                    if (is_array($inputValues)) {
                        foreach ($inputValues as $name => $value) {
                            switch ($inputType) {
                                case 'shipping':
                                case 'billing':
                                    $column = sprintf('%s_%s', $inputType, $name);
                                    $order->$column = $value;
                                    break;
                            }
                        }
                    }
                }
                $order->user_id = $userId;
                $order->memo = $inputData['memo'];
                $order->subtotal = $this->cartService->getSubTotal();
                $order->original_total = $this->cartService->getTotal();
                $order->total = $this->cartService->getTotal();
                $order->status = 'pending';
                $order->save();
                $orderId = $order->id;

                // get cart items
                $items = $this->cartService->getItems();
                foreach ($items as $item) {
                    // add order details
                    $orderDetail = new \App\Models\OrderDetail();
                    $orderDetail->order_id = $orderId;
                    $orderDetail->book_id = $item->id;
                    $orderDetail->title = $item->name;
                    $orderDetail->condition = $item->attributes->condition;
                    $orderDetail->quantity = $item->quantity;
                    $orderDetail->price = $item->price;
                    $orderDetail->status = 'pending';
                    $orderDetail->save();
                }

                // get cart conditions
                $conditions = $this->cartService->getConditions();

                if (!$conditions->isEmpty()) {
                    foreach ($conditions as $condition) {
                        // add order fees
                        $orderFee = new \App\Models\OrderFee();
                        $orderFee->order_id = $orderId;
                        $orderFee->type = $condition->getType();
                        $orderFee->name = $condition->getAttributes()['name'];
                        $orderFee->total = $condition->getCalculatedValue($order->subtotal);
                        $orderFee->sort = $condition->getOrder();
                        $orderFee->meta = array_merge([
                            'key' => $condition->getName(),
                            'value' => $condition->getValue(),
                        ], $condition->getAttributes());
                        $orderFee->save();
                    }
                }

                // add order status
                $orderStatus = new \App\Models\OrderStatus();
                $orderStatus->order_id = $orderId;
                $orderStatus->status = 'pending';
                $orderStatus->save();

            } catch (\Exception $e) {
                DB::rollBack();
                $this->errorMessage = $e->getMessage();
                return 0;
            }
            DB::commit();
        }

        // build payment data
        $paymentData['user_id'] = $userId;
        $paymentData['order_id'] = $orderId;
        $paymentData['amount'] = $order->total;
        $paymentData['currency'] = 'USD';
        $paymentData['description'] = sprintf('Test by daniel at %s, total $%s, order id: %d', date('Y-m-d H:i:s'), $order->total, $orderId);

        // build payment card data
        list($expiryMonth, $expiryYear) = explode('/', $inputData['card']['expiry']);
        $paymentData['card'] = [
            'number' => preg_replace('#\s+#', '', $inputData['card']['number']),
            'exp_month' => sprintf('%02d', $expiryMonth),
            'exp_year' => sprintf('20%02d', $expiryYear),
            'cvc' => $inputData['card']['cvc'],
        ];

        // create payment
        try {
            // payment pay
            $paymentResult = $this->paymentService->pay($paymentData);
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
            $paymentResult = false;
        }

        // order succeed, but payment fail
        if (!$paymentResult) {
            return $orderId;
        }
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

        // send email
        Mail::to($user->email)->send((new UserCreateWhenCheckout($user))->with('password', $password));

        return $user;
    }

}