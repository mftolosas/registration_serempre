<?php

function get_users() {
    $query = \Drupal::database()->select('myusers', 'u');
    $query->fields('u', ['id','name']);
    $results = $query->execute()->fetchAll();
    return $results;
}

function create_user($field) {
    $query = \Drupal::database();
    return $id = $query ->insert('myusers')
        ->fields($field)
        ->execute();
}

function update_user($field) {
    $query = \Drupal::database();
    $query->update('myusers')
        ->fields($field)
        ->condition('id', $_GET['num'])
        ->execute();
}
