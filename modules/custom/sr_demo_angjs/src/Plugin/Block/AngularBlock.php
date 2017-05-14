<?php

namespace Drupal\sr_demo_angjs\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a block for AngularJS example.
 *
 * @Block(
 *  id = "sr_demo_angjs_angular_block",
 *  admin_label = @Translation("AngularJS Block"),
 * )
 */
class AngularBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      'input' => [
        '#type' => 'textfield',
        '#title' => $this->t('Name'),
        '#placeholder' => $this->t('Enter a name here'),
        '#attributes' => [
          'ng-model' => 'yourName',
        ],
      ],
      'name' => [
        '#markup' => '<hr><h1>Hello {{yourName}}!</h1>',
      ],
      '#attached' => [
        'library' => [
          'sr_demo_angjs/angular',
        ],
      ],
    ];
  }
}
