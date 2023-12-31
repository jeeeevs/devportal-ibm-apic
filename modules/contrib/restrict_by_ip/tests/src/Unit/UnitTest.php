<?php

namespace Drupal\Tests\restrict_by_ip\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\restrict_by_ip\IPTools;
use Drupal\restrict_by_ip\Exception\InvalidIPException;

/**
 * Test the restrict by ip module.
 *
 * @group restrict_by_ip
 */
class UnitTest extends UnitTestCase {

  /**
   * Invalid IPs.
   *
   * @return array
   *   Invalid IPs and reason.
   */
  public function invalidIpProvider() {
    return [
      ['string', 'Not an IP address'],
      ['127.0.0.1', 'Missing CIDR mask'],
      ['127.0.1', 'Not enough octets'],
      ['127.0.0.1/8', 'Invalid /8'],
      ['127.0.0.1/16', 'Invalid /16'],
      ['127.0.0.1/24', 'Invalid /24'],
      ['not.an.ip.address/8', 'Invalid octets'],
      ['192.168.256.1/32', 'Out of range octet'],
      ['192.168.-1.1/32', 'Out of range octet'],
      ['127.0.0.1/octet', 'Invalid CIDR mask'],
      ['127.0.0.1/33', 'Out of range CIDR mask'],
      ['127.0.0.1/-1', 'Out of range CIDR mask'],
    ];
  }

  /**
   * Valid IPs.
   *
   * @return array
   *   Valid IPs and reason.
   */
  public function validIpProvider() {
    return [
      ['127.0.0.0/8', 'Valid /8'],
      ['127.1.0.0/16', 'Valid /16'],
      ['127.1.1.0/24', 'Valid /24'],
      ['127.0.0.1/32', 'Valid /32'],
    ];
  }

  /**
   * Tests IP fail validation.
   *
   * @param string $ip
   *   IP address to be tested.
   *
   * @dataProvider invalidIpProvider
   */
  public function testIpFailValidation($ip) {
    $this->expectException(InvalidIPException::class);
    IPTools::validateIP($ip);
  }

  /**
   * Tests IP valid validation.
   *
   * @param string $ip
   *   IP address to be tested.
   *
   * @dataProvider validIpProvider
   */
  public function testIpPassValidation($ip) {
    $this->assertNull(IPTools::validateIP($ip));
  }

}
