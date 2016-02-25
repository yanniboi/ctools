<?php

/**
 * @file
 * Contains \Drupal\mini_panels\Form\MiniPanelAddForm.
 */

namespace Drupal\mini_panels\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\mini_panels\Form\MiniPanelFormBase;

/**
 * Provides a form for adding a new mini panel entity.
 */
class MiniPanelAddForm extends MiniPanelFormBase {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    parent::save($form, $form_state);
    drupal_set_message($this->t('The %label mini panel has been added.', ['%label' => $this->entity->label()]));
    $form_state->setRedirect('entity.mini_panel.edit_form', [
      'mini_panel' => $this->entity->id(),
    ]);
  }

}
