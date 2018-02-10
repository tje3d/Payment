<?php

namespace Tje3d\Payment\Contracts;

interface PaymentGateway
{
    /**
     * Get gateway configurations
     */
    public function configurations();

    /**
     * Create a new order
     */
    public function order(array $config);

    /**
     * Verify payment
     */
    public function verify(array $config);
}