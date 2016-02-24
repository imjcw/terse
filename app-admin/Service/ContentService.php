<?php
namespace Admin\Service;

use Admin\Model\ContentModel;

class ContentService
{
    /**
     * 获取文章内容
     * @param  [type] $id [description]
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function getContent($id)
    {
        $model = new ContentModel();
        if (isset($id) && $id) {
            $model = $model->where('id', $id);
        }
        return $model->one();
    }

    /**
     * 添加文章内容
     * @param  [type] $params [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function addContent($params)
    {
        $content_model = new ContentModel();
        if (isset($params['content']) && $params['content']) {
            $data['content'] = $params['content'];
        }
        if (!$content_model->insert($data)) {
            return false;
        }
        return mysql_insert_id();
    }

    /**
     * 更新文章内容
     * @param  integer $id   [description]
     * @param  array   $params [description]
     * @return [type]           [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function updateContent($id, $params)
    {
        $model = new ContentModel();
        $data = array();
        if (isset($id) && $id) {
            $model = $model->where('id', $id);
        }
        if (isset($params['content']) && $params['content']) {
            $data['content'] = $params['content'];
        }
        return $model->update($data);
    }

    /**
     * 删除文章内容
     * @param  [type] $id [description]
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function deleteContent($id)
    {
        $model = new ContentModel();
        if (isset($id) && $id) {
            $model = $model->where('id', $id);
        }
        return $model->delete();
    }
}