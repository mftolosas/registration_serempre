<?php

namespace Drupal\registration_serempre\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;


/**
 * Class ExportForm.
 *
 * @package Drupal\registration_serempre\Form
 */
class ExportForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'export_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => 'Export to Excel',
        ];
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {

        include_once getcwd() . '/modules/custom/registration_serempre/includes/request.inc';

        header("Content-Disposition: attachment; filename=\"Users.xls\"");
        header("Content-Type: application/vnd.ms-excel;");
        header('Pragma: no-cache');
        header('Expires: 0');
        
        $file = fopen('php://output', 'w');
        fputcsv($file, array('ID', 'Name'));
        $data_decode = get_users();
        $data = json_decode(json_encode($data_decode), true);
        foreach ($data as $row)
        {
            fputcsv($file, $row);
        }
        fclose($file);
        exit();
    }
}
