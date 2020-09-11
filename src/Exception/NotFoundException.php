<?php
namespace App\Exception;

use App\Core\AppException;
use Exception;
use Throwable;

/**
 * Class NotFoundException
 * @package App\Exception
 */
class NotFoundException extends AppException
{
    public function __construct($message = "Error no se ha encontrado el recurso", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}