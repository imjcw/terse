<?php
namespace Admin\Biz;

use Admin\Service\CategoryService;

class CategoryBiz
{
    /**
     * 获取所有栏目
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function getCategorys()
    {
        $service = new CategoryService();
        return $service->getCategorys();
    }

    /**
     * 通过ID获取栏目
     * @param  [type]  $id [description]
     * @return [type]      [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function getCategory($id)
    {
        $service = new CategoryService();
        return $service->getCategory($id);
    }

    /**
     * 添加栏目
     * @param  [type] $data [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function addCategory($data)
    {
        $data['create_time'] = NULL;

        $service = new CategoryService();
        //检测栏目名是否重复
        $result = $service->checkExit('name',$data['name']);
        if ($result) {
            return false;
        }
        //检测栏目昵称是否重复
        if (isset($data['nickname']) && $data['nickname']) {
            $result = $service->checkExit('nickname',$data['nickname']);
            if ($result) {
                return false;
            }
        }
        //新建栏目
        return $service->addCategory($data);
    }

    /**
     * 更新栏目
     * @param  [type]     $data [description]
     * @return [type]           [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function updateCategory($data)
    {
        $service = new CategoryService();
        //检测栏目名是否重复
        $result = $service->checkExit('name',$data['name']);
        if ($result) {
            if ($result[0]['id'] != $data['id']) {
                return false;
            }
        }
        //检测栏目昵称是否重复
        if (isset($data['nickname']) && $data['nickname']) {
            $result = $service->checkExit('nickname',$data['nickname']);
            if ($result) {
                if ($result[0]['id'] != $data['id']) {
                    return false;
                }
            }
        }
        //更新栏目
        return $service->updateCategory($data);
    }

    /**
     * 删除
     * @param  integer    $id [description]
     * @return [type]         [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function deleteCategory($id)
    {
        $service = new CategoryService();
        return $service->deleteCategory($id);
    }

    /**
     * 根据ID获取column
     * @param  [type] $id [description]
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-15
     */
    public function getCategoryByIds($id)
    {
        $service = new CategoryService();
        return $service->getCategoryByIds($id);
    }

    /**
     * 更新文章数目
     * @param  [type] $id     [description]
     * @param  [type] $action [description]
     * @return [type]         [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function updateArticleNums($id, $action)
    {
        $category_service = new CategoryService();
        $category_service->updateArticleNums($id, $action);
    }

    /**
     * 栏目启用/禁用开关
     * @param  integer $id     [description]
     * @param  integer $status [description]
     * @return [type]          [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function changeVisible($id, $status=0)
    {
        $service = new CategoryService();
        return $service->changeVisible($id, $status);
    }

    public function getCategoryByNickName($nickname)
    {
        $service = new CategoryService();
        return $service->getCategoryByNickName($nickname);
    }
}