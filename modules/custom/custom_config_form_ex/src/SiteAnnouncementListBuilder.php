<?php
/**
 * @file 
 * Contains \Drupal\custom_config_form_ex\SiteAnnouncementListBuilder.
 */
namespace Drupal\custom_config_form_ex;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\custom_config_form_ex\Entity\SiteAnnouncementInterface;

class SiteAnnouncementListBuilder extends ConfigEntityListBuilder {
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = t('Label');
    return $header + parent::buildHeader();
  }
  /**
   * {@inheritdoc}
   */
  public function buildRow(SiteAnnouncementInterface $entity) {
    $row['label'] = $entity->label();
    return $row + parent::buildRow($entity);
  }
}
