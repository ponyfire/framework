<?php

namespace PonyFire\Env;

use PonyFire\Env\Exceptions\EnvNotFoundException;
use PonyFire\Core\EnvProcessor;

class Loader
{
    /**
     * Set path env
     * 
     * @param string $envBasePath Base path directory tempat file .env disimpan
     * 
     * @throws \PonyFire\Env\Exceptions\EnvNotFoundException
     * @return void
     */
    public static function load(string $envBasePath)
    {
        $processor = new EnvProcessor();

        // Jika file env tidak ditemukan
        if ( ! is_dir($envBasePath))
        {
            throw new EnvNotFoundException();
        }

        $processor->setBasePath($envBasePath)
                    ->setFileName('.env')
                    ->load();
    }
}