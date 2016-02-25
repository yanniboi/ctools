<?php

/**
 * @file
 * Contains \Drupal\ctools\Form\SelectionConditionFormBase.
 */

namespace Drupal\ctools\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\ctools\DisplayVariantInterface;
use Drupal\ctools\Form\ConditionFormBase;

/**
 * Provides a base form for editing and adding a selection condition.
 */
abstract class SelectionConditionFormBase extends ConditionFormBase {

  /**
   * The display variant entity.
   *
   * @var \Drupal\ctools\DisplayVariantInterface
   */
  protected $displayVariant;

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, DisplayVariantInterface $display_variant = NULL, $condition_id = NULL) {
    $this->displayVariant = $display_variant;
    return parent::buildForm($form, $form_state, $condition_id, $display_variant->getContexts());
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $configuration = $this->condition->getConfiguration();
    // If this selection condition is new, add it to the page.
    if (!isset($configuration['uuid'])) {
      $this->displayVariant->addSelectionCondition($configuration);
    }

    // Save the display variant entity.
    $this->displayVariant->save();

    $form_state->setRedirectUrl($this->displayVariant->toUrl('edit-form'));
  }

}
