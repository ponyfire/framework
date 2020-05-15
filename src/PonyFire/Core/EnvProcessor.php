<?php

namespace PonyFire\Core;

use Dotenv\Dotenv;

class EnvProcessor extends Dotenv
{
    /**
     * Base path directory
     * 
     * @var string
     */
    protected string $basePath;

    /**
     * Nama file .env
     * 
     * @var string
     */
    protected string $envFileName;

    /**
     * @var DotEnv\DotEnv
     */
    protected Dotenv $dotEnv;

    /**
     * Inisialisasi property
     * 
     * @return void
     */
    public function __construct()
    {
        $this->basePath = BASE_PATH;
        $this->envFileName = '.env';
    }

    /**
     * Set base path file .env
     * 
     * @param string $path
     * 
     * @return \PonyFire\Core\EnvProcessor
     */
    public function setBasePath(string $path): EnvProcessor
    {
        $this->basePath = $path;
        return $this;
    }

    /**
     * Set nama file env
     * 
     * @param string $name
     * 
     * @return \PonyFire\Core\EnvProcessor
     */
    public function setFileName(string $name): EnvProcessor
    {
        $this->envFileName = $name;
        return $this;
    }

    public function load()
    {
        // Menyiapakan instansi
        $this->dotEnv = self::createMutable(
            $this->basePath, 
            $this->envFileName
        );


        // Menyiapkan variabel yang dibutuhkan
        $this->prepareRequiredVariables();

        // Mendaftarkan seluruh konfigurasi env
        $this->registerEnv();
    }

    /**
     * Menyiapkan variabel-variabel yang diperlukan oleh aplikasi
     * pada environment
     * 
     * @return void
     */
    protected function prepareRequiredVariables()
    {
        $requiredVars = [];

        // Mendaftarkan seluruh variabel yang diperlukan
        foreach (array_keys($requiredVars) as $var)
        {
            if ( ! is_string($var))
            {
                throw new \InvalidArgumentException();
            }

            $this->dotEnv->required($var);
        }
    }

    /**
     * Mendaftarkan seluruh konfigurasi env yang sudah di set oleh user
     * dan menyimpannya di beberapa variabel global seperti, $_ENV, $_SERVER, ...
     * 
     * @return void
     */
    protected function registerEnv()
    {
        $this->dotEnv->load();
    }
}
