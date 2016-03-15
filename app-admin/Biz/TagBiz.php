<?php
namespace Admin\Biz;

use Admin\Service\TagService;
use Admin\Biz\BaseBiz;

class TagBiz extends BaseBiz
{
    public function getTags()
    {
        $service = new TagService();
        return $service->getTags();
    }
}