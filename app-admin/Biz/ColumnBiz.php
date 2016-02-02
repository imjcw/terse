<?php
    namespace App\Biz;

    use App\Service\ColumnService;

    /**
    * Column Biz
    */
    class ColumnBiz
    {
        public function getAll()
        {
            $column_service = new ColumnService();
            return $column_service->getAllColumns();
        }

        public function getOne($id = 0)
        {
            if (empty($id)) {
                return false;
            }

            $column_service = new ColumnService();
            return $column_service->getOneColumn($id);
        }

        public function addColumn($data = array())
        {
            if (empty($data)) {
                return false;
            }
            $data['create_time'] = NULL;

            $column_service = new ColumnService();
            $result = $column_service->checkExit($data['name']);
            if ($result) {
                return false;
            }

            $column_service = new ColumnService();
            $result = $column_service->insertNewColumn($data);
            return $result;
        }

        public function editColumn($data = array(), $id = 0)
        {
            if (empty($id)) {
                return false;
            }
            if (empty($data)) {
                return false;
            }

            $column_service = new ColumnService();
            $result = $column_service->checkExit($data['name']);
            if ($result) {
                return false;
            }

            $column_service = new ColumnService();
            return $column_service->editOneColumn($data, $id);
        }

        public function deleteColumn($id = 0)
        {
            if (empty($id)) {
                return false;
            }

            $column_service = new ColumnService();
            return $column_service->updateOneColumnStatus($id);
        }
    }