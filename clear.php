<?php
include 'connect.php';

$statement = $database->prepare("UPDATE tab SET login = '', pass = '' WHERE id = :id");
$statement->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
$statement->execute();