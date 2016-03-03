<?php
namespace Front\Biz;

use Front\Service\ColumnService;

class ColumnBiz
{
    public function getVisibleColumns()
    {
        $service = new ColumnService();
        return $service->getVisibleColumns();
    }

    public function getColumnByNickName($nickname)
    {
        $service = new ColumnService();
        return $service->getColumnByNickName($nickname);
    }
}