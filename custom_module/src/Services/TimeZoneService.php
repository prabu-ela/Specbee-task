<?php

namespace Drupal\custom_module\Services;

use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Class for calculating timezone.
 */
class TimeZoneService {

  /**
   * Configuration Factory.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * Constructor for calling the configuration form.
   */
  public function __construct(ConfigFactory $configFactory) {
    $this->configFactory = $configFactory;
  }

  /**
   * Fetching current time from the config form.
   */
  public function getCurrentTime() {
    $config = $this->configFactory->get('custom_module.zone_location')->get();

    // Setting up default value if no value found.
    $config['country'] = !empty($config['country']) ? $config['country'] : "USA";
    $config['city'] = !empty($config['city']) ? $config['city'] : "New_York, NY";
    $timeZone = !empty($config['zone']) ? $config['zone'] : "America/New_York";

    // Getting Current Time with default UTC timezone.
    $date_time = new \DateTime(date(), new \DateTimeZone("UTC"));

    // Getting current time.
    $drupal_date_time = DrupalDateTime::createFromDateTime($date_time);

    // Rendering to the given timezone.
    $value = $drupal_date_time->setTimezone(new \DateTimeZone($timeZone));

    return [
      'time' => $value->format('g:i a'),
      'date' => $value->format('l, d F Y'),
      'city' => $config['city'],
      'country' => $config['country'],
    ];
  }

}
