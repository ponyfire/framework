<?php

namespace PonyFire\Router;

use PonyFire\Router\Collections;
use PonyFire\Core\RouterProcessor;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Route
{
    /**
     * Insialisasi konfigurasi router
     */
    public static function init()
    {
        // Set konfigurasi dasar
        Collections::init();
    }

    /**
     * Route untuk GET request method
     * 
     * @param string $route 
     * @param string|callable $handler Handler aplikasi jika kondisi router true
     * 
     * @return void
     */
    public static function get(string $route = '', $handler = '')
    {
        Collections::addMethod('get', $route, $handler);
    }

    /**
     * Route untuk HEAD request method
     * 
     * @param string $route  
     * @param string|callable $handler Handler aplikasi jika kondisi router true
     * 
     * @return void
     */
    public static function head(string $route = '', $handler = '')
    {
        Collections::addMethod('head', $route, $handler);
    }

    /**
     * Route untuk POST request method
     * 
     * @param string $route  
     * @param string|callable $handler Handler aplikasi jika kondisi router true
     * 
     * @return void
     */
    public static function post(string $route = '', $handler = '')
    {
        Collections::addMethod('post', $route, $handler);
    }

    /**
     * Route untuk PUT request method
     * 
     * @param string $route  
     * @param string|callable $handler Handler aplikasi jika kondisi router true
     * 
     * @return void
     */
    public static function put(string $route = '', $handler = '')
    {
        Collections::addMethod('put', $route, $handler);
    }

    /**
     * Route untuk PATCH request method
     * 
     * @param string $route  
     * @param string|callable $handler Handler aplikasi jika kondisi router true
     * 
     * @return void
     */
    public static function patch(string $route = '', $handler = '')
    {
        Collections::addMethod('patch', $route, $handler);
    }

    /**
     * Route untuk DELETE request method
     * 
     * @param string $route  
     * @param string|callable $handler Handler aplikasi jika kondisi router true
     * 
     * @return void
     */
    public static function delete(string $route = '', $handler = '')
    {
        Collections::addMethod('delete', $route, $handler);
    }

    /**
     * Route group
     * 
     * @param string $route 
     * @param callable $actions
     * 
     * @return void
     */
    public static function addGroup(string $route, $actions)
    {
        Collections::addGroup($route, $actions);
    }

    /**
     * Memproses seluruh route yang sudah di set
     * 
     * @return void
     */
    public static function register()
    {
        $processor = new RouterProcessor();
        $dispatcher = simpleDispatcher(function (RouteCollector $fastRouter) {
            /** 
             * @var string $httpMethod
             * @var array $items
             */
            foreach (Collections::getAll() as $httpMethod => $items)
            {
                /**
                 * @var string $route
                 * @var string|callable $handler
                 */
                foreach ($items as $route => $handler)
                {
                    // Push route
                    $fastRouter->addRoute($httpMethod, $route, $handler);
                }
            }
        });

        // Validasi URI
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $URI = $_SERVER['REQUEST_URI'];

        // Manipulasi URI
        if (false !== $pos = strpos('?', $URI))
        {
            $URI = substr($URI, 0, $pos);
        }
        $URI = rawurldecode($URI);

        // Eksekusi aplikasi
        $processor->setMethod($requestMethod)
                ->setUri($URI)
                ->setDispatcher($dispatcher)
                ->execute();
    }
}