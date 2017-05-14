<?php

/**
 * @file 
 * Contains \Drupal\custom_config_form_ex\Entity\SiteAnnouncementInterface.
 */

namespace Drupal\custom_config_form_ex\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

interface SiteAnnouncementInterface extends ConfigEntityInterface {

  /**
   * Gets the message value.
   * 
   * @return string
   */
  public function getMessage();
}
