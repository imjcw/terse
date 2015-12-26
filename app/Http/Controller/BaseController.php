<?php
    namespace App\Http\Controller;

    use App\Http\Controller\AuthController;
    /**
    * 
    */
    class BaseController
    {
        function __construct(){
            session_start();
            
            if (!$_SESSION['user_id']) {
                return redirect('/auth/login');
            }
        }
    }