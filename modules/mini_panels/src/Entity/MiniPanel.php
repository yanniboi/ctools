<?php

/**
 * @file
 * Contains \Drupal\mini_panels\Entity\MiniPanel.
 */

namespace Drupal\mini_panels\Entity;

use Drupal\Component\Plugin\Context\ContextInterface;
use Drupal\ctools\Entity\DisplayBase;
use Drupal\page_manager\Event\PageManagerContextEvent;
use Drupal\page_manager\Event\PageManagerEvents;
use Drupal\mini_panels\MiniPanelInterface;
use Drupal\Core\Condition\ConditionPluginCollection;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\ctools\DisplayVariantInterface;

/**
 * Defines a Mini Panel entity class.
 *
 * @ConfigEntityType(
 *   id = "mini_panel",
 *   label = @Translation("MiniPanel"),
 *   handlers = {
 *     "list_builder" = "Drupal\mini_panels\Entity\MiniPanelsListBuilder",
 *     "access" = "Drupal\mini_panels\Entity\MiniPanelAccess",
 *     "form" = {
 *       "add" = "Drupal\mini_panels\Form\MiniPanelAddForm",
 *       "edit" = "Drupal\mini_panels\Form\MiniPanelEditForm",
 *       "delete" = "Drupal\mini_panels\Form\MiniPanelDeleteForm",
 *     }
 *   },
 *   admin_permission = "administer blocks",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "status" = "status"
 *   },
 *   links = {
 *     "delete-form" = "/admin/structure/block/mini-panels/manage/{mini_panel}/delete",
 *     "edit-form" = "/admin/structure/block/mini-panels/manage/{mini_panel}"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "access_logic",
 *     "access_conditions",
 *   },
 * )
 */
class MiniPanel extends DisplayBase implements MiniPanelInterface {

  /**
   * The ID of the mini_panel entity.
   *
   * @var string
   */
  protected $id;

  /**
   * The label of the mini_panel entity.
   *
   * @var string
   */
  protected $label;

  /**
   * The mini_panel variant entities.
   *
   * @var \Drupal\ctools\DisplayVariantInterface[].
   */
  protected $variants;

  /**
   * An array of collected contexts.
   *
   * @var \Drupal\Component\Plugin\Context\ContextInterface[]
   */
  protected $contexts = [];

  /**
   * The configuration of access conditions.
   *
   * @var array
   */
  protected $access_conditions = [];

  /**
   * Tracks the logic used to compute access, either 'and' or 'or'.
   *
   * @var string
   */
  protected $access_logic = 'and';

  /**
   * The plugin collection that holds the access conditions.
   *
   * @var \Drupal\Component\Plugin\LazyPluginCollection
   */
  protected $accessConditionCollection;

  /**
   * {@inheritdoc}
   */
  public function postSave(EntityStorageInterface $storage, $update = TRUE) {
    parent::postSave($storage, $update);
    static::routeBuilder()->setRebuildNeeded();
  }

  /**
   * {@inheritdoc}
   */
  public static function postDelete(EntityStorageInterface $storage, array $entities) {
    parent::postDelete($storage, $entities);
    static::routeBuilder()->setRebuildNeeded();
  }

  /**
   * Wraps the route builder.
   *
   * @return \Drupal\Core\Routing\RouteBuilderInterface
   *   An object for state storage.
   */
  protected static function routeBuilder() {
    return \Drupal::service('router.builder');
  }

  /**
   * Wraps the entity storage for display variants.
   *
   * @return \Drupal\Core\Entity\EntityStorageInterface
   */
  protected function variantStorage() {
    return \Drupal::service('entity_type.manager')->getStorage('display_variant');
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginCollections() {
    return [
      'access_conditions' => $this->getAccessConditions(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getAccessConditions() {
    if (!$this->accessConditionCollection) {
      $this->accessConditionCollection = new ConditionPluginCollection(\Drupal::service('plugin.manager.condition'), $this->get('access_conditions'));
    }
    return $this->accessConditionCollection;
  }

  /**
   * {@inheritdoc}
   */
  public function addAccessCondition(array $configuration) {
    $configuration['uuid'] = $this->uuidGenerator()->generate();
    $this->getAccessConditions()->addInstanceId($configuration['uuid'], $configuration);
    return $configuration['uuid'];
  }

  /**
   * {@inheritdoc}
   */
  public function getAccessCondition($condition_id) {
    return $this->getAccessConditions()->get($condition_id);
  }

  /**
   * {@inheritdoc}
   */
  public function removeAccessCondition($condition_id) {
    $this->getAccessConditions()->removeInstanceId($condition_id);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getAccessLogic() {
    return $this->access_logic;
  }

  /**
   * {@inheritdoc}
   */
  public function addContext($name, ContextInterface $value) {
    //dpm($value, $name);
    $this->contexts[$name] = $value;
  }

  /**
   * {@inheritdoc}
   */
  public function getContexts() {
    if (!$this->contexts) {
      //$this->eventDispatcher()->dispatch(PageManagerEvents::PAGE_CONTEXT, new PageManagerContextEvent($this));
    }
    return $this->contexts;
  }

  /**
   * {@inheritdoc}
   */
  public function addVariant(DisplayVariantInterface $variant) {
    $this->variants[$variant->id()] = $variant;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getVariant($variant_id) {
    $variants = $this->getVariants();
    if (!isset($variants[$variant_id])) {
      throw new \UnexpectedValueException('The requested variant does not exist or is not associated with this mini panel');
    }
    return $variants[$variant_id];
  }

  /**
   * {@inheritdoc}
   */
  public function removeVariant($variant_id) {
    $this->getVariant($variant_id)->delete();
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getVariants() {
    if (!isset($this->variants)) {
      $this->variants = [];
      /** @var \Drupal\ctools\DisplayVariantInterface $variant */
      foreach ($this->variantStorage()->loadByProperties(['display_entity_id' => $this->id()]) as $variant) {
        $this->variants[$variant->id()] = $variant;
      }
      // Suppress errors because of https://bugs.php.net/bug.php?id=50688.
      @uasort($this->variants, [$this, 'variantSortHelper']);
    }
    return $this->variants;
  }

  /**
   * {@inheritdoc}
   */
  public function variantSortHelper($a, $b) {
    $a_weight = $a->getWeight();
    $b_weight = $b->getWeight();
    if ($a_weight == $b_weight) {
      return 0;
    }

    return ($a_weight < $b_weight) ? -1 : 1;
  }

  /**
   * Wraps the event dispatcher.
   *
   * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
   *   The event dispatcher.
   */
  protected function eventDispatcher() {
    return \Drupal::service('event_dispatcher');
  }

  /**
   * {@inheritdoc}
   */
  public function __sleep() {
    $vars = parent::__sleep();

    // Ensure any plugin collections are stored correctly before serializing.
    // @todo Let https://www.drupal.org/node/2650588 handle this instead.
    foreach ($this->getPluginCollections() as $plugin_config_key => $plugin_collection) {
      $this->set($plugin_config_key, $plugin_collection->getConfiguration());
    }

    // Avoid serializing plugin collections and entities as they might contain
    // references to a lot of objects including the container.
    $unset_vars = [
      'variants',
      'accessConditionCollection',
    ];
    foreach ($unset_vars as $unset_var) {
      if (!empty($this->{$unset_var})) {
        unset($vars[array_search($unset_var, $vars)]);
      }
    }

    return $vars;
  }

}
