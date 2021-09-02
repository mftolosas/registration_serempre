<?php

// get all records from myusers table
function get_users() {
    if (db_table_exists('myusers')) {
        $query = \Drupal::database()->select('myusers', 'u');
        $query->fields('u', ['id','name']);
        $results = $query->execute()->fetchAll();
        return $results;
    }
    
}

// create a new record in myusers table
function create_user($field) {
    if (db_table_exists('myusers')) {
        $query = \Drupal::database();
        return $id = $query ->insert('myusers')->fields($field)->execute();
    }
}

// update the record of the selected id in the myusers table
function update_user($field) {
    if (db_table_exists('myusers')) {
        $query = \Drupal::database();
        $query->update('myusers')->fields($field)->condition('id', $_GET['num'])->execute();
    }
}
