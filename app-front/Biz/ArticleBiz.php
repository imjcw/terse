<?php
namespace Front\Biz;

use Front\Service\ArticleService;
use Admin\Service\ContentService;

class ArticleBiz
{
    public function get($article_name, $category_id)
    {
        $article_service = new ArticleService();
        $article = $article_service->getArticle($article_name);

        if (!isset($article['category_id']) || ($article['category_id'] !== $category_id)) {
            return false;
        }

        $content_service = new ContentService();
        $content = $content_service->getContent($article['content_id']);

        $article['content'] = htmlspecialchars_decode($content['content']);

        $pre = $article_service->getPre($article['id']);

        $next = $article_service->getNext($article['id']);

        if (empty($pre)) {
            $article['pre_title'] = '';
            $article['pre_url'] = '';
        } else {
            $article['pre_title'] = $pre['title'];
            $article['pre_nickname'] = $pre['nickname'];
            $article['pre_url'] = $pre['category_id'];
        }

        if (empty($next)) {
            $article['next_title'] = '';
            $article['next_url'] = '';
        } else {
            $article['next_title'] = $next['title'];
            $article['next_nickname'] = $next['nickname'];
            $article['next_url'] = $next['category_id'];
        }

        return $article;
    }

    public function hasView($id)
    {
        $article_service = new ArticleService();
        session_set_cookie_params(60*60);
        if (!isset($_SESSION['ip_id'])) {
            $_SESSION['ip_id'] = array();
        }
        $ip = $_SERVER["REMOTE_ADDR"];
        $str = "IP:{$ip},Article:{$id}";
        if (!in_array($str,$_SESSION['ip_id'])) {
            $_SESSION['ip_id'][] = $str;
            $article_service->hasView($id);
        }
    }

    public function getArticles($category_id, $num)
    {
        $service = new ArticleService();
        return $service->getArticles($category_id, $num);
    }

    public function getClicks($num)
    {
        $service = new ArticleService();
        return $service->getClicks($num);
    }

    /**
     * 获取推荐文章
     * @param  [type] $num [description]
     * @return [type]      [description]
     * @author marvin
     * @date   2016-03-03
     */
    public function getRecommend($num)
    {
        $service = new ArticleService();
        return $service->getRecommend($num);
    }

    /**
     * 获取热门文章
     * @param  [type] $num [description]
     * @return [type]      [description]
     * @author marvin
     * @date   2016-03-03
     */
    public function getHot($num)
    {
        $service = new ArticleService();
        return $service->getHot($num);
    }

    /**
     * 获取最新文章
     * @param  [type] $num [description]
     * @return [type]      [description]
     * @author marvin
     * @date   2016-03-03
     */
    public function getNew($num, $category_id = null)
    {
        $service = new ArticleService();
        return $service->getNew($num, $category_id);
    }
}