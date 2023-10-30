<?php

namespace Drupal\noopener_filter\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Noopener settings form.
 */
class NoopenerSettingsForm extends ConfigFormBase {

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    return ['noopener_filter.settings'];
  }

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'noopener_filter_settings_form';
  }

  /**
   * Builds up the form.
   *
   * @param array $form
   *   The form itself.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The state of the form.
   *
   * @return array
   *   The form itself.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('noopener_filter.settings');

    $form['noopener_filter'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Noopener'),
    ];

    $form['noopener_filter']['filter_links'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Filter links'),
      '#description' => $this->t('Filter links through alter link hook.'),
      '#default_value' => $config->get('filter_links'),
      '#required' => FALSE,
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];

    return $form;
  }

  /**
   * Submits the form value.
   *
   * @param array $form
   *   The form itself.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('noopener_filter.settings')
      ->set('filter_links', $form_state->getValue('filter_links'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
