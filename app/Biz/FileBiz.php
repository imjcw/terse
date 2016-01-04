<?php
    namespace App\Biz;

    //use App\Service\ColumnService;

    /**
    * Article Biz
    */
    class FileBiz
    {
        public function readDir($path)
        {
            $arr = array();
            $path = ROOT.'/resources/show/template_01'.$path;
            $handle = opendir($path);
            $i = 0;

            while (($item = readdir($handle)) !== false) {
                $real_path = $path.'/'.$item;
                if ($item == '.' || $item == '..') {
                    continue;
                }else if (is_file($real_path)) {
                    $type = 'file';
                    $arr['file'][$i]['action'] = 'edit';
                    $arr['file'][$i]['size'] = $this->computeFileSize($real_path);
                }else if(is_dir($real_path)){
                    $type = 'dir';
                    $arr['dir'][$i]['action'] = 'index';
                    $arr['dir'][$i]['size'] = $this->computeDirSize($real_path);
                }
                $arr[$type][$i]['item'] = $item;
                $arr[$type][$i]['type'] = $type;
                $arr[$type][$i]['create_time'] = date('Y-m-d', filectime($real_path));
                $arr[$type][$i]['update_time'] = date('Y-m-d', filemtime($real_path));
                $i++;
            }

            closedir($handle);
            return $arr;
        }

        public function computeFileSize($path)
        {
            $size = filesize($path);
            return $this->computeSize($size);
        }

        public function computeDirSize($path)
        {
            static $sum = 0;
            $handle = opendir($path);

            while (($item = readdir($handle)) !== false) {
                $real_path = $path.'/'.$item;
                if ($item == '.' || $item == '..') {
                    continue;
                }else if (is_file($real_path)) {
                    $sum += filesize($real_path);
                }else if(is_dir($real_path)){
                    $this->computeDirSize($real_path);
                }
            }

            closedir($handle);
            return $this->computeSize($sum);
        }

        public function computeSize($size)
        {
            $arr = array('B', 'KB', 'MB');
            $i = 0;

            while ($size > 1024) {
                $size /= 1024;
                $i++;
            }

            return round($size, 2).$arr[$i];
        }
    }