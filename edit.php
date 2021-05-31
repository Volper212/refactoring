<?php
include 'connect.php';

const columns = ['login', 'pass'];

$column = columns[$_GET['index'] - 1];

executeWithId($database, "UPDATE tab SET $column = :value WHERE id = :id", ['value']);
