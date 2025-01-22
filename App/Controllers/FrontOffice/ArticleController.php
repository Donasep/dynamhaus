<?php
namespace App\Controllers\FrontOffice;
use App\Lib\Controller\AbstractController;
use App\Models\Entity\Article;
use App\Models\Manager\ArticleManager;
class ArticleController extends AbstractController {
    public function faq() {
        $articleManager = new ArticleManager();
        $articles=$articleManager->findArticlesByTypes('FAQ');
        return $this->renderView('faq.php',['articles'=>$articles]);
    }
    public function cgu() {
        $articleManager = new ArticleManager();
        $articles=$articleManager->findArticlesByTypes('CGU');
        return $this->renderView('cgu.php',['articles'=>$articles]);
    }
    public function lgt() {
        $articleManager = new ArticleManager();
        $articles=$articleManager->findArticlesByTypes('LGT');
        return $this->renderView('lgt.php',['articles'=>$articles]);
    }
    public function createArticle($slug_type) {
        $user = $this->checkUserRole(['ADMIN']);
        if (!$user) {
            return $this->setError404();
        }
        $type=strtoupper($slug_type);
        if (!in_array($type,['FAQ','CGU','LGT'])) {
            return $this->setError404();
        }
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            return $this->renderView("createArticle.php", ['type' => $type, "state" => "ok"]);
        }
        $data=json_decode(file_get_contents('php://input'), true);
        if (isset($data['position'])&&isset($data['title'])&&isset($data['description'])) {
        $article = new Article();
        $article->position = $data['position'];
        $article->title=$data['title'];
        $article->description=$data['description'];
        $article->type=strtoupper($type);
        $articleManager = new ArticleManager();
        $articleId=$articleManager->add($article);
        if ($articleId) {
        echo json_encode(['state'=>'ok']);
        }
        }
        exit;
    }
    public function deleteArticle($slug_id) {
        $user = $this->checkUserRole(['ADMIN']);
        if (!$user) {
            return $this->setError404();
        }
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            exit;
        }
        $articleManager = new ArticleManager();
        $article = $articleManager->find($slug_id);
        if ($article) {
            $articleManager->delete($article->id);
            echo json_encode(['state'=>'ok']);
        }
        
        exit;
    }
    public function updateArticle($slug_id) {
        $user = $this->checkUserRole(['ADMIN']);
        if (!$user) {
            return $this->setError404();
        }
        $articleManager = new ArticleManager();
        $article = $articleManager->find($slug_id);
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            return $this->renderView('updateArticle.php',['article'=>$article]);
        }
    }

    public function getArticles($slug_type) {
        $user = $this->checkUserRole(['ADMIN']);
        if (!$user) {
            return $this->setError404();
        }
        $type=strtoupper($slug_type);
        if (!in_array($type,['FAQ','CGU','LGT'])) {
            return $this->setError404();
        }
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            $articleManager= new ArticleManager();
            $articles = $articleManager->findArticlesByTypes($type);
            if (!empty($articles)) {
                return $this->renderView("articleList.php", ['articles' => $articles, "state" => "ok"]);
            }
        }
    }
}

