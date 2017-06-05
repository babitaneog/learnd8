<?php

namespace Drupal\sr_events_subscriber_demo\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
//use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;


/**
 * Class DefaultSubscriber.
 *
 * @package Drupal\sr_events_subscriber_demo
 */
class DefaultSubscriber implements EventSubscriberInterface {


  /**
   * Constructs a new DefaultSubscriber object.
   */
  public function __construct(LoggerChannelFactoryInterface $loggerFactory) {
    $this->loggerFactory = $loggerFactory;
  }
  
  public function onKernelRequest(GetResponseEvent $event) {
    //var_dump($event); die;
    $request = $event->getRequest();
    $shouldRoar = $request->query->get('roar');
    
    if ($shouldRoar) {
      //var_dump('ROOOOOAR');die;
      $this->loggerFactory->get('default')
          ->debug('Roar requested ROOOOOOOOAR');
    }
    
  }
  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events = [
      KernelEvents::REQUEST => 'onKernelRequest',
    ];
    return $events;
  }


}
