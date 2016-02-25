<?php

/**
 * @file
 * Contains \Drupal\mini_panels\Plugin\Derivative\MiniPanelDeriver.
 */

namespace Drupal\mini_panels\Plugin\Deriver;

use Drupal\mini_panels\Entity\MiniPanel;
use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Plugin\Context\ContextDefinition;

/**
 * Provides entity view block definitions for each entity type.
 */
class MiniPanelDeriver extends DeriverBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    foreach (MiniPanel::loadMultiple() as $id => $mini_panel) {
      $this->derivatives[$id] = $base_plugin_definition;
      $this->derivatives[$id]['admin_label'] = $this->t('Mini Panel (@label)', ['@label' => $mini_panel->label()]);
      $this->derivatives[$id]['context'] = [
        'mini_panel' => new ContextDefinition('entity:mini_panel'),
      ];
      foreach ($mini_panel->getContexts() as $machine => $context) {
        // @TODO get contexts from mini
        //$this->derivatives[$id]['context'][$machine] = new ContextDefinition($context['types'] . ':' . $context['id']);
      }
    }
    return $this->derivatives;
  }

}
