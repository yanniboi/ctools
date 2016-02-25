<?php

/**
 * @file
 * Contains \Drupal\mini_panels\Form\ParameterEditForm.
 */

namespace Drupal\mini_panels\Form;

/**
 * Provides a form for editing a parameter.
 */
class ParameterAddForm extends ParameterFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'entity_mini_panels_parameter_edit_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function submitButtonText() {
    return $this->t('Add Parameter');
  }

  /**
   * {@inheritdoc}
   */
  protected function submitMessageText() {
    return $this->t('The %label parameter has been added.', ['%label' => $this->parameter['label']]);
  }

}
