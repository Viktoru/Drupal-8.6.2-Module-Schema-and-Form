<?php

namespace Drupal\vu_schema\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;


class VUschemaAddForm extends FormBase {

  /**
   * @return string
   */
  public function getFormId() {
    return 'vu_schema_add_form';
  }

  /**
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *
   * @return array
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = [];

    $form['message'] = [
      '#markup' => $this->t('Add an entry to the vu_schema table.'),
    ];

    $form['add'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Add a person entry'),
    ];
    $form['add']['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#size' => 15,
    ];
    $form['add']['surname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Surname'),
      '#size' => 15,
    ];
    $form['add']['age'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Age'),
      '#size' => 5,
      '#description' => $this->t("Values"),
    ];
    $form['add']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add'),
    ];

    return $form;
  }

  /**
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Verify that the user is logged-in.
//    if ($this->currentUser->isAnonymous()) {
//      $form_state->setError($form['add'], $this->t('You must be logged in to add values to the database.'));
//    }
    // Confirm that age is numeric.
//    if (!intval($form_state->getValue('age'))) {
//      $form_state->setErrorByName('age', $this->t('Age needs to be a number'));
//    }
  }

  /**
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Gather the current user so the new record has ownership.
    $connection = \Drupal::database();
    // Save the submitted entry.
    $entry = array(
      'name' => $form_state->getValue('name'),
      'surname' => $form_state->getValue('surname'),
      'age' => $form_state->getValue('age'),

    );
//    kint($entry);

    $return = $connection->insert('vu_schema')->fields($entry)->execute();

        if ($return) {

          $this->messenger()->addMessage($this->t('Created entry @entry', ['@entry' => print_r($entry, TRUE)]));
        }


  }

}
