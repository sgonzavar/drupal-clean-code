<?php

namespace Drupal\content_custom\Domain\Repository;

use Drupal\mi_modulo\Domain\Entity\Article;

interface ArticleRepositoryInterface
{
  public function findById($id);
  public function save(Article $article);
  public function delete(Article $article);
  public function findAll();
}
