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
        dd('charge');

        // $this->paymentService->testGatewayWeight(1000);
        $r = $this->paymentService->pay([
            'amount' => 1.99,
            'currency' => 'USD',
            'user_id' => 22,
            'card' => [
                'number'    => '4242424242424242',
                'exp_month' => 10,
                'cvc'       => 314,
                'exp_year'  => 2020,
            ],
            'description' => 'Charge daniel test 12/27 001.',
        ]);
        dd($r);
    }

    public function webhook(int $gatewayId = 0, Request $request)
    {
        $gatewayId = (int) $gatewayId;
        $model = new \App\Models\Gateway();
        $gateway = $model->find($gatewayId);
        if (null === $gateway) {
            return abort(404);
        }

        $model = new \App\Models\WebhookEvent();
        $model->name = $request->json('type');
        $model->external_id = $request->json('id');
        $model->gateway_id = $gateway->id;
        $model->type = $gateway->name;
        $model->raw_data = json_encode($request->json('data'));
        $model->created_at = $request->json('created');
        $model->save();

        // File::append(sprintf('%s/%s', storage_path('logs'), 'webhook.log'), var_export($request->json(), true) . PHP_EOL);
    }

    public function test()
    {
        auth()->loginUsingId(22, true);
        // \Auth::setUser(\Auth::user());
        // dd(auth()->user(), auth()->check());
        session()->put('login_test', 22);
        return;
    }

    public function check()
    {
        dd(auth()->user());
    }

}
