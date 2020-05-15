<?php

namespace PonyFire\Core;

use PonyFire\Core\Exceptions\ControllerProcessorException;

class ControllerProcessor
{
    /**
     * Namespace HTTP Controller
     * 
     * @var string
     */
    protected const CONTROLLER_NS = '\\App\\Http\\Controllers\\';

    /**
     * Memanggil file class controller
     * 
     * @param string $class  Nama kelas controller yang akan dieksekusi
     * @param string $method Nama method yang akan dieksekusi (default: index)
     * 
     * @return void
     */
    public function call(string $class, string $method = 'index')
    {
        $class = self::CONTROLLER_NS . $class;

        // Validasi ketersediaan class controller
        if ( ! class_exists($class))
        {
            throw new ControllerProcessorException("Controller {$class} not found");
        }

        // Membuat instansi baru untuk kelas controller
        $controller = new $class();

        if ( ! method_exists($controller, $method))
        {
            throw new ControllerProcessorException("Method {$method} not found in class {$class}");
        }

        // TODO: Menambahkan request object kedalam controller
        echo $controller->{$method}();
    }

    /**
     * Memanggil handler yang berupa callable
     * 
     * @param callback $handler
     * 
     * @return void
     */
    public function callCallable(callable $handler)
    {
        
    }
}
