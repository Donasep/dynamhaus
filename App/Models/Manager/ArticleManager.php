<?php
namespace App\Models\Manager;

use App\Lib\Manager\AbstractManager;
use App\Models\Entity\Article;
class ArticleManager extends AbstractManager {
    public function findArticlesByTypes (string $type) {
        return $this->readMany(Article::class,[
            "type"=>[$type,"="],
        ],['position'=>'ASC']);
    }
    public function add(Article $article) {
        return $this->create(Article::class,(array) $article);
    }
    public function delete(int $article_id) {
        return $this->remove(Article::class,$article_id);
    }
    public function find(int $article_id) {
        return $this->readOne(Article::class,['id'=>$article_id]);
    }
}