<?php
namespace Admin\Service;

use Admin\Model\ImageModel;

class ImageService
{
    public function getImage()
    {
        $model = new ImageModel();
        return $model->orderBy('id')->all();
    }
    public function addImage($data)
    {
        $model = new ImageModel();
        return $model->insert($data);
    }
    public function delete($name)
    {
        $model = new ImageModel();
        return $model->where('name',$name)->delete();
    }
    public function deleteMulti($files)
    {
        $model = new ImageModel();
        if (is_array($files) && !empty($files)) {
            $model = $model->where('name',$files[0]);
            array_shift($files);
            foreach ($files as $file) {
                $model = $model->orWhere('name',$file);
            }
        }
        return $model->delete();
    }
}