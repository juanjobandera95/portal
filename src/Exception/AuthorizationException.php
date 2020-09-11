<?php


namespace App\Exception;


use App\Core\AppException;
use Throwable;

class AuthorizationException extends AppException
{
    public function __construct($message = "ForBidden", $code = 403, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}