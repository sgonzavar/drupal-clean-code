<?php

namespace clean_code\Infrastructure\Repository;

use clean_code\Domain\Entity\Article;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\Entity\Node;
use clean_code\Domain\Repository\ArticleRepositoryInterface;

class DrupalArticleRepository implements ArticleRepositoryInterface
{
  private $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entityTypeManager)
  {
    $this->entityTypeManager = $entityTypeManager;
  }

  public function findById($id)
  {
    $node = $this->entityTypeManager->getStorage('node')->load($id);
    if (!$node || $node->getType() !== 'article') {
      return null;
    }
    return $this->nodeToArticle($node);
  }

  public function save(Article $article)
  {
    $values = [
      'type' => 'article',
      'title' => $article->getTitle(),
      'body' => [
        'value' => $article->getContent(),
        'format' => 'full_html',
      ],
    ];

    if ($article->getId()) {
      $node = $this->entityTypeManager->getStorage('node')->load($article->getId());
      $node->set('title', $article->getTitle());
      $node->set('body', $article->getContent());
    } else {
      $node = Node::create($values);
    }

    $node->save();
    return $this->nodeToArticle($node);
  }

  public function delete(Article $article)
  {
    $node = $this->entityTypeManager->getStorage('node')->load($article->getId());
    if ($node) {
      $node->delete();
    }
  }

  public function findAll()
  {
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'article')
      ->sort('created', 'DESC')
      ->accessCheck(FALSE);
    $nids = $query->execute();
    $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);

    $articles = [];
    foreach ($nodes as $node) {
      $articles[] = $this->nodeToArticle($node);
    }
    return $articles;
  }

  private function nodeToArticle(Node $node)
  {
    return new Article(
      $node->id(),
      $node->getTitle(),
      $node->get('body')->value
    );
  }
}
