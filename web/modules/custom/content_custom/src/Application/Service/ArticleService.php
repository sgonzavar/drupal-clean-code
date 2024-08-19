<?php

namespace Drupal\mi_modulo\Application\Service;

use Drupal\content_custom\Domain\Entity\Article;
use Drupal\content_custom\Domain\Entity\ContactInfo;
use Drupal\content_custom\Domain\Repository\ArticleRepositoryInterface;

class ArticleService
{
  private $repository;

  public function __construct(ArticleRepositoryInterface $repository)
  {
    $this->repository = $repository;
  }

  public function createArticle($title, $body, $taxonomy, ContactInfo $contactInfo)
  {
    $article = new Article(null, $title, $body, $taxonomy, $contactInfo);
    return $this->repository->save($article);
  }

  public function updateArticle($id, $title, $body, $taxonomy, ContactInfo $contactInfo)
  {
    $article = $this->repository->findById($id);
    if (!$article) {
      throw new \Exception("Article not found");
    }
    $article->setTitle($title);
    $article->setBody($body);
    $article->setTaxonomy($taxonomy);
    $article->setContactInfo($contactInfo);
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
