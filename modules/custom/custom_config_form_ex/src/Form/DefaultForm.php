<?php

namespace Drupal\custom_config_form_ex\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;

/**
 * Class DefaultForm.
 *
 * @package Drupal\custom_config_form_ex\Form
 */
class DefaultForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'custom_config_form_ex.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'default_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('custom_config_form_ex.settings');
    $form['title'] = array(
      '#type' => 'textfield',
      '#title' => t('Title'),
      '#required' => TRUE,
      '#default_value' => $config->get('title'),
    );
    $form['video'] = array(
      '#type' => 'textfield',
      '#title' => t('Youtube video'),
      '#default_value' => $config->get('video')
    );
    $form['develop'] = array(
      '#type' => 'checkbox',
      '#title' => t('I would like to be involved in developing this material'),
      '#default_value' => $config->get('develop'),
    );
    $form['description'] = array(
      '#type' => 'textarea',
      '#title' => t('Description'),
      '#default_value' => $config->get('description'),
    );
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      drupal_set_message($key . ': ' . $value);
    }

    // Save result in local module settings config
    $this->config('custom_config_form_ex.settings')
        ->set('title', $form_state->getValue('title'))
        ->set('video', $form_state->getValue('video'))
        ->set('develop', $form_state->getValue('develop'))
        ->set('description', $form_state->getValue('description'))
        ->save();
  }
}
