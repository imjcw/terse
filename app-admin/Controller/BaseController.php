<?php
namespace Admin\Controller;

use Admin\Controller\AuthController;

class BaseController
{
    function __construct(){
        if (!isset($_SESSION['user_id'])) {
            return redirect('/auth/login');
        }

        if (!$_SESSION['user_id']) {
            return redirect('/auth/login');
        }
    }
}