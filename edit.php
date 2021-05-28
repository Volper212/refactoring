<?php
include 'connect.php';

$remainder = $_GET['name'] % 2;
$remainder == 0 ? $database->exec('UPDATE tab SET pass = "' . $_GET['value'] . '" WHERE id=' . $_GET['id'])
    : $database->exec('UPDATE tab SET login = "' . $_GET['value'] . '" WHERE id=' . $_GET['id']);