<?php

namespace Drupal\sr_configuration_form_demo\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class MyConfigForm.
 *
 * @package Drupal\sr_configuration_form_demo\Form
 */
class MyConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'sr_configuration_form_demo.myconfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'my_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('sr_configuration_form_demo.myconfig');
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#description' => $this->t('Enter name of config'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => ($config->get('title'))? $config->get('title'): $config->get('sr_configuration_form_demo.title'),
    ];
    $form['category'] = [
      '#type' => 'select',
      '#title' => $this->t('Category'),
      '#description' => $this->t('Enter a category for the config'),
      '#options' => ['food' => $this->t('food'), 'travel' => $this->t('travel'), 'professional' => $this->t('professional')],
      '#size' => 1,
      '#default_value' => ($config->get('category'))? $config->get('category'): $config->get('sr_configuration_form_demo.category'),
    ];
    $form['are_you_interested'] = [
      '#type' => 'radios',
      '#title' => $this->t('Are you interested?'),
      '#default_value' => ($config->get('are_you_interested'))? $config->get('are_you_interested'): $config->get('sr_configuration_form_demo.are_you_interested'),
      '#options' => array('yes' => $this->t('Yes'), 'no' => $this->t('No')),
    ];
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
    parent::submitForm($form, $form_state);

    $this->config('sr_configuration_form_demo.myconfig')
      ->set('title', $form_state->getValue('title'))
      ->set('category', $form_state->getValue('category'))
      ->set('are_you_interested', $form_state->getValue('are_you_interested'))
      ->save();
  }

}
