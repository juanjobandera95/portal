<?php


namespace App\Exception;


use Throwable;

class DBException extends \App\Core\AppException
{
    public function __construct($message = "Error de BBDD", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}