<?php

namespace Drupal\content_custom\Infrastructure\Repository;

use Drupal\content_custom\Domain\Entity\Article;
use Drupal\content_custom\Domain\Entity\ContactInfo;
use Drupal\content_custom\Domain\Repository\ArticleRepositoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;

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
        'value' => $article->getBody(),
        'format' => 'full_html',
      ],
      'field_taxonomy' => ['target_id' => $article->getTaxonomy()],
    ];

    if ($article->getId()) {
      $node = $this->entityTypeManager->getStorage('node')->load($article->getId());
      $node->set('title', $article->getTitle());
      $node->set('body', $article->getBody());
      $node->set('field_taxonomy', ['target_id' => $article->getTaxonomy()]);
    } else {
      $node = Node::create($values);
    }

    $contactInfo = $article->getContactInfo();
    $paragraph = $node->get('field_contact_info')->entity;
    if (!$paragraph) {
      $paragraph = Paragraph::create(['type' => 'contact_info']);
    }
    $paragraph->set('field_date', $contactInfo->getDate());
    $paragraph->set('field_first_name', $contactInfo->getFirstName());
    $paragraph->set('field_last_name', $contactInfo->getLastName());
    $paragraph->set('field_phone_number', $contactInfo->getPhoneNumber());
    $paragraph->set('field_email', $contactInfo->getEmail());
    $paragraph->save();

    $node->set('field_contact_info', $paragraph);
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
      ->sort('created', 'DESC');
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
    $paragraph = $node->get('field_contact_info')->entity;
    $contactInfo = new ContactInfo(
      $paragraph->get('field_date')->value,
      $paragraph->get('field_first_name')->value,
      $paragraph->get('field_last_name')->value,
      $paragraph->get('field_phone_number')->value,
      $paragraph->get('field_email')->value
    );

    return new Article(
      $node->id(),
      $node->getTitle(),
      $node->get('body')->value,
      $node->get('field_taxonomy')->target_id,
      $contactInfo
    );
  }
}
