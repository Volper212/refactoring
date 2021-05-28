<?php
include 'connect.php';

const columns = [
    'login' => 'login',
    'password' => 'pass'
];

$column = columns[$_GET['name']];
$value = $_GET['value'];
$id = $_GET['id'];

$database->exec("UPDATE tab SET $column = '$value' WHERE id=$id");