<?php

/********************************************************* {COPYRIGHT-TOP} ***
 * Licensed Materials - Property of IBM
 * 5725-L30, 5725-Z22
 *
 * (C) Copyright IBM Corporation 2018, 2021
 *
 * All Rights Reserved.
 * US Government Users Restricted Rights - Use, duplication or disclosure
 * restricted by GSA ADP Schedule Contract with IBM Corp.
 ********************************************************** {COPYRIGHT-END} **/

namespace Drupal\apic_app\Entity;

use Drupal\apic_app\ApplicationCredentialsInterface;
use Drupal\Core\Entity\ContentEntity;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines an Application Credentials entity class.
 *
 * @ContentEntityType(
 *   id = "apic_app_application_creds",
 *   label = @Translation("Application Credentials"),
 *   label_singular = @Translation("Application Credentials"),
 *   label_plural = @Translation("Application Credentials"),
 *   label_count = @PluralTranslation(
 *     singular = @Translation("application credentials"),
 *     plural = @Translation("application credentials"),
 *   ),
 *   handlers = {
 *     "storage_schema" = "Drupal\apic_app\ApplicationCredentialsSchema",
 *   },
 *   fieldable = FALSE,
 *   translatable = FALSE,
 *   base_table = "apic_app_application_creds",
 *   entity_keys = {
 *     "id" = "id"
 *   }
 * )
 */
class ApplicationCredentials extends ContentEntityBase implements ApplicationCredentialsInterface {

  /**
   * Drupal entity ID
   *
   * @var int
   */
  protected $id;

  /**
   * APIM UUID
   *
   * @var string
   */
  protected $uuid;

  /**
   * The application URL.
   *
   * @var string
   */
  protected $app_url;

  /**
   * The Client ID.
   *
   * @var string
   */
  protected $client_id;

  /**
   * The credentials name.
   *
   * @var string
   */
  protected $name;

  /**
   * The title.
   *
   * @var string
   */
  protected $title;

  /**
   * The summary.
   *
   * @var string
   */
  protected $summary;

  /**
   * The owning consumer organization URL.
   *
   * @var string
   */
  protected $consumerorg_url;

  /**
   * The credentials URL
   *
   * @var string
   */
  protected $cred_url;

  /**
   * APIC Creation timestamp
   *
   * @var int
   */
  protected $created_at;

  /**
   * APIC Modification timestamp
   *
   * @var int
   */
  protected $updated_at;

  /**
   * {@inheritdoc}
   */
  public function id() {
    return $this->id;
  }

  /**
   * {@inheritdoc}
   */
  public function uuid() {
    return $this->uuid;
  }

  /**
   * {@inheritdoc}
   */
  public function app_url() {
    return $this->app_url;
  }

  /**
   * {@inheritdoc}
   */
  public function client_id() {
    return $this->client_id;
  }

  /**
   * {@inheritdoc}
   */
  public function name() {
    return $this->name;
  }

  /**
   * {@inheritdoc}
   */
  public function title() {
    return $this->title;
  }

  /**
   * {@inheritdoc}
   */
  public function summary() {
    return $this->summary;
  }

  /**
   * {@inheritdoc}
   */
  public function consumerorg_url() {
    return $this->consumerorg_url;
  }

  /**
   * {@inheritdoc}
   */
  public function cred_url() {
    return $this->cred_url;
  }

  /**
   * {@inheritdoc}
   */
  public function created_at() {
    return $this->created_at;
  }

  /**
   * {@inheritdoc}
   */
  public function updated_at() {
    return $this->updated_at;
  }

  public function toArray(): array {
    return [
      'id' => $this->id,
      'uuid' => $this->uuid,
      'cred_url' => $this->cred_url,
      'title' => $this->title,
      'summary' => $this->summary,
      'name' => $this->name,
      'consumerorg_url' => $this->consumerorg_url,
      'client_id' => $this->client_id,
      'app_url' => $this->app_url,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = [];

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Application Credentials entity.'))
      ->setSetting('unsigned', TRUE)
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('string')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Application Credentials entity.'))
      ->setReadOnly(TRUE);

    $fields['app_url'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Application URL'))
      ->setDescription(t('The URL of the Application these credentials belongs to'))
      ->setReadOnly(TRUE);

    $fields['client_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Client ID'))
      ->setDescription(t('The client ID for these credentials'))
      ->setReadOnly(TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The credentials name'))
      ->setReadOnly(TRUE);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setDescription(t('The credentials title'))
      ->setReadOnly(TRUE);

    $fields['summary'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Summary'))
      ->setDescription(t('The credentials summary'))
      ->setReadOnly(TRUE);

    $fields['consumerorg_url'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Consumer Organization URL'))
      ->setDescription(t('The URL of the consumer organization which owns the Application'))
      ->setReadOnly(TRUE);

    $fields['cred_url'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Credentials URL'))
      ->setDescription(t('The URL of the credentials'))
      ->setReadOnly(TRUE);

    $fields['created_at'] = BaseFieldDefinition::create('timestamp')
      ->setLabel(t('Creation time'))
      ->setDescription(t('The APIC creation timestamp'))
      ->setDefaultValue(0)
      ->setReadOnly(TRUE);

    $fields['updated_at'] = BaseFieldDefinition::create('timestamp')
      ->setLabel(t('Modification time'))
      ->setDescription(t('The APIC modification timestamp'))
      ->setDefaultValue(0)
      ->setReadOnly(TRUE);

    return $fields;
  }

}
