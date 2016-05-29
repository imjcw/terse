<?php
use Admin\Service\SettingService;

if (!function_exists('getSystem')) {
    function getSystem($variable){
        $service = new SettingService();
        $system = $service->getSystemInfo();
        foreach ($system as $info) {
            if ($info['name'] == $variable) {
                return $info['value'];
            }
        }
    }
}

if (!function_exists('deldir')) {
	function deldir($dir) {
		//先删除目录下的文件：
		$dh=opendir($dir);
		while ($file=readdir($dh)) {
			if($file!="." && $file!="..") {
				$fullpath=$dir."/".$file;
				if(!is_dir($fullpath)) {
				    unlink($fullpath);
				} else {
				    deldir($fullpath);
				}
			}
		}
		
		closedir($dh);
		//删除当前文件夹：
		if(rmdir($dir)) {
			return true;
		} else {
			return false;
		}
	}
}

if (!function_exists('current_time')) {
	function current_time()
	{
		$weekArray = array('日', '一', '二', '三', '四', '五', '六');
		$date = date('Y-m-d');
		$date .= ' 星期';
		$date .= $weekArray[date('w')];
		return $date; 
	}
}