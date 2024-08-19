<?php

namespace Drupal\content_custom\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\content_custom\Application\Service\ArticleService;
use Drupal\content_custom\Domain\Entity\ContactInfo;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArticleController extends ControllerBase
{
  private $articleService;

  public function __construct(ArticleService $articleService)
  {
    $this->articleService = $articleService;
  }

  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('mi_modulo.article_service')
    );
  }

  public function listArticles()
  {
    $articles = $this->articleService->getAllArticles();
    $data = array_map(function ($article) {
      return [
        'id' => $article->getId(),
        'title' => $article->getTitle(),
        'body' => $article->getBody(),
        'taxonomy' => $article->getTaxonomy(),
        'contactInfo' => [
          'date' => $article->getContactInfo()->getDate(),
          'firstName' => $article->getContactInfo()->getFirstName(),
          'lastName' => $article->getContactInfo()->getLastName(),
          'phoneNumber' => $article->getContactInfo()->getPhoneNumber(),
          'email' => $article->getContactInfo()->getEmail(),
        ],
      ];
    }, $articles);

    return new JsonResponse($data);
  }

  public function getArticle($id)
  {
    try {
      $article = $this->articleService->getArticle($id);
      if (!$article) {
        return new JsonResponse(['error' => 'Article not found'], 404);
      }

      $data = [
        'id' => $article->getId(),
        'title' => $article->getTitle(),
        'body' => $article->getBody(),
        'taxonomy' => $article->getTaxonomy(),
        'contactInfo' => [
          'date' => $article->getContactInfo()->getDate(),
          'firstName' => $article->getContactInfo()->getFirstName(),
          'lastName' => $article->getContactInfo()->getLastName(),
          'phoneNumber' => $article->getContactInfo()->getPhoneNumber(),
          'email' => $article->getContactInfo()->getEmail(),
        ],
      ];

      return new JsonResponse($data);
    } catch (\Exception $e) {
      return new JsonResponse(['error' => $e->getMessage()], 500);
    }
  }
}
