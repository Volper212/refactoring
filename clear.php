<?php
include 'connect.php';

$database->exec('UPDATE tab SET login = "", pass = "" WHERE id=' . $_GET['id']);