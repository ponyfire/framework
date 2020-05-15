<?php

namespace PonyFire\Env\Exceptions;

class EnvNotFoundException extends \PonyFire\PonyFireException
{
    public function __construct()
    {
        $this->message = 'Env base path directory is not found.';
    }
}