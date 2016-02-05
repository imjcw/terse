<?php
    namespace Admin\Service;

    use Admin\Model\ColumnModel;

    /**
    * Article Service
    */
    class ColumnService
    {
        public function getAllColumns()
        {
            $column_model = new ColumnModel();
            return $column_model
                        ->where('is_use', 1)
                        ->all();
        }

        public function getOneColumn($id = 0)
        {
            $column_model = new ColumnModel();
            return $column_model
                        ->where(array('id' => $id, 'is_use' => 1))
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

        public function updateOneColumnStatus($id = 0, $status = 0)
        {
            $column_model = new ColumnModel();
            return $column_model
                        ->where(array('id' => $id, 'is_use' => 1))
                        ->update(array('is_use' => $status));
        }

        public function deleteOneColumn($id = 0)
        {
            $column_model = new ColumnModel();
            return $column_model
                        ->where('id', $id)
                        ->delete();
        }

        public function checkExit($name = '')
        {
            $column_model = new ColumnModel();
            $result = $column_model
                        ->where('name', $name)
                        ->one();

            return $result;
        }
    }