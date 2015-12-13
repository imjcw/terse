<?php
/**
* 常用的命令
*/

/**
* 中断程序并输出，调试用
*/
if (!function_exists('dd')) {
    function dd($obj = ''){
        if (is_array($obj)) {
            echo "<pre>";
            print_r($obj);
            echo "</pre>";
        }else{
            var_dump($obj);
        }
        die;
    }
}

/**
* 返回信息
*/
if (!function_exists('returnJson')) {
    function returnJson($status = '2000', $info = '', $data = ''){
        $array = array(
            'status' => $status,
            'info' => $info,
        );

        if (!empty($data)) {
            $array['data'] = $data;
        }
        
        return json_encode($array);
   }
}

/**
* 展现模板
*/
if (!function_exists('getRoutes')) {
    function getRoutes(){
        require_once ROOT.'/app/Http/Routes.php';
        return $routes;
   }
}

/**
* 展现模板
*/
if (!function_exists('view')) {
    function view($name = ''){
        $view = Response::init();
        return $view->view($name);
   }
}

/**
* 跳转页面
*/
if (!function_exists('redirect')) {
    function redirect($url = '', $replace = true, $http_code = 302){
        $redirect = Response::init();
        return $redirect->redirect($url, $replace, $http_code);
   }
}
?>