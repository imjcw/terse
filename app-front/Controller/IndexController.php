<?php
namespace Front\Controller;

class IndexController
{
    /**
     * 模板管理显示
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-27
     */
    public function index(){
        $postUrl = 'http://yjsb.shu.edu.cn/zsxx/zsquery.asp?ID=1';
        $curlPost = 'StudentID=102806210008355&StudentName=320922199512137320';
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);dd($data);
        $data['title'] = '来来来，测试一下';
        $data['content'] = '内容：来来来，测试一下';
        return view('/article')->with(array('data' => $data));
    }
}