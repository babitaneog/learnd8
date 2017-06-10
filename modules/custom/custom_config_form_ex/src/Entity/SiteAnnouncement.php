<?php

/*
 * @file
 * Contains \Drupal\custom_config_form_ex\Entity\SiteAnnouncement.
 */

namespace Drupal\custom_config_form_ex\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * @ConfigEntityType(
 *  id = "announcement",
 *  label = @Translation("Site Announcement"),
 *  handlers = {
 *    "list_builder" = "Drupal\custom_config_form_ex\SiteAnnouncementListBuilder",
 *    "form" = {
 *      "default" = "Drupal\custom_config_form_ex\SiteAnnouncementForm",
 *      "add" = "Drupal\custom_config_form_ex\SiteAnnouncementForm",
 *      "edit" = "Drupal\custom_config_form_ex\SiteAnnouncementForm",
 *      "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *    }
 *  },
 *  config_prefix = "announcement",
 *  entity_keys = {
 *   "id" = "id",
 *   "label" = "label"
 *  },
 *   links = {
 *     "delete-form" = "/admin/config/system/site-announcements/manage/{announcement}/delete",
 *     "edit-form" = "/admin/config/system/site-announcements/manage/{announcement}",
 *     "collection" = "/admin/config/system/site-announcements",
 *   },
 *  config_export = {
 *     "id",
 *     "label",
 *     "message",
 *  }
 * )
 */
class SiteAnnouncement extends ConfigEntityBase implements SiteAnnouncementInterface {
  /**
   * The announcement's message.
   *
   * @var string
   */
  protected $message;
  
  /**
   * {@inheritdoc}
   */
  public function getMessage() {
    return $this->message;
  }
}
