<?php
    /**
    * 路由获取
    */
    class Route
    {
        protected function getUri(){
            $uri = substr($_SERVER['REQUEST_URI'], 1);
            return $uri ? $uri : '/';
        }

        public function getBaseUri(){
            $uri = $this->getUri();
            $pos = strpos($uri, '?');
            $baseUri = $pos ? substr($uri, 0, $pos) : $uri;
            return $baseUri;
        }
    }
?>