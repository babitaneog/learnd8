<?php

namespace Drupal\demo_composer_lib\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Forecast\Forecast;

/**
 * Provides a 'ForecastLocBlock' block.
 *
 * @Block(
 *  id = "forecast_loc_block",
 *  admin_label = @Translation("Forecast Location Block"),
 * )
 */
class ForecastLocBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'location_coordinates_latitude' => 0,
      'location_coordinates_longitude' => 0,
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['location_coordinates_latitude'] = [
      '#type' => 'number',
      '#title' => $this->t('Location Coordinates Latitude'),
      '#description' => $this->t('Enter Latitude here'),
      '#default_value' => $this->configuration['location_coordinates_latitude'],
      '#weight' => '0',
      '#required' => TRUE,
      '#step' => 0.000001,
    ];
    $form['location_coordinates_longitude'] = [
      '#type' => 'number',
      '#title' => $this->t('Location Coordinates Longitude'),
      '#description' => $this->t('Enter Longitude here'),
      '#default_value' => $this->configuration['location_coordinates_longitude'],
      '#weight' => '0',
      '#required' => TRUE,
      '#step' => 0.000001,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['location_coordinates_latitude'] = $form_state->getValue('location_coordinates_latitude');
    $this->configuration['location_coordinates_longitude'] = $form_state->getValue('location_coordinates_longitude');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $forecast = new Forecast('7411b0e6d5e0c99fbd7405fd6de00cd5');
    // Get the current forecast for a given latitude and longitude.
    $markup_text = $forecast->get($this->configuration['location_coordinates_latitude'], $this->configuration['location_coordinates_longitude']);
    // Echo '<pre>'; var_dump($markup_text); echo '</pre>';.
    $forecast_text = $markup_text->currently->summary;
    $ftemp = $markup_text->currently->temperature;

    $ftemp_celsius = round(5 * ($ftemp - 32) / 9, 2);

    $build = [];

    $build['forecast_markup']['#markup'] = t('Forecast is @forecast with temperature of @temp deg C', ['@forecast' => $forecast_text, '@temp' => $ftemp_celsius]);

    return $build;
  }

}
