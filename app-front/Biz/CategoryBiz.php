<?php
namespace Front\Biz;

use Front\Service\CategoryService;

class CategoryBiz
{
    public function getVisibleCategorys()
    {
        $service = new CategoryService();
        return $service->getVisibleCategorys();
    }

    public function getCategoryByNickName($nickname)
    {
        $service = new CategoryService();
        return $service->getCategoryByNickName($nickname);
    }
}