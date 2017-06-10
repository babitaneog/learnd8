<?php

namespace Drupal\sr_configuration_form_demo\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class PageConfigController.
 *
 * @package Drupal\sr_configuration_form_demo\Controller
 */
class PageConfigController extends ControllerBase {

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
  public function hello() {
    $config = \Drupal::config('sr_configuration_form_demo.myconfig')->get();

    $markup_text = '<p>' . t('<b>Title</b>: @title', array('@title' => $config['title'])) . '</p>';
    $markup_text .= '<p>' . t('<b>Category</b>: @cat', array('@cat' => $config['category'])) . '</p>';
    $markup_text .= '<p>' . t('<b>Interest level</b>: @interest', array('@interest' => $config['are_you_interested'])) . '</p>';

    return [
      '#type' => 'markup',
      '#markup' => $this->t($markup_text)
    ];
  }

  /**
   * 
   * @return type
   */
  public function content() {
    $config = \Drupal::config('sr_configuration_form_demo.myconfig')->get();

    $markup_text = '<p>' . t('<b>Title</b>: %title', array('%title' => $config['title'])) . '</p>';
    $markup_text .= '<p>' . t('<b>Category</b>: %cat', array('%cat' => $config['category'])) . '</p>';
    $markup_text .= '<p>' . t('<b>Interest level</b>: %interest', array('%interest' => $config['are_you_interested'])) . '</p>';
    return [
      '#theme' => 'my_custom_config',
      '#markup_text' => $this->t($markup_text),
    ];
  }

}
