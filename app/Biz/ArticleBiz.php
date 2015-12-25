<?php
    namespace App\Biz;

    use App\Services\ColumnService;
    use App\Services\ArticleService;
    use App\Services\ContentService;

    /**
    * Article Biz
    */
    class ArticleBiz
    {
        public function getAll()
        {
            $article_service = new ArticleService();
            return $article_service->getAllArticles();
        }

        public function getOne($id = 0)
        {
            if (empty($id)) {
                return false;
            }

            $column_service = new ArticleService();
            $article = $column_service->getOneArticle($id);

            if (!$article) {
                return false;
            }

            $content_service = new ContentService();
            $content = $content_service->getContentById($article['content_id']);

            $article['content'] = $content['content'];

            return $article;
        }

        public function addArticle($data = array())
        {
            if (empty($data)) {
                return false;
            }

            $content_service = new ContentService();
            $content_id = $content_service->insertContent(array('content' => $data['content']));

            if (!$content_id) {
                return false;
            }
            unset($data['content']);
            $data['content_id'] = $content_id;

            $article_service = new ArticleService();
            return $article_service->addOneArticle($data);
        }

        public function editArticle($id = 0, $data = array())
        {
            if (empty($id)) {
                return false;
            }

            if (empty($data)) {
                return false;
            }

            $content = $data['content'];
            unset($data['content']);
            $column_service = new ArticleService();
            $content_id = $column_service->editOneArticle($id, $data);

            $content_service = new ContentService();
            $result = $content_service->updateContentById($content_id, array('content' => $content));

            return $result;
        }
    }