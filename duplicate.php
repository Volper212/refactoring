<?php
include 'connect.php';

$database->exec('INSERT INTO tab (login, pass) SELECT login, pass FROM tab WHERE id=' . $_GET['id']);
echo $database->lastInsertId();