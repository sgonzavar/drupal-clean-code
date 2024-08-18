<?php

namespace MiProyecto\Domain\Repository;

use clean_code\Domain\Entity\Article;

interface ArticleRepositoryInterface
{
  public function findById($id);
  public function save(Article $article);
  public function delete(Article $article);
  public function findAll();
}
