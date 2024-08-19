<?php

namespace Drupal\content_custom\Controller;

use Drupal\Core\Controller\ControllerBase;

class ReactController extends ControllerBase {
  public function content() {
    $build = [
      '#markup' => '<div id="react-app"></div>',
      '#attached' => [
        'library' => [
          'content_custom/react-app',
        ],
      ],
    ];
    return $build;
  }
}
