<?php
namespace App\Core;

use App\DBConnection;
use App\Exception\NotFoundException;

/**
 * Class App
 */
class App
{
    /**
     * @var array
     */
    private static $dependencies = [];


    /**
     * @param string $key
     * @param $object
     */
    public static function set(string $key, $object)
    {
        static::$dependencies[$key] = $object;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws NotFoundException
     */
    public static function get(string $key)
    {
        if (!array_key_exists($key, static::$dependencies)) {
            throw new NotFoundException("No se ha encontrado la clave $key");
        }
        return static::$dependencies[$key];
    }

    /**
     * @param string $className
     * @return mixed
     */
    public static function getModel(string $className)
    {
        if (!array_key_exists($className, static::$dependencies)) {
            static::$dependencies[$className] = new $className(DBConnection::getConnection());
        }
        return static::$dependencies[$className];
    }
}