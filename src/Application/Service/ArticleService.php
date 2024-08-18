<?php

namespace clean_code\Application\Service;

use clean_code\Domain\Entity\Article;
use clean_code\Domain\Repository\ArticleRepositoryInterface;
class ArticleService
{
  private $repository;

  public function __construct(ArticleRepositoryInterface $repository)
  {
    $this->repository = $repository;
  }

  public function createArticle($title, $content)
  {
    $article = new Article(null, $title, $content);
    return $this->repository->save($article);
  }

  public function updateArticle($id, $title, $content)
  {
    $article = $this->repository->findById($id);
    if (!$article) {
      throw new \Exception("Article not found");
    }
    $article->setTitle($title);
    $article->setContent($content);
    return $this->repository->save($article);
  }

  public function deleteArticle($id)
  {
    $article = $this->repository->findById($id);
    if (!$article) {
      throw new \Exception("Article not found");
    }
    $this->repository->delete($article);
  }

  public function getArticle($id)
  {
    return $this->repository->findById($id);
  }

  public function getAllArticles()
  {
    return $this->repository->findAll();
  }
}
