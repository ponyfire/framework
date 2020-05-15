<?php

namespace PonyFire\Router;

use InvalidArgumentException;

class Collections
{
    /**
     * Daftar route dengan method GET
     * 
     * @var array
     */
    public static array $routeGet;

    /**
     * Daftar route dengan method HEAD
     * 
     * @var array
     */
    public static array $routeHead;

    /**
     * Daftar route dengan method POST
     * 
     * @var array
     */
    public static array $routePost;

    /**
     * Daftar route dengan method PUT
     * 
     * @var array
     */
    public static array $routePut;

    /**
     * Daftar route dengan method PATCH
     * 
     * @var array
     */
    public static array $routePatch;

    /**
     * Daftar route dengan method DELETE
     * 
     * @var array
     */
    public static array $routeDelete;

    /**
     * Inisialisasi kelas
     * Pre-set property
     * 
     * @return void
     */
    public static function init()
    {
        self::$routeGet     = [];
        self::$routeHead    = [];
        self::$routePost    = [];
        self::$routePut     = [];
        self::$routePatch   = [];
        self::$routeDelete  = [];
    }

    /**
     * Menambahkan data route ke dalam collections
     * 
     * @param string $httpMethod HTTP request method
     * @param string $route Application route
     * @param string|callback $handler Action handler
     * 
     * @throws \PonyFire\Router\Exceptions\InvalidArgumentExceptions
     * @return void
     */
    public static function addMethod(string $httpMethod = 'get', string $route, $handler)
    {
        // Validasi apakah $value merupakan string|callback atau tidak
        if (gettype($handler[1]) !== 'string' || gettype($handler[1]) !== 'callback')
        {
            throw new InvalidArgumentException();
        }

        $method = 'route' . ucfirst($httpMethod);
        
        // Push handler
        array_push(self::$$method[$route], $handler);
    }

    /**
     * Menambah data route group ke dalam collections
     */
    public static function addGroup(string $route, callable $action)
    {
        $route = preg_replace('/\/$/', '', '/' . preg_replace('/^\//', '', $route)) . '/';

        $action();
    }

    /**
     * Mengambil seluruh daftar route
     * 
     * @return array
     */
    public static function getAll()
    {
        // Mengembalikan data konfigurasi router
        return [
            'GET'    => self::$routeGet,
            'HEAD'   => self::$routeHead,
            'POST'   => self::$routePost,
            'PUT'    => self::$routePut,
            'PATCH'  => self::$routePatch,
            'DELETE' => self::$routeDelete,
        ];
    }
}