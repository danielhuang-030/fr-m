<?php

namespace App\Http\Controllers\Home;

use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class PaymentsController extends BaseController
{
    /**
     * PaymentService
     *
     * @var PaymentService
     */
    protected $paymentService;


    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index()
    {
        $gatewayName = 'stripe';
        $r = $this->paymentService->pay([
            'user_id' => 22,
            'card' => [
                'number'    => '4242424242424242',
                'exp_month' => 10,
                'cvc'       => 314,
                'exp_year'  => 2020,
            ],
        ], $gatewayName);

        $model = new \App\Models\Gateway();
        $gateway = $model->where('name', $gatewayName)->first();
        $config = json_decode($gateway->config);

        $email = 'daniel.simplybridel@gmail.com';

        $cardData = [
            'card' => [
                'number'    => '4242424242424242',
                'exp_month' => 10,
                'cvc'       => 314,
                'exp_year'  => 2020,
            ],
        ];
        \Stripe\Stripe::setApiKey($config->secretKey);

        $customer = \Stripe\Customer::create([
            'email' => $email,
        ]);
        $cId = $customer->id;
        $token = \Stripe\Token::create($cardData);
        $tId = $token->id;
        $card = $customer->sources->create([
            'source' => $tId
        ]);

        $token = \Stripe\Token::create($cardData);
        $tId = $token->id;
        $r = \Stripe\Charge::create([
            'amount' => 1099,
            'customer' => 'cus_4EBumIjyaKooft',
            'source' => $tId,
            'description' => "charge test from daniel 2017-12-25 002"
        ]);
        dd($customer, $token, $card, $r);

        // \App\Services\PaymentService::create('test');






        $customer = \Stripe\Customer::retrieve("cus_C0nWQqTqD1rtyP");
        $customer->sources->create(array("source" => "tok_amex"));
        dd($r);



        $gatewayName = 'stripe';
        return $payumService->capture($gatewayName, function (
            PaymentInterface $payment,
            $gatewayName,
            StorageInterface $storage,
            Payum $payum
        ) {
            $payment->setNumber(uniqid());
            $payment->setCurrencyCode('TWD');
            $payment->setTotalAmount(2000);
            $payment->setDescription('A description');
            $payment->setClientId('anId');
            $payment->setClientEmail('foo@example.com');
            $payment->setDetails([
                'Items' => [
                    [
                        'Name' => '歐付寶黑芝麻豆漿',
                        'Price' => (int) '2000',
                        'Currency' => '元',
                        'Quantity' => (int) '1',
                        'URL' => 'dedwed',
                    ],
                ],
            ]);
        });
    }

    public function done(PayumService $payumService, $payumToken)
    {
        return $payumService->done($payumToken, function (
            GetHumanStatus $status,
            PaymentInterface $payment,
            GatewayInterface $gateway,
            TokenInterface $token
        ) {
            return response()->json([
                'status' => $status->getValue(),
                'client' => [
                    'id' => $payment->getClientId(),
                    'email' => $payment->getClientEmail(),
                ],
                'number' => $payment->getNumber(),
                'description' => $payment->getCurrencyCode(),
                'total_amount' => $payment->getTotalAmount(),
                'currency_code' => $payment->getCurrencyCode(),
                'details' => $payment->getDetails(),
            ]);
        });
    }
}
