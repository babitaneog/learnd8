<?php

/*
 * 
 * @file
 * Contains \Drupal\service_dependency_injection_dem\Controller\DemoController.
 */
namespace Drupal\service_dependency_injection_dem\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * DemoController
 */
class DemoController extends ControllerBase {
  protected $demoService;
  
  /**
   * Class constructor.
   */
  public function __construct($demoService) {
    $this->demoService = $demoService;
  }
  
  /**
   * {@inheritdoc}
   * 
   * The create() method creates a new instance of our controller class passing 
   * to it our service retrieved from the container.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('service_dependency_injection_dem.demo_service')
    );
  }
  
  /**
   * Generates an example page.
   */
  public function demo() {
    return array(
      '#markup' => t('Hello @value!', array('@value' => $this->demoService->getDemoValue())),
    );
  }
}
