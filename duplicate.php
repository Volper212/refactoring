<?php
include 'connect.php';

executeWithId($database, "INSERT INTO tab (login, pass) SELECT login, pass FROM tab WHERE id = :id");
echo $database->lastInsertId();