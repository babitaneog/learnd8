<?php

namespace Drupal\demo_entity_type\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Site Announcement entity.
 *
 * @ConfigEntityType(
 *   id = "ann_site",
 *   label = @Translation("Site Announcement"),
 *   handlers = {
 *     "list_builder" = "Drupal\demo_entity_type\AnnSiteListBuilder",
 *     "form" = {
 *       "add" = "Drupal\demo_entity_type\Form\AnnSiteForm",
 *       "edit" = "Drupal\demo_entity_type\Form\AnnSiteForm",
 *       "delete" = "Drupal\demo_entity_type\Form\AnnSiteDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\demo_entity_type\AnnSiteHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "ann_site",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/ann_site/{ann_site}",
 *     "add-form" = "/admin/structure/ann_site/add",
 *     "edit-form" = "/admin/structure/ann_site/{ann_site}/edit",
 *     "delete-form" = "/admin/structure/ann_site/{ann_site}/delete",
 *     "collection" = "/admin/structure/ann_site"
 *   }
 * )
 */
class AnnSite extends ConfigEntityBase implements AnnSiteInterface {

  /**
   * The Site Announcement ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Site Announcement label.
   *
   * @var string
   */
  protected $label;

}
