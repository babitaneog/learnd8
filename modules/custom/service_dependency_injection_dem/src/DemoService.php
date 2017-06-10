<?php
/**
 * @file 
 * Contains \Drupal\service_dependency_injection_dem\DemoService.
 */
namespace Drupal\service_dependency_injection_dem;

class DemoService {
  protected $demo_value;
  
  public function __construct() {
    $this->demo_value = 'Babita. This string is appearing from DemoService Class!';
  }
  
  public function getDemoValue() {
    return $this->demo_value;
  }
}
