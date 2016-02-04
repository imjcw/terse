<?php
namespace Admin\Http\Controller;

use Admin\Biz\SettingBiz;
use Admin\Http\Controller\BaseController;

class SystemSettingController extends BaseController
{
    public function index()
    {
        $setting_biz = new SettingBiz();
        $pageData = $setting_biz->getAll();
        foreach ($pageData as $value) {
            $data[$value['name']] = $value['value'];
        }
        return view('setting/index')->with($data);
    }

    public function updateSystemInfo()
    {
        $data = $_POST;

        $setting_biz = new SettingBiz();
        $result = $setting_biz->updateSystemInfo($data);
        $page = $result ? 'index' : '/error';
        return redirect($page);
    }
}