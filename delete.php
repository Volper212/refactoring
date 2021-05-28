<?php
include 'connect.php';

$database->exec('DELETE FROM tab WHERE id=' . $_GET['id']);