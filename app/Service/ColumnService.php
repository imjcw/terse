<?php
    namespace App\Service;

    use App\Model\ColumnModel;

    /**
    * Article Service
    */
    class ColumnService
    {
        public function getAllColumns()
        {
            $column_model = new ColumnModel();
            return $column_model->all();
        }

        public function getOneColumn($id = 0)
        {
            $column_model = new ColumnModel();
            return $column_model
                        ->where('id', $id)
                        ->one();
        }

        public function insertNewColumn($data = array())
        {
            $column_model = new ColumnModel();
            return $column_model->insert($data);
        }

        public function editOneColumn($data = array(), $id = 0)
        {
            $column_model = new ColumnModel();
            return $column_model
                        ->where('id', $id)
                        ->update($data);
        }

        public function deleteOneColumn($id = 0)
        {
            $column_model = new ColumnModel();
            return $column_model
                        ->where('id', $id)
                        ->delete();
        }
    }