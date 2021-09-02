<?php

namespace Drupal\registration_serempre\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Database\Query\PagerSelectExtender;

/**
 * Class DisplayUsersController.
 *
 * @package Drupal\registration_serempre\Controller
 */
class DisplayUsersController extends ControllerBase {

    /**
     * Display Table.
     */
    public function display() {

        include_once getcwd() . '/modules/custom/registration_serempre/includes/request.inc';
 
        $header_table = array(
            'id'=> t('ID'),
            'name' => t('Name'),
            'opt' => t('Operations'),
            'opt1' => t('Operations'),
        );

        //select records from table
        $results = get_users();

        $rows = array();
        foreach($results as $data){
            $delete = Url::fromUserInput('/user/delete/'.$data->id);
            $edit   = Url::fromUserInput('/user/registration?num='.$data->id);

            //print the data from table
            $rows[] = array(
                'id' =>$data->id,
                'name' => $data->name,
                \Drupal::l('Delete', $delete),
                \Drupal::l('Edit', $edit),
            );
        }
    
        //display data in site
        $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No users found'),
        ];
        $form['#cache'] = ['max-age' => 0];
        return $form;
    }
}