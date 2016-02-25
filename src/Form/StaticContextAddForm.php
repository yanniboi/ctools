<?php

/**
 * @file
 * Contains \Drupal\ctools\Form\StaticContextAddForm.
 */

namespace Drupal\ctools\Form;

/**
 * Provides a form for adding a new static context.
 */
class StaticContextAddForm extends StaticContextFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'entity_display_variant_static_context_add_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function submitButtonText() {
    return $this->t('Add Static Context');
  }

  /**
   * {@inheritdoc}
   */
  protected function submitMessageText() {
    return $this->t('The %label static context has been added.', ['%label' => $this->staticContext['label']]);
  }

}
