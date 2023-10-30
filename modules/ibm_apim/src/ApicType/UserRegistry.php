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

namespace Drupal\ibm_apim\ApicType;

/**
 * Class UserRegistry
 *
 * @package Drupal\ibm_apim\ApicType
 */
class UserRegistry {

  /**
   * @var string|null
   */
  private ?string $id = NULL;

  /**
   * @var string|null
   */
  private ?string $name = NULL;

  /**
   * @var string|null
   */
  private ?string $title = NULL;

  /**
   * @var string|null
   */
  private ?string $url = NULL;

  /**
   * @var string|null
   */
  private ?string $summary = NULL;

  /**
   * @var string|null
   */
  private ?string $registry_type = NULL;

  /**
   * @var bool
   */
  private bool $user_managed = FALSE;

  /**
   * @var bool
   */
  private bool $user_registry_managed = FALSE;

  /**
   * @var bool
   */
  private bool $onboarding = FALSE;

  /**
   * @var bool
   */
  private bool $case_sensitive = FALSE;

  /**
   * @var array
   */
  private array $identity_providers = [];

  /**
   * @var string|null
   */
  private ?string $provider_type = NULL;

  /**
   * @var bool
   */
  private bool $redirect_enabled = FALSE;

  /**
   * @return null|string
   */
  public function getId(): ?string {
    return $this->id;
  }

  /**
   * @param string|null $id
   */
  public function setId(?string $id): void {
    $this->id = $id;
  }

  /**
   * @return null|string
   */
  public function getName(): ?string {
    return $this->name;
  }

  /**
   * @param string|null $name
   */
  public function setName(?string $name): void {
    $this->name = $name;
  }

  /**
   * @return null|string
   */
  public function getTitle(): ?string {
    return $this->title;
  }

  /**
   * @param string|null $title
   */
  public function setTitle(?string $title): void {
    $this->title = $title;
  }

  /**
   * @return null|string
   */
  public function getUrl(): ?string {
    return $this->url;
  }

  /**
   * @param string|null $url
   */
  public function setUrl(?string $url): void {
    $this->url = $url;
  }

  /**
   * @return null|string
   */
  public function getSummary(): ?string {
    return $this->summary;
  }

  /**
   * @param string|null $summary
   */
  public function setSummary(?string $summary): void {
    $this->summary = $summary;
  }

  /**
   * @return null|string
   */
  public function getRegistryType(): ?string {
    return $this->registry_type;
  }

  /**
   * @param string|null $registry_type
   */
  public function setRegistryType(?string $registry_type): void {
    $this->registry_type = $registry_type;
  }

  /**
   * @return bool
   */
  public function isUserManaged(): bool {
    return $this->user_managed;
  }

  /**
   * @param bool $user_managed
   */
  public function setUserManaged(bool $user_managed): void {
    $this->user_managed = $user_managed;
  }

  /**
   * @return bool
   */
  public function isUserRegistryManaged(): bool {
    return $this->user_registry_managed;
  }

  /**
   * @param bool $user_registry_managed
   */
  public function setUserRegistryManaged(bool $user_registry_managed): void {
    $this->user_registry_managed = $user_registry_managed;
  }

  /**
   * @return bool
   */
  public function isOnboarding(): bool {
    return $this->onboarding;
  }

  /**
   * @param bool $onboarding
   */
  public function setOnboarding(bool $onboarding): void {
    $this->onboarding = $onboarding;
  }

  /**
   * @return bool
   */
  public function isCaseSensitive(): bool {
    return $this->case_sensitive;
  }

  /**
   * @param bool $case_sensitive
   */
  public function setCaseSensitive(bool $case_sensitive): void {
    $this->case_sensitive = $case_sensitive;
  }

  /**
   * @return null|string
   */
  public function getProviderType(): ?string {
    return $this->provider_type;
  }

  /**
   * @param string|null $provider_type
   */
  public function setProviderType(?string $provider_type): void {
    $this->provider_type = $provider_type;
  }

  /**
   * @return bool
   */
  public function isRedirectEnabled(): bool {
    return $this->redirect_enabled;
  }

  /**
   * @param bool $redirect_enabled
   */
  public function setRedirectEnabled(bool $redirect_enabled): void {
    $this->redirect_enabled = $redirect_enabled;
  }


  /**
   * @return array
   */
  public function getIdentityProviders(): array {
    return $this->identity_providers;
  }

