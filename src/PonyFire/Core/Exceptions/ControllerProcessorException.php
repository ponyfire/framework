<?php

namespace PonyFire\Core\Exceptions;

class ControllerProcessorException extends \PonyFire\PonyFireException
{
    public function __construct($message = '')
    {
        $this->message = $message;
    }
}