<?php

namespace Drupal\Tests\avatars\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\avatars\Entity\AvatarGenerator;
use Drupal\Tests\user\Traits\UserCreationTrait;

/**
 * Tests generated permissions.
 *
 * @group avatars
 * @coversDefaultClass \Drupal\avatars\Permissions
 */
final class AvatarKitPermissionsTest extends KernelTestBase {

  use UserCreationTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['avatars', 'user', 'avatars_test', 'system', 'file'];

  /**
   * The permissions handler.
   *
   * @var \Drupal\user\PermissionHandlerInterface
   */
  protected $permissionHandler;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->permissionHandler = $this->container->get('user.permissions');
  }

  /**
   * Test default behaviour of testGetAvatarGeneratorsForUser().
   *
   * Get all avatar generators for a user excluding user_preference plugins.
   *
   * @covers ::avatarGenerators
   */
  public function testPermissions(): void {
    $generator_1 = AvatarGenerator::create([
      'label' => $this->randomMachineName(),
      'id' => $this->randomMachineName(),
      'plugin' => 'user_preference',
    ]);
    $generator_1
      ->setStatus(TRUE)
      ->save();

    $generator_2 = AvatarGenerator::create([
      'label' => $this->randomMachineName(),
      'id' => $this->randomMachineName(),
      'plugin' => 'avatars_test_static',
    ]);
    $generator_2
      ->setStatus(TRUE)
      ->save();

    $permissions = $this->permissionHandler->getPermissions();
    $this->assertFalse(isset($permissions['avatars avatar_generator user ' . $generator_1->id()]));
    $this->assertTrue(isset($permissions['avatars avatar_generator user ' . $generator_2->id()]));
  }

}
