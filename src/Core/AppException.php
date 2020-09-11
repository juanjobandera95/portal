<?php


namespace App\Core;


use Exception;
use Throwable;

class AppException extends Exception
{
    public function __construct($message = "Error interno de servidor", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function handleException()
    {

        $message = $this->getMessage();
        $code = $this->getCode();

        $httpStatus = $this->getHttpStatus();
        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $httpStatus);


        $response = App::get('response');
        return $response->renderView('error', 'default', compact('message', 'code'));


    }

    private function getHttpStatus(): string
    {
        switch ($this->getCode()) {
            case 404:

                $status = "404 Not Found";
                break;

            case 403:
                $status = "403 Forbidden";
                break;

            default:
                $status = "Internal server Error";
        }

        return $status;
    }
}