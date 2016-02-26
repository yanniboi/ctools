<?php

/**
 * @file
 * Contains \Drupal\mini_panels\Form\ParameterEditForm.
 */

namespace Drupal\mini_panels\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\ctools\Entity\DisplayInterface;

/**
 * Provides a form for editing a parameter.
 */
class ParameterEditForm extends ParameterFormBase {

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
    return $this->t('Update Parameter');
  }

  /**
   * {@inheritdoc}
   */
  protected function submitMessageText() {
    return $this->t('The %label parameter has been updated.', ['%label' => $this->parameter['label']]);
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, DisplayInterface $mini_panel = NULL, $name = '') {
    $form = parent::buildForm($form, $form_state, $mini_panel, $name);
    // The machine name of an existing context is read-only.
    $form['machine_name'] = array(
      '#type' => 'value',
      '#value' => $name,
    );
    return $form;
  }

}
