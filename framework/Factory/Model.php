<?php
    namespace Factory;

    use Lib\Database\Connection;
    /**
    * model factory
    */
    class Model extends Connection
    {
        function __construct()
        {
            $this->connect();
        }

        function __destruct(){
            $this->close();
        }
    }
?>