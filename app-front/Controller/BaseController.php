<?php
namespace Front\Controller;

class BaseController
{
    function __construct(){
        session_start();
    }
}