<?php

namespace Drupal\article_custom\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use clean_code\Application\Service\ArticleService;
use Symfony\Component\HttpFoundation\Request;
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
      $container->get('article_custom.article_service')
    );
  }

  public function createArticle(Request $request)
  {
    $data = json_decode($request->getContent(), true);
    $title = $data['title'] ?? '';
    $content = $data['content'] ?? '';

    try {
      $article = $this->articleService->createArticle($title, $content);
      return new JsonResponse([
        'message' => 'Article created successfully',
        'id' => $article->getId(),
      ], 201);
    } catch (\Exception $e) {
      return new JsonResponse(['error' => $e->getMessage()], 400);
    }
  }

  public function getArticle($id)
  {
    try {
      $article = $this->articleService->getArticle($id);
      if (!$article) {
        return new JsonResponse(['error' => 'Article not found'], 404);
      }
      return new JsonResponse([
        'id' => $article->getId(),
        'title' => $article->getTitle(),
        'content' => $article->getContent(),
      ]);
    } catch (\Exception $e) {
      return new JsonResponse(['error' => $e->getMessage()], 400);
    }
  }

  public function updateArticle($id, Request $request)
  {
    $data = json_decode($request->getContent(), true);
    $title = $data['title'] ?? '';
    $content = $data['content'] ?? '';

    try {
      $article = $this->articleService->updateArticle($id, $title, $content);
      return new JsonResponse([
        'message' => 'Article updated successfully',
        'id' => $article->getId(),
      ]);
    } catch (\Exception $e) {
      return new JsonResponse(['error' => $e->getMessage()], 400);
    }
  }

  public function deleteArticle($id)
  {
    try {
      $this->articleService->deleteArticle($id);
      return new JsonResponse(['message' => 'Article deleted successfully']);
    } catch (\Exception $e) {
      return new JsonResponse(['error' => $e->getMessage()], 400);
    }
  }

  public function listArticles()
  {
    try {
      $articles = $this->articleService->getAllArticles();
      $result = array_map(function ($article) {
        return [
          'id' => $article->getId(),
          'title' => $article->getTitle(),
          'content' => $article->getContent(),
        ];
      }, $articles);
      return new JsonResponse($result);
    } catch (\Exception $e) {
      return new JsonResponse(['error' => $e->getMessage()], 400);
    }
  }
}
