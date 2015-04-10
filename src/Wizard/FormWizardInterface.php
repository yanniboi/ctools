<?php

/**
 * @file
 * Contains \Drupal\ctools\Wizard\FormWizardInterface.
 */

namespace Drupal\ctools\Wizard;

use Drupal\Core\Form\FormStateInterface;

/**
 * Form wizard interface.
 */
interface FormWizardInterface {

  /**
   * The fieldset #title for your label & machine name elements.
   *
   * @return string
   */
  public function getWizardLabel();

  /**
   * The form element #title for your unique identifier label.
   *
   * @return string
   */
  public function getMachineLabel();

  /**
   * The shared temp store factory collection name.
   *
   * @return string
   */
  public function getTempstoreId();

  /**
   * The active SharedTempStore for this wizard.
   *
   * @return \Drupal\user\SharedTempStore
   */
  public function getTempstore();

  /**
   * The SharedTempStore key for our current wizard values.
   *
   * @return null|string
   */
  public function getMachineName();

  /**
   * Retrieve the current active step of the wizard.
   *
   * This will return the first step of the wizard if no step has been set.
   *
   * @param mixed $cached_values
   *   The values returned by $this->getTempstore()->get($this->getMachineName());
   *
   * @return string
   */
  public function getStep($cached_values);

  /**
   * Retrieve a list of FormInterface classes by their step key in the wizard.
   *
   * @return array
   *   A
   */
  public function getOperations();

  /**
   * Retrieve the current Operation.
   *
   * @param mixed $cached_values
   *   The values returned by $this->getTempstore()->get($this->getMachineName());
   *
   * @return string
   *   The class name to instantiate.
   */
  public function getOperation($cached_values);

  /**
   * The name of the route to which forward or backwards steps redirect.
   *
   * @return string
   */
  public function getRouteName();

  /**
   * The Route parameters for a 'next' step.
   *
   * If your route requires more than machine_name and step keys, override and
   * extend this method as needed.
   *
   * @param mixed $cached_values
   *   The values returned by $this->getTempstore()->get($this->getMachineName());
   *
   * @return array
   *   An array keyed by:
   *     machine_name
   *     step
   */
  public function getNextParameters($cached_values);

  /**
   * The Route parameters for a 'previous' step.
   *
   * If your route requires more than machine_name and step keys, override and
   * extend this method as needed.
   *
   * @param mixed $cached_values
   *   The values returned by $this->getTempstore()->get($this->getMachineName());
   *
   * @return array
   *   An array keyed by:
   *     machine_name
   *     step
   */
  public function getPreviousParameters($cached_values);

  /**
   * Form submit handler to step backwards in the wizard.
   *
   * "Next" steps are handled by \Drupal\Core\Form\FormInterface::submitForm().
   *
   * @param array $form
   *   Drupal form array
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current form state of the wizard. This will not contain values from
   *   the current step since the previous button does not actually submit
   *   those values.
   */
  public function previous(array &$form, FormStateInterface $form_state);

  /**
   * Form submit handler for finalizing the wizard values.
   *
   * If you need to generate an entity or save config or raw table data
   * subsequent to your form wizard, this is the responsible method.
   *
   * @param array $form
   *   Drupal form array
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The final form state of the wizard.
   *
   * @return
   */
  public function finish(array &$form, FormStateInterface $form_state);

}
