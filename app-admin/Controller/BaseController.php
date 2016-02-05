<?php
namespace Admin\Controller;

use Admin\Controller\AuthController;

class BaseController
{
    function __construct(){
        session_start();
        
        if (!$_SESSION['user_id']) {
            return redirect('/auth/login');
        }
    }
}