  /**
   * @param array $identity_providers
   */
  public function setIdentityProviders(array $identity_providers): void {
    $this->identity_providers = $identity_providers;
  }

  /**
   * Attempts to find an identity provider with the specified name
   * in this user registry. Returns NULL if there is no such IDP
   * or an array representing the IDP otherwise.
   *
   * @param string $idpNameToFind
   *
   * @return array|null
   */
  public function getIdentityProviderByName(string $idpNameToFind): ?array {

    $result = NULL;

    if (!empty($this->getIdentityProviders())) {
      foreach ($this->getIdentityProviders() as $idp) {
        if ($idp['name'] === $idpNameToFind) {
          $result = $idp;
          break;
        }
      }
    }

    return $result;
  }

  /**
   * Determines if this user registry contains an identity provider
   * with the specified name.
   *
   * @param string $idpNameToFind
   *
   * @return bool
   */
  public function hasIdentityProviderNamed(string $idpNameToFind): bool {
    return ($this->getIdentityProviderByName($idpNameToFind) !== NULL);
  }

  /**
   * Constructs the 'realm' string for the given named IDP
   *
   * @param $idpName
   *
   * @return string
   */
  public function getRealmForIdp($idpName): string {
    $config_service = \Drupal::service('ibm_apim.site_config');
    return 'consumer:' . $config_service->getOrgId() . ':' . $config_service->getEnvId() . '/' . $idpName;
  }

  /**
   * This is a temporary function - there is only one IDP right now so we can
   * hard code the realm for that idp.
   *
   * @return null|string
   */
  public function getRealm(): ?string {
    if (isset($this->getIdentityProviders()[0]['name'])) {
      return $this->getRealmForIdp($this->getIdentityProviders()[0]['name']);
    }

    return NULL;
  }

  /**
   * Extract a single UserRegistry definition from a JSON string
   * representation e.g. as returned by a call to the consumer-api.
   *
   * @param array $registryJson
   */
  public function setValues(array $registryJson): void {

    $this->setId($registryJson['id']);
    $this->setName($registryJson['name']);
    $this->setTitle($registryJson['title']);
    $this->setUrl($registryJson['url']);
    $this->setSummary($registryJson['summary']);
    $this->setRegistryType($registryJson['registry_type']);
    if ((boolean) $registryJson['user_managed'] === TRUE) {
      $this->setUserManaged(TRUE);
    }
    else {
      $this->setUserManaged(FALSE);
    }
    if ((boolean) $registryJson['user_registry_managed'] === TRUE) {
      $this->setUserRegistryManaged(TRUE);
    }
    else {
      $this->setUserRegistryManaged(FALSE);
    }
    if ((boolean) $registryJson['onboarding'] === TRUE) {
      $this->setOnboarding(TRUE);
    }
    else {
      $this->setOnboarding(FALSE);
    }
    if ((boolean) $registryJson['case_sensitive'] === TRUE) {
      $this->setCaseSensitive(TRUE);
    }
    else {
      $this->setCaseSensitive(FALSE);
    }
    $this->setIdentityProviders($registryJson['identity_providers']);
    if (isset($registryJson['configuration']['provider_type'])) {
      $this->setProviderType($registryJson['configuration']['provider_type']);
    }
    if (isset($registryJson['configuration']['features']) && in_array("proxy_redirect", $registryJson['configuration']['features'], TRUE)) {
      $this->setRedirectEnabled(TRUE);
    }
    else {
      $this->setRedirectEnabled(FALSE);
    }

  }

  /**
   * Used in the getconfig drush command
   *
   * @return array
   */
  public function toArray(): array {
    $output = [];
    $output['id'] = $this->getId();
    $output['name'] = $this->getName();
    $output['title'] = $this->getTitle();
    $output['url'] = $this->getUrl();
    $output['summary'] = $this->getSummary();
    $output['registry_type'] = $this->getRegistryType();
    $output['user_managed'] = $this->isUserManaged();
    $output['user_registry_managed'] = $this->isUserRegistryManaged();
    $output['onboarding'] = $this->isOnboarding();
    $output['case_sensitive'] = $this->isCaseSensitive();
    $output['identity_providers'] = $this->getIdentityProviders();
    $output['provider_type'] = $this->getProviderType();
    $output['redirect_enabled'] = $this->isRedirectEnabled();
    return $output;
  }

}
