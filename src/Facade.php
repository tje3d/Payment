<?php

namespace Tje3d\Payment;

class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return Payment::class;
    }
}
