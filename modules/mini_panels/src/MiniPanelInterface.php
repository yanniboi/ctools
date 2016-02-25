<?php

/**
 * @file
 * Contains \Drupal\mini_panels\MiniPanelInterface.
 */

namespace Drupal\mini_panels;

use Drupal\Component\Plugin\Context\ContextInterface;
use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\Core\Entity\EntityWithPluginCollectionInterface;
use Drupal\ctools\DisplayVariantInterface;

/**
 * Provides an interface for mini_panel entities.
 */
interface MiniPanelInterface extends ConfigEntityInterface, EntityWithPluginCollectionInterface {

  /**
   * Returns whether the mini_panel entity is enabled.
   *
   * @return bool
   *   Whether the mini_panel entity is enabled or not.
   */
  public function status();

  /**
   * Adds a variant to this mini_panel.
   *
   * @param \Drupal\ctools\DisplayVariantInterface $variant
   *   A display variant entity.
   *
   * @return $this
   */
  public function addVariant(DisplayVariantInterface $variant);

  /**
   * Retrieves a specific variant.
   *
   * @param string $variant_id
   *   The variant ID.
   *
   * @return \Drupal\ctools\DisplayVariantInterface
   *   The variant object.
   */
  public function getVariant($variant_id);

  /**
   * Removes a specific variant.
   *
   * @param string $variant_id
   *   The variant ID.
   *
   * @return $this
   */
  public function removeVariant($variant_id);

  /**
   * Returns the variants available for the entity.
   *
   * @return \Drupal\ctools\DisplayVariantInterface[]
   *   An array of the variants.
   */
  public function getVariants();

  /**
   * Returns the conditions used for determining access for this mini_panel entity.
   *
   * @return \Drupal\Core\Condition\ConditionInterface[]|\Drupal\Core\Condition\ConditionPluginCollection
   *   An array of configured condition plugins.
   */
  public function getAccessConditions();

  /**
   * Adds a new access condition to the mini_panel entity.
   *
   * @param array $configuration
   *   An array of configuration for the new access condition.
   *
   * @return string
   *   The access condition ID.
   */
  public function addAccessCondition(array $configuration);

  /**
   * Retrieves a specific access condition.
   *
   * @param string $condition_id
   *   The access condition ID.
   *
   * @return \Drupal\Core\Condition\ConditionInterface
   *   The access condition object.
   */
  public function getAccessCondition($condition_id);

  /**
   * Removes a specific access condition.
   *
   * @param string $condition_id
   *   The access condition ID.
   *
   * @return $this
   */
  public function removeAccessCondition($condition_id);

  /**
   * Returns the logic used to compute access, either 'and' or 'or'.
   *
   * @return string
   *   The string 'and', or the string 'or'.
   */
  public function getAccessLogic();

  /**
   * Returns the parameter context value objects for this page entity.
   *
   * @return array[]
   *   An array of parameter context arrays, keyed by parameter name.
   */
  public function getParameters();

  /**
   * Retrieves a specific parameter context.
   *
   * @param string $name
   *   The parameter context's unique name.
   *
   * @return array
   *   The parameter context array.
   */
  public function getParameter($name);

  /**
   * Adds/updates a given parameter context.
   *
   * @param string $name
   *   The parameter context name.
   * @param string $type
   *   The parameter context type.
   * @param string $label
   *   (optional) The parameter context label.
   *
   * @return $this
   */
  public function setParameter($name, $type, $label = '');

  /**
   * Removes a specific parameter context.
   *
   * @param string $name
   *   The parameter context's unique machine name.
   *
   * @return $this
   */
  public function removeParameter($name);

  /**
   * Gets the names of all parameters for this page.
   *
   * @return string[]
   */
  public function getParameterNames();

  /**
   * Gets the values for all defined contexts.
   *
   * @return \Drupal\Core\Plugin\Context\ContextInterface[]
   *   An array of set context values, keyed by context name.
   */
  public function getContexts();

  /**
   * Sets the context for a given name.
   *
   * @param string $name
   *   The name of the context.
   * @param \Drupal\Component\Plugin\Context\ContextInterface $value
   *   The context to add.
   *
   * @return $this
   */
  public function addContext($name, ContextInterface $value);

}
