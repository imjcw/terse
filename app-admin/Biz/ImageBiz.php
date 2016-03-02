<?php
namespace Admin\Biz;

use Admin\Biz\BaseBiz;
use Admin\Service\ImageService;

class ImageBiz extends BaseBiz
{
    public function getImage()
    {
        $service = new ImageService();
        return $service->getImage();
    }
    public function addImage($data)
    {
        $service = new ImageService();
        return $service->addImage($data);
    }
    public function delete($name)
    {
        $service = new ImageService();
        return $service->delete($name);
    }
    public function deleteMulti($files)
    {
        $service = new ImageService();
        return $service->deleteMulti($files);
    }
}