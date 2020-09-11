<?php


use App\Core\Controller;

class NewsController extends Controller
{

    public function index()
    {
        return $this->getResponse()->renderView('index','default',compact(''));
    }



}