<?php
include 'connect.php';

const columns = [
    'login' => 'login',
    'password' => 'pass'
];

$column = columns[$_GET['name']];

$statement = $database->prepare("UPDATE tab SET $column = :value WHERE id = :id");
$statement->bindValue(':value', $_GET['value']);
$statement->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
$statement->execute();
