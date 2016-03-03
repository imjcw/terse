<?php
namespace Front\Controller;

class ErrorController
{
    public function index(){
        return view('/404');
    }
}