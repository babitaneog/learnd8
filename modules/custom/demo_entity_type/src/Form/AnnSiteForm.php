<?php

namespace Drupal\demo_entity_type\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class AnnSiteForm.
 *
 * @package Drupal\demo_entity_type\Form
 */
class AnnSiteForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $ann_site = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $ann_site->label(),
      '#description' => $this->t("Label for the Site Announcement."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $ann_site->id(),
      '#machine_name' => [
        'exists' => '\Drupal\demo_entity_type\Entity\AnnSite::load',
      ],
      '#disabled' => !$ann_site->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $ann_site = $this->entity;
    $status = $ann_site->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Site Announcement.', [
          '%label' => $ann_site->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Site Announcement.', [
          '%label' => $ann_site->label(),
        ]));
    }
    $form_state->setRedirectUrl($ann_site->toUrl('collection'));
  }

}
