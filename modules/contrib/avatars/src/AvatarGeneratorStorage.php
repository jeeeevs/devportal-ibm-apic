<?php

namespace Drupal\avatars;

use Drupal\Core\Config\Entity\ConfigEntityStorage;

/**
 * Storage controller for avatar generators.
 */
class AvatarGeneratorStorage extends ConfigEntityStorage implements AvatarGeneratorStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function getEnabledAvatarGenerators() {
    $result = $this->getQuery()
      ->accessCheck(FALSE)
      ->condition('status', TRUE)
      ->execute();
    return $this->loadMultiple($result);
  }

}
