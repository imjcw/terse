<?php
    /**
    * 文章模型
    */
    class ArticleModel extends Model
    {
        public $table = '`column`';

        public function getAll(){
            return $this->all();
        }

        public function getOne($id = ''){
            if (empty($id)) {
                return returnJson('1003', '未指定需要查找的文章ID！');
            }
            $id = intval($id);
            return $this->one('`id` = '.$id);
        }
    }
?>