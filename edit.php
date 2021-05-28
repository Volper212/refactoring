<?php
include 'connect.php';

const columns = [
    'login' => 'login',
    'password' => 'pass'
];

$column = columns[$_GET['name']];

executeWithId($database, "UPDATE tab SET $column = :value WHERE id = :id", ['value']);
