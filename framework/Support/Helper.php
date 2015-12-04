<?php
/**
* 常用的命令
*/
class Helper
{
    /*
    * 输出数组并结束运行
    */
    public function dd($obj = ''){
        if (is_array($obj)) {
            echo "<pre>";
            print_r($obj);
            echo "</pre>";
        }else{
            var_dump($obj);
        }
        die;
    }

    /*
    * 返回信息
    */
   public function returnJson($status = '2000', $info = '', $data = ''){
        $array = [
            'status' => $status,
            'info' => $info,
        ];

        if (!empty($data)) {
            $array['data'] = $data;
        }
        
        return json_encode($array);
   }
}
?>