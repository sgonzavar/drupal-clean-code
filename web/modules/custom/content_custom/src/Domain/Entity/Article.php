<?php


namespace Drupal\content_custom\Domain\Entity;

class Article
{
  private $id;
  private $title;
  private $body;
  private $taxonomy;
  private $contactInfo;

  public function __construct($id, $title, $body, $taxonomy, $contactInfo)
  {
    $this->id = $id;
    $this->title = $title;
    $this->body = $body;
    $this->taxonomy = $taxonomy;
    $this->contactInfo = $contactInfo;
  }

  public function getId() { return $this->id; }
  public function getTitle() { return $this->title; }
  public function setTitle($title) { $this->title = $title; }
  public function getBody() { return $this->body; }
  public function setBody($body) { $this->body = $body; }
  public function getTaxonomy() { return $this->taxonomy; }
  public function setTaxonomy($taxonomy) { $this->taxonomy = $taxonomy; }
  public function getContactInfo() { return $this->contactInfo; }
  public function setContactInfo($contactInfo) { $this->contactInfo = $contactInfo; }
}
