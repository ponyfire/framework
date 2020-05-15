<?php

namespace PonyFire\Core;

use Exception;
use PonyFire\Http\Request;
use PonyFire\Core\Exceptions\RouterProcessorException;
use PonyFire\Router\Exceptions\InvalidArgumentException;
use FastRoute\Dispatcher;

class RouterProcessor
{
    /**
     * @var string $method
     */
    protected string $method;

    /**
     * @var string
     */
    protected string $uri;

    /**
     * @var \FastRoute\Dispatcher
     */
    protected Dispatcher $dispatcher;

    public function __construct()
    {
        $this->method = '';
        $this->uri = '';
    }

    /**
     * @param string $method Metode HTTP Request
     * 
     * @return \PonyFire\Core\RouterProcessor
     */
    public function setMethod(string $method): RouterProcessor
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param string $uri URI yang di input user
     * 
     * @return \PonyFire\Core\RouterProcessor
     */
    public function setUri(string $uri): RouterProcessor
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @param \FastRoute\Dispatcher
     * 
     * @return \PonyFire\Core\RouterProcessor
     */
    public function setDispatcher(Dispatcher $dispatcher): RouterProcessor
    {
        $this->dispatcher = $dispatcher;
        return $this;
    }

    public function execute()
    {
        $routeInfo = $this->dispatcher->dispatch(
            $this->method, 
            $this->uri
        );

        switch ($routeInfo[0])
        {
            case Dispatcher::NOT_FOUND:
                // Memberikan response page not found
            break;
            case Dispatcher::METHOD_NOT_ALLOWED:
            break;
                // Memberikan response page not found
            case Dispatcher::FOUND:
                // Eksekusi handler
                $handler = $routeInfo[0];
                $params = $routeInfo[1];

                // TODO: Menambahkan $params pada request

                $this->processHandler($handler, $params);
            break;
        }
    }

    /**
     * Memproses handler yang sudah disediakan
     * 
     * @param string|callback $handler
     * @param array $params
     * 
     * @return void
     */
    protected function processHandler($handler, array $params)
    {
        // Jika handler bertipe string
        // Maka class controller akan di eksekusi
        if (is_string($handler))
        {
            /** @var \PonyFire\Core\ControllerProcessor */
            $controller = new ControllerProcessor();
            $controllerDelimiter = '::'; 

            $handler = explode($controllerDelimiter, $handler);
            $class = $handler[0];
            $method = $handler[1] ?? 'index';
            
            // Mengeksekusi controller
            $controller->call($class, $method);
        }
        // Jika handler bertipe callable/function
        // Maka $handler akan dipanggil langsung sebagai callable
        elseif (is_callable($handler))
        {
            $controller->callCallable($handler);
        }
        else
        {
            throw new InvalidArgumentException();
        }
    }
}