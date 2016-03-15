<?php
namespace Front\Controller;

use Admin\Biz\ArticleBiz;
use Admin\Biz\CategoryBiz;
use Front\Controller\BaseController;

class IndexController
{
    public $data = '';
    /**
     * 模板管理显示
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-27
     */
    public function index(){
        return view('/index');
    }

    public function compileArticle($expression)
    {
        $params = explode(' ', $expression);
        $data = $this->buildArray($params);
        if (isset($data['type']) && $data['type']) {
            $type = $data['type'];
        }
        if (isset($data['num']) && $data['num']) {
            $num = $data['num'];
        }
        $articles = $type($num);
        $this->data['articles'] = $articles;
        $expression = '($articles as $article)';
        return "<?php foreach{$expression}: ?>";
    }

    public function compileEndArticle($expression)
    {
        return "<?php endforeach; ?>";
    }

    public function buildArray($params)
    {
        $data = array();
        foreach ($params as $param) {
            $val = explode(':', $param);
            $data[$val[0]] = $val[1];
        }
        return $data;
    }

    protected function compileEcho($value)
    {
        $pattern = sprintf('/%s((.|\s)*?)%s/', '{{', '}}');extract($this->data);
        return preg_replace($pattern, '<?=$1 ?>', $value);
    }
}