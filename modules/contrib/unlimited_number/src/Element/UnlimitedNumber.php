<?php

declare(strict_types=1);

namespace Drupal\unlimited_number\Element;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\FormElement;

/**
 * Provides an unlimited or number radios element.
 *
 * Properties:
 * - #default_value: A integer or the value of UnlimitedNumber::UNLIMITED.
 * - #min: Minimum value.
 * - #max: Maximum value.
 * - #step: Number stepping, using #min as a base value.
 * - #options:
 *   - unlimited: Label for unlimited radio.
 *   - limited: Label for limited radio.
 *
 * @FormElement(\Drupal\unlimited_number\Element\UnlimitedNumber::PLUGIN_ID)
 */
class UnlimitedNumber extends FormElement {

  public const PLUGIN_ID = 'unlimited_number';

  /**
   * String returned by the element if the unlimited radio is checked.
   */
  const UNLIMITED = 'unlimited';

  /**
   * {@inheritdoc}
   */
  public function getInfo(): array {
    $class = get_class($this);
    return [
      '#input' => TRUE,
      '#process' => [
        [$class, 'processUnlimitedNumber'],
      ],
      '#element_validate' => [
        [$class, 'validateUnlimitedNumber'],
      ],
    ];
  }

  /**
   * Adds form fields for radios and number field.
   *
   * @return array
   *   The processed element.
   */
  public static function processUnlimitedNumber(array &$element, FormStateInterface $form_state, array &$complete_form): array {
    $value = $element['#default_value'] ?? NULL;

    $element['unlimited_number'] = [
      '#type' => 'radios',
      '#options' => NULL,
      '#title' => $element['#title'],
      '#description' => $element['#description'],
      '#required' => !empty($element['#required']),
      // Kills \Drupal\Core\Render\Element\Radios::processRadios.
      '#process' => [],
    ];

    $element['unlimited_number']['unlimited'] = [
      '#prefix' => '<div class="form-item">',
      '#suffix' => '</div>',
    ];
    $element['unlimited_number']['unlimited']['radio'] = [
      '#type' => 'radio',
      '#title' => !empty($element['#options']['unlimited']) ? $element['#options']['unlimited'] : \t('Unlimited'),
      '#return_value' => 'unlimited',
      '#parents' => array_merge($element['#parents'], ['unlimited_number']),
      '#default_value' => $value == static::UNLIMITED ? 'unlimited' : NULL,
      // Errors only on parent.
      '#error_no_message' => TRUE,
      '#attributes' => $element['#attributes'],
      '#ajax' => $element['#ajax'] ?? NULL,
    ];

    $element['unlimited_number']['limited'] = [
      '#prefix' => '<div class="form-item container-inline">',
      '#suffix' => '</div>',
    ];

    $element['unlimited_number']['limited']['radio'] = [
      '#type' => 'radio',
      '#title' => !empty($element['#options']['limited']) ? $element['#options']['limited'] : \t('Limited'),
      '#return_value' => 'limited',
      '#parents' => array_merge($element['#parents'], ['unlimited_number']),
      '#default_value' => is_numeric($value) ? 'limited' : NULL,
      '#error_no_message' => TRUE,
      '#attributes' => $element['#attributes'],
      '#ajax' => $element['#ajax'] ?? NULL,
    ];

    $element['unlimited_number']['limited']['number'] = [
      '#type' => 'number',
      '#parents' => array_merge($element['#parents'], ['number']),
      '#default_value' => is_numeric($value) ? $value : NULL,
      '#field_prefix' => $element['#field_prefix'] ?? NULL,
      '#field_suffix' => $element['#field_suffix'] ?? NULL,
      '#min' => $element['#min'] ?? NULL,
      '#max' => $element['#max'] ?? NULL,
      '#step' => $element['#step'] ?? NULL,
      '#attributes' => $element['#attributes'],
      '#ajax' => $element['#ajax'] ?? NULL,
    ];

    // Must be a tree otherwise the last processed child element will leak its
    // value down to the root element.
    $element['#tree'] = TRUE;

    // Prevent entire tree being required. Fixes empty number field adding
    // errors to the entire tree.
    $element['#required'] = FALSE;

    // Unset options as they are not valid radios.
    unset($element['#options']);

    return $element;
  }

  /**
   * Form element validation handler for unlimited_number elements.
   *
   * @see getInfo().
   */
  public static function validateUnlimitedNumber(array &$element, FormStateInterface $form_state, array &$complete_form): void {
    $value = NULL;
    if ($element['unlimited_number']['#value'] == 'unlimited') {
      $value = static::UNLIMITED;
    }
    elseif ($element['unlimited_number']['#value'] == 'limited') {
      // If limited radio is checked, number field is required.
      $limited = $element['unlimited_number']['limited']['number']['#value'];
      if (is_numeric($limited)) {
        $value = $limited;
      }
      else {
        $form_state->setError(
          $element['unlimited_number']['limited']['number'],
          (string) \t('A number must be entered. Otherwise choose @unlimited.', [
            '@unlimited' => $element['unlimited_number']['unlimited']['radio']['#title'],
          ])
        );
      }
    }
    $form_state->setValueForElement($element, $value);
  }

  /**
   * {@inheritdoc}
   *
   * Maps to $form[$element]['#value'], not $form_state->getValue('element').
   *
   * @return string|int|null
   *   The value.
   */
  public static function valueCallback(&$element, $input, FormStateInterface $form_state) {
    if ($input !== FALSE && $input !== NULL) {
      if (!empty($input['unlimited_number'])) {
        if ($input['unlimited_number'] == 'unlimited') {
          return static::UNLIMITED;
        }
        else {
          return $input['number'];
        }
      }
    }

    // For a NULL default value, set #has_garbage_value.
    // @see \Drupal\Core\Render\Element\Radios
    $element['#has_garbage_value'] = TRUE;
    return NULL;
  }

}
