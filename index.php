<?php
include "connect.php";

$table = $database->query("SELECT * FROM tab") ?: die("Nie udało się pobrać zawartości tabeli. Spróbuj ponownie później.");

$json = json_encode($table->fetchAll(PDO::FETCH_NUM));

include "layout.php";