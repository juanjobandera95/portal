<?php

namespace App\Exception;


use App\Core\AppException;
use Throwable;

/**
 * Class UploadedFileException
 * @package App\Exception
 */
class UploadedFileException extends AppException
{
    public function __construct($message = "Error interno de servidor", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}