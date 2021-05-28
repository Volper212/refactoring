<?php
include 'connect.php';

$statement = $database->prepare("DELETE FROM tab WHERE id = :id");
$statement->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
$statement->execute();