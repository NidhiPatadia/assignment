<?php

namespace Drupal\specbee_assignment\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\specbee_assignment\Manager\TimeZoneManager;
use Drupal\Core\Cache\Cache;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "timezone_block",
 *   admin_label = @Translation("Specbee Assignment Timezone Block"),
 *   category = @Translation("Specbee Assignment Timezone Block")
 * )
 */
class TimezoneBlock extends BlockBase implements ContainerFactoryPluginInterface {
  
  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;
  
  /**
   *
   * @var Drupal\specbee_assignment\Manager\TimeZoneManager
   */
  protected $timezoneManager;

  /**
   * TimezoneBlock constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * 
   * @param \Drupal\specbee_assignment\Manager\TimeZoneManager $timezoneManager
   *   TimeZone manager.
   *
   */
  public function __construct($configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory, TimeZoneManager $timezoneManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
    $this->timezoneManager = $timezoneManager;
  }
  
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('specbee.timezone.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    
    $output = [];
    $config = $this->configFactory->getEditable('specbee_assignment.settings');
    $output['country'] = $config->get('country');
    $output['city'] = $config->get('city');
    $output['time'] = $this->timezoneManager->getTimeFromTimeZone($config->get('timezone'));
    return [
      '#theme' => 'timezoneblock',
      '#output' => $output,
      '#cache' => [
        'tags' => $config->getCacheTags(),
        'max-age' => Cache::PERMANENT,
      ],
    ];
  }

}
