<?php

namespace Tje3d\Payment;

use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/payment.php' => base_path('config/payment.php'),
        ], 'config');
    }
}
