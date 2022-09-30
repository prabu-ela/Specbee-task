<?php

namespace Drupal\custom_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Main Class for the config Form.
 */
class TaskForm extends ConfigFormBase {

  /**
   * Config Form service name.
   */
  const SETTINGS = 'custom_module.zone_location';

  /**
   * Declarion of form id.
   */
  public function getFormId() {
    return 'zone_location_settings';
  }

  /**
   * Declation of configuration name.
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * Building a form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    // Declaring array of option for zone.
    $option = [
      'America/Chicago' => 'America/Chicago',
      'America/New_York' => 'America/New_York',
      'Asia/Tokyo' => 'Asia/Tokyo',
      'Asia/Dubai' => 'Asia/Dubai',
      'Asia/Kolkata' => 'Asia/Kolkata',
      'Europe/Amsterdam' => 'Europe/Amsterdam',
      'Europe/Oslo' => 'Europe/Oslo',
      'Europe/London' => 'Europe/London',
    ];

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => $config->get('country'),
    ];
    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => $config->get('city'),
    ];
    $form['zone'] = [
      '#type' => 'select',
      '#title' => $this->t('Time Zone'),
      '#options' => $option,
      '#default_value' => $config->get('zone'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * Subimiting the configuraiton form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Fetching the configuration.
    $this->config(static::SETTINGS)

    // Saving the configuration settings.
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('zone', $form_state->getValue('zone'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
