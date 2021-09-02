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

    public function getContent() {
        // First we'll tell the user what's going on. This content can be found
        // in the twig template file: templates/description.html.twig.
        // @todo: Set up links to create nodes and point to devel module.
        $build = [
            'description' => [
                '#theme' => 'registration_serempre_description',
                '#description' => 'foo',
                '#attributes' => [],
            ],
        ];
        return $build;
    }

    /**
     * Display.
     *
     * @return string
     *   Return Hello string.
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