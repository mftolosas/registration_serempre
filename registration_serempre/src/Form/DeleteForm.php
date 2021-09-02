<?php

namespace Drupal\registration_serempre\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Render\Element;

/**
 * Class DeleteForm.
 *
 * @package Drupal\registration_serempre\Form
 */
class DeleteForm extends ConfirmFormBase {
    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'delete_form';
    }

    public $uid;

    public function getQuestion() { 
        return t('Do you want to delete?');
    }

    public function getCancelUrl() {
        return new Url('registration_serempre.display_users_controller');
    }

    public function getDescription() {
        return t('Only do this if you are sure!');
    }

    /**
     * {@inheritdoc}
     */
    public function getConfirmText() {
        return t('Delete it!');
    }

    /**
     * {@inheritdoc}
     */
    public function getCancelText() {
        return t('Cancel');
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state, $uid = NULL) {
        $this->id = $uid;
        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        parent::validateForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $query = \Drupal::database();
        $query->delete('myusers')
            ->condition('id', (int)$this->id)
            ->execute();
        drupal_set_message("succesfully deleted");
        $form_state->setRedirect('registration_serempre.display_users_controller');
    }
}
