<?php
set_exception_handler(function() {
    die("Coś poszło nie tak. Spróbuj ponownie później.");
});

include "connect.php";

$table = $database->query("SELECT * FROM tab");    

$json = json_encode($table->fetchAll(PDO::FETCH_NUM));

include "layout.php";