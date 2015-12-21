<?php
    namespace View;
    /**
    * 模板渲染
    */
    class Page
    {
        protected static $init;

        protected $content = '';

        protected $extend = '';

        protected $data = '';

        protected $path = '';

        public static function init(){
            if (!self::$init) {
                self::$init = new Page();
            }
            return self::$init;
        }

        public function extend($name = ''){
            $this->extend = $this->buildPath($name);
        }

        public function start(){
            ob_start();
        }

        public function stop(){
            $this->content = ob_get_clean();
            $this->compile($this->extend);
        }

        public function export(){
            echo $this->content;
        }

        public function exportToBrowser($name = ''){
            $this->path = $this->buildPath($name);
            return $this;
        }

        public function buildPath($name = ''){
            return ROOT.'/resources/views/'.$name.'.html';
        }

        public function compile($path = ''){
            if (!empty($this->data)) {
                extract($this->data);
            }
            if (empty($path)) {
                $path = $this->path;
            }
            require_once $path;
        }

        public function with($pageData = array()){
            $this->data = $pageData;
            return $this;
        }
    }
?>