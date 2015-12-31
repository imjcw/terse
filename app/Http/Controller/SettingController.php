<?php
    namespace App\Http\Controller;

    use App\Biz\SettingBiz;
    use App\Http\Controller\BaseController;
    /**
    * 
    */
    class SettingController extends BaseController
    {
        public function index()
        {
            $setting_biz = new SettingBiz();
            $pageData = $setting_biz->getInfo();
            return view('setting/index')->with($pageData);
        }

        public function updateSystemInfo()
        {
            $data = $_POST;
            if (empty($data)) {
                return false;
            }

            $setting_biz = new SettingBiz();
            $result = $setting_biz->updateSystemInfo($data);
            $page = $result ? 'index' : '/error';
            return redirect($page);
        }
    }