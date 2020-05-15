<?php

namespace PonyFire\Router\Exceptions;

class RouteNotFoundException extends \PonyFire\PonyFireException
{
    public function __construct($message = '')
    {
        $this->message = $message;
    }
}
