<?php

namespace Drupal\restrict_by_ip\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\restrict_by_ip\LoginFirewallInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Triggers the restrict by IP login firewall.
 *
 * @package Drupal\restrict_by_ip
 */
class FirewallSubscriber implements EventSubscriberInterface {

  /**
   * Drupal\restrict_by_ip\LoginFirewallInterface definition.
   *
   * @var Drupal\restrict_by_ip\LoginFirewallInterface
   */
  protected $loginFirewall;

  /**
   * Drupal\Core\Session\AccountInterface definition.
   *
   * @var Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * Constructor.
   */
  public function __construct(LoginFirewallInterface $login_firewall, AccountInterface $current_user) {
    $this->loginFirewall = $login_firewall;
    $this->currentUser = $current_user;
  }

  /**
   * Registers the methods in this class that should be listeners.
   *
   * @return array
   *   An array of event listener definitions.
   */
  public static function getSubscribedEvents() {
    $events['kernel.request'] = ['loginFirewall'];

    return $events;
  }

  /**
   * This method is called whenever the kernel.request event is dispatched.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *   The event.
   */
  public function loginFirewall(GetResponseEvent $event) {
    $this->loginFirewall->execute($this->currentUser);
  }

}
