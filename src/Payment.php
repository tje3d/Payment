<?php

namespace Tje3d\Payment;

use Tje3d\Payment\Gateways\Nextpay\Nextpay;

class Payment
{
    public function nextpay()
    {
        static $gateway = null;
        if ($gateway !== null) {
            return $gateway;
        }

        return $gateway = new Nextpay;
    }
}
