<?php

/**
 * @file
 * Contains \Drupal\ctools\Form\StaticContextEditForm.
 */

namespace Drupal\ctools\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\ctools\Entity\DisplayVariantInterface;

/**
 * Provides a form for adding a new static context.
 */
class StaticContextEditForm extends StaticContextFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'entity_display_variant_static_context_edit_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function submitButtonText() {
    return $this->t('Update Static Context');
  }

  /**
   * {@inheritdoc}
   */
  protected function submitMessageText() {
    return $this->t('The %label static context has been updated.', ['%label' => $this->staticContext['label']]);
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, DisplayVariantInterface $display_variant = NULL, $name = '') {
    $form = parent::buildForm($form, $form_state, $display_variant, $name);
    // The machine name of an existing context is read-only.
    $form['machine_name'] = array(
      '#type' => 'value',
      '#value' => $name,
    );
    return $form;
  }

}
