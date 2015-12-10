<?php
    /**
    * 模板渲染
    */
    class Page
    {
        protected static $init;

        protected $extend = '';

        protected $content = '';

        protected $data = '';

        public function init(){
            if (!self::$init) {
                self::$init = new Page();
            }
            return self::$init;
        }

        public function extend($path = ''){
            $this->extend = $path;
        }

        public function start(){
            ob_start();
        }

        public function stop(){
            $this->content = ob_get_clean();
        }

        public function export(){
            echo $this->content;
        }

        public function exportToBrowser($name = ''){
            $this->compile($name);
            $this->compile($this->extend);
        }

        public function compile($path = ''){
            if (!empty($this->data)) {
                foreach ($this->data as $key => $value) {
                    $$key = $value;
                }
            }
            if (!empty($path)) {
                require_once ROOT.'/resources/views/'.$path.'.html';
            }
        }

        public function with($pageData = array()){
            $this->data = $pageData;
        }
    }
?>