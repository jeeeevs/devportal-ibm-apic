<?php

namespace Drupal\file_upload_secure_validator;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceModifierInterface;
use Symfony\Component\Mime\FileinfoMimeTypeGuesser as SymfonyFileinfoMimeTypeGuesser;

/**
 * Dynamically register a fileinfo validator service.
 *
 * Registers only if the fileinfo extension is available.
 */
class FileUploadSecureValidatorServiceProvider implements ServiceModifierInterface {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    if (!(new SymfonyFileinfoMimeTypeGuesser())->isGuesserSupported()) {
      $container->removeDefinition('file_upload_secure_validator');
    }
  }

}
