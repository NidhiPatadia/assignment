<?php

namespace Drupal\specbee_assignment\Manager;

/**
 * Class TimeZoneManager.
 *
 * @package Drupal\specbee_assignment\Manager.
 */
class TimeZoneManager {
  
  /**
   * Function getTimeFromTimeZone.
   */
  public function getTimeFromTimeZone($time_zone) {
    $date = new \DateTime("now", new \DateTimeZone($time_zone));
    return $date->format('jS M Y - h:i A');
  }

}
