<?php

namespace Drupal\registration_serempre\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Url;

/**
 * Class RegistrationForm.
 *
 * @package Drupal\registration_serempre\Form
 */
class RegistrationForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'registration_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {

        $conn = Database::getConnection();
        $record = array();
        if (isset($_GET['num'])) {
            $query = $conn->select('myusers', 'u')
                ->condition('id', $_GET['num'])
                ->fields('u');
            $record = $query->execute()->fetchAssoc();
        }
        $form['name'] = array(
            '#type' => 'textfield',
            '#title' => t('Name'),
            '#required' => TRUE,
            '#default_value' => (isset($record['name']) && $_GET['num']) ? $record['name']:'',
        );
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#prefix' => '<div id="grievance_form_wrapper">',
            '#suffix' => '</div>',
            '#ajax' => array(
                'callback' => '::_modal_form_grievance_ajax_submit',
            'event' => 'click'
        ),  
            '#value' => $this->t('Submit'),
        ); 
        $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
        return $form;
    }

    /**
    * {@inheritdoc}
    */
    public function validateForm(array &$form, FormStateInterface $form_state) {

    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {

    }

    function _modal_form_grievance_ajax_submit(array $form, FormStateInterface &$form_state) {

        include_once getcwd() . '/modules/custom/registration_serempre/includes/request.inc';

        global $base_url;
        $field = $form_state->getValues();
        $name = $field['name'];
        $field  = array(
            'name' => $name,
        );
        if (isset($_GET['num'])) {
            $id = $_GET['num'];
            update_user($field);
            $form_state->setRedirect('registration_serempre.display_users_controller');
        }
        else
        {
            $id = create_user($field);
        }

        $response = new AjaxResponse();
        if ($form_state->getErrors()) {
            unset($form['#prefix']);
            unset($form['#suffix']);
            $form['status_messages'] = [
                '#type' => 'status_messages',
                '#weight' => -10,
            ];
            $response->addCommand(new HtmlCommand('#grievance_form_wrapper', $form));
        }
        else {
            $content = 'Successful id registration ' .$id .'</br><a href="'.$base_url.'/user/query"> View all users</a>';
            $title = 'Status Registration';
            $response = new AjaxResponse();
            $response->addCommand(new OpenModalDialogCommand($title, $content, array('width'=>'700')));
        }
        return $response;
    }
}
