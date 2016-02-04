<?php
namespace Admin\Http\Controller;

use Admin\Http\Controller\AuthController;

class BaseController
{
    function __construct(){
        session_start();
        
        if (!$_SESSION['user_id']) {
            return redirect('/auth/login');
        }
    }
}