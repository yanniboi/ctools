<?php

/**
 * @file
 * Contains \Drupal\mini_panels\Entity\MiniPanel.
 */

namespace Drupal\mini_panels\Entity;

use Drupal\ctools\Entity\DisplayBase;

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
 *     "parameters",
 *   },
 * )
 */
class MiniPanel extends DisplayBase {

  /**
   * {@inheritdoc}
   */
  public function getParameters() {
    return $this->parameters;
  }

  /**
   * {@inheritdoc}
   */
  public function getParameter($name) {
    if (!isset($this->parameters[$name])) {
      $this->setParameter($name, '');
    }
    return $this->parameters[$name];
  }

  /**
   * {@inheritdoc}
   */
  public function setParameter($name, $type, $label = '') {
    $this->parameters[$name] = [
      'machine_name' => $name,
      'type' => $type,
      'label' => $label,
    ];
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function removeParameter($name) {
    unset($this->parameters[$name]);
    return $this;
  }
}
