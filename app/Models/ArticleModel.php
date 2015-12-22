<?php
    use Lib\Factory\Model;
    /**
    * 文章模型
    */
    class ArticleModel extends Model
    {
        public $table = '`article`';

        public function addArticle(){
            $data = $_POST;
            if (empty($data)) {
                return returnJson('1003', '未获取到所需参数！');
            }
            return $this->insert($data);
        }

        public function getOne(){
            $id = $_GET['id'];
            if (empty($id)) {
                return returnJson('1003', '未指定需要查找的文章ID！');
            }
            $id = intval($id);
            return $this->one('`id` = '.$id);
        }

        public function editArticle(){
            $id = $_GET['id'];
            if (empty($id)) {
                return returnJson('1003', '未指定需要查找的文章ID！');
            }
            $id = intval($id);
            $data = $_POST;
            if (empty($data)) {
                return returnJson('1003', '未获取到所需参数！');
            }
            return $this->update($data, array('id' => $id));
        }

        public function deleteArticle(){
            $id = $_GET['id'];
            if (empty($id)) {
                return returnJson('1003', '未指定需要查找的文章ID！');
            }
            $id = intval($id);
            return $this->delete(array('id' => $id));
        }
    }
?>