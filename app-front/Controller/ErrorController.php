<?php
namespace Front\Controller;

class ErrorController
{
    public function index(){
    	header("HTTP/1.1 404 Not Found");
        return view('/404');
    }
}