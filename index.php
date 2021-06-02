<?php
set_exception_handler(function() {
    die("Coś poszło nie tak. Spróbuj ponownie później.");
});

require "connect.php";

const columns = ['login', 'pass'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents("php://input"));
    $action = basename($_SERVER["REQUEST_URI"]);
    switch ($action) {
        case "edit":
            $column = columns[$input->index - 1];
            $database->prepare("UPDATE tab SET $column = ? WHERE id = ?")->execute($input->parameters);
            break;
    }
    die;
}

$table = $database->query("SELECT * FROM tab");
$json = json_encode($table->fetchAll(PDO::FETCH_NUM));

require "layout.php";