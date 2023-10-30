<?php
// phpcs:ignoreFile
/**
 * @file
 * A database agnostic dump for testing purposes.
 *
 * This file was generated by the Drupal 9.2.6 db-tools.php script.
 */

use Drupal\Core\Database\Database;

$connection = Database::getConnection();

$connection->schema()->createTable('password_policy', array(
  'fields' => array(
    'pid' => array(
      'type' => 'serial',
      'not null' => TRUE,
      'size' => 'normal',
    ),
    'name' => array(
      'type' => 'varchar',
      'not null' => TRUE,
      'length' => '64',
      'default' => '',
    ),
    'description' => array(
      'type' => 'varchar',
      'not null' => FALSE,
      'length' => '255',
      'default' => '',
    ),
    'enabled' => array(
      'type' => 'int',
      'not null' => TRUE,
      'size' => 'tiny',
      'default' => '0',
    ),
    'constraints' => array(
      'type' => 'varchar',
      'not null' => TRUE,
      'length' => '1024',
      'default' => '',
    ),
    'created' => array(
      'type' => 'int',
      'not null' => TRUE,
      'size' => 'normal',
      'default' => '0',
    ),
    'expiration' => array(
      'type' => 'int',
      'not null' => FALSE,
      'size' => 'normal',
      'default' => '0',
    ),
    'warning' => array(
      'type' => 'varchar',
      'not null' => FALSE,
      'length' => '64',
    ),
    'weight' => array(
      'type' => 'int',
      'not null' => TRUE,
      'size' => 'tiny',
      'default' => '0',
    ),
  ),
  'primary key' => array(
    'pid',
  ),
  'unique keys' => array(
    'name' => array(
      'name',
    ),
  ),
  'mysql_character_set' => 'utf8mb3',
));

$connection->insert('password_policy')
->fields(array(
  'pid',
  'name',
  'description',
  'enabled',
  'constraints',
  'created',
  'expiration',
  'warning',
  'weight',
))
->values(array(
  'pid' => '1',
  'name' => 'Password policy Example D7',
  'description' => '',
  'enabled' => '1',
  'constraints' => 'a:2:{s:9:"uppercase";s:1:"2";s:5:"digit";s:2:"10";}',
  'created' => '0',
  'expiration' => '10',
  'warning' => '5,9',
  'weight' => '0',
))
->values(array(
  'pid' => '2',
  'name' => 'Password policy Example 2  D7',
  'description' => '',
  'enabled' => '1',
  'constraints' => 'a:2:{s:9:"uppercase";s:1:"3";s:5:"digit";s:2:"11";}',
  'created' => '1651134689',
  'expiration' => '0',
  'warning' => '3',
  'weight' => '0',
))
->execute();
