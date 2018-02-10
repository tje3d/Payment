<?php

namespace Tje3d\Payment\Exceptions;

class OrderException extends \Exception {
    protected $id;
    protected $message;

    public function __construct($id, $message)
    {
        $this->id = $id;
        $this->message = $message;
    }

    public function getId()
    {
        return $this->id;
    }
}