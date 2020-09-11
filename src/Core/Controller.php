<?php
namespace App\Core;


use App\Exception\NotFoundException;


abstract class Controller
{
    private $response;
    /**
     * Controller constructor.
     * @throws NotFoundException
     */
    public function __construct()
    {
        $this->response = App::get('response');
    }
    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}