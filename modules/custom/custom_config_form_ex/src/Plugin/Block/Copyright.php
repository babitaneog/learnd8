<?php

/**
 * @file 
 * Contains \Drupal\custom_config_form_ex\Plugin\Block\Copyright.
 */

namespace Drupal\custom_config_form_ex\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * @Block(
 * id = "copyright_block",
 * admin_label = @Translation("Copyright"),
 * category = @Translation("Custom")
 * )
 */
class Copyright extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $date = new \DateTime();
    return [
      '#markup' => t('Copyright @year&copy; My Company', [
        '@year' => $date->format('Y'),
      ]),
    ];
  }

}
