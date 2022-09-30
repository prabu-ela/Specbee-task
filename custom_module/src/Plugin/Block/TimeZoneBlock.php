<?php

namespace Drupal\custom_module\Plugin\Block;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Block\BlockBase;
use Drupal\custom_module\Services\TimeZoneService;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Time Zone' Block.
 *
 * @Block(
 *   id = "time_zone",
 *   admin_label = @Translation("Time Zone"),
 * )
 */
class TimeZoneBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * To store the config value.
   *
   * @var \Drupal\custom_module\Services\TimeZoneService
   */
  protected $timeZone;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\custom_module\Services\TimeZoneService $timeZone
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, TimeZoneService $timeZone) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->timeZone = $timeZone;
  }

  /**
   * Creating container for calling service.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('custom_module.time_zone')
    );
  }

  /**
   * Creating custom block.
   */
  public function build() {
    $result = $this->timeZone->getCurrentTime();

    $renderable = [
      '#theme' => 'timezone',
      '#current_time' => $result['time'],
      '#current_date' => $result['date'],
      '#city' => $result['city'],
      '#country' => $result['country'],
      '#cache' => [
        'contexts' => ['url.path'],
      ],
    ];
    return $renderable;
  }
}
