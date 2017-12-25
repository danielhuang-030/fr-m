<?php

return [
    'gateway' => [
        'stripe' => [
            'factory'  => 'GatewayStripe',
            'publishableKey' => env('STRIPE_PUBLISHABLE_KEY'),
            'secretKey' => env('STRIPE_SECRET_KEY'),
        ],
    ],
];
