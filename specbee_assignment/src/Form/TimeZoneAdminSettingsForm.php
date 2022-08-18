<?php

namespace Drupal\specbee_assignment\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Timezone Setting Form for this site.
 */
class TimeZoneAdminSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'specbee_assignment_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['specbee_assignment.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('specbee_assignment.settings');

    // Country Text field.
    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => $config->get('country'),
      '#description' => $this->t('Please add the country.'),
      '#required' => TRUE,
    ];

    // City Text field.
    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => $config->get('city'),
      '#description' => $this->t('Please add the city.'),
      '#required' => TRUE,
    ];
    
    $options = [
      NULL => $this->t('-Please select a option-'),
      'America/Chicago' => $this->t('America/Chicago'),
      'America/New_York' => $this->t('America/New_York'),
      'Asia/Tokyo' => $this->t('Asia/Tokyo'),
      'Asia/Dubai' => $this->t('Asia/Dubai'),
      'Asia/Kolkata' => $this->t('Asia/Kolkata'),
      'Europe/Amsterdam' => $this->t('Europe/Amsterdam'),
      'Europe/Oslo' => $this->t('Europe/Oslo'),
      'Europe/London' => $this->t('Europe/London'),
    ];

    // Timezone Select field.
    $form['timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Timezone'),
      '#options' => $options,
      '#default_value' => $config->get('timezone'),
      '#description' => $this->t('Please select the timezone.'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('specbee_assignment.settings');
    $config
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
