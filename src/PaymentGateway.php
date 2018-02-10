<?php

namespace Tje3d\Payment;

use GuzzleHttp\Client as HttpClient;

abstract class PaymentGateway
{
    protected $httpClient;
    protected $apiKey;
    protected $urlOrder;
    protected $urlVerify;
    protected $callBackUrl;

    public function __construct()
    {
        $config = $this->configurations();

        $this->apiKey      = array_get($config, 'apiKey', false);
        $this->urlOrder    = array_get($config, 'urlOrder', false);
        $this->urlVerify   = array_get($config, 'urlVerify', false);
        $this->callBackUrl = array_get($config, 'callBackUrl', false);
        $this->httpClient  = new HttpClient;
    }

    public function configurations() {return [];}
    public function order(array $config) {return false;}
    public function verify(array $config) {return false;}
}
