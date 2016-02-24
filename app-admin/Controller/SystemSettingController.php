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
        $data = $biz->getSystemInfo();
        foreach ($data as $value) {
            $system[$value['name']] = $value['value'];
        }
        $msg = getMsg();

        return view('system/index')->with(array(
            'system' => $system,
            'msg' => $msg
            ));
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
        $biz = new SettingBiz();
        $result = $biz->updateSystemInfo($data);
        $_SESSION['msg'] = $result ? '修改系统信息成功！' : '修改系统信息失败！';
        return redirect('system/index');
    }
}