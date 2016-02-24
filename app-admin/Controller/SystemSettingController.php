<?php
namespace Admin\Controller;

use Admin\Biz\SettingBiz;
use Admin\Controller\BaseController;

class SystemSettingController extends BaseController
{
    /**
     * 系统设置
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function index()
    {
        $biz = new SettingBiz();
        $pageData = $biz->getSystemInfo();
        foreach ($pageData as $value) {
            $data[$value['name']] = $value['value'];
        }
        return view('setting/index')->with($data);
    }

    /**
     * 更新系统信息
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function updateSystemInfo()
    {
        $params = $_POST;
        if (isset($params['url']) && $params['url']) {
            $data['url'] = filter_var($params['url'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['title']) && $params['title']) {
            $data['title'] = filter_var($params['title'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = filter_var($params['description'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['keywords']) && $params['keywords']) {
            $data['keywords'] = filter_var($params['keywords'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['copyright']) && $params['copyright']) {
            $data['copyright'] = filter_var($params['copyright'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['template_name']) && $params['template_name']) {
            $data['template_name'] = filter_var($params['template_name'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['template_path']) && $params['template_path']) {
            $data['template_path'] = filter_var($params['template_path'], FILTER_SANITIZE_STRING);
        }
        $biz = new SettingBiz();
        $result = $biz->updateSystemInfo($data);
        return redirect('setting/index');
    }
}