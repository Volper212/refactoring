<?php
include 'connect.php';

$statement = $database->prepare("INSERT INTO tab (login, pass) SELECT login, pass FROM tab WHERE id = :id");
$statement->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
$statement->execute();
echo $database->lastInsertId();