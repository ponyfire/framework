<?php

namespace PonyFire\Router\Exceptions;

class InvalidArgumentException extends \PonyFire\PonyFireException
{
    public function __construct()
    {
        // TODO:Menambahkan pesan
        $this->message = '';
    }
}
