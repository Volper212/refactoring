<?php
set_exception_handler(function() {
    die("Coś poszło nie tak. Spróbuj ponownie później.");
});

$database = new PDO('mysql:host=localhost;dbname=baza;encoding=utf8;port=3306', 'root', '');
$input = json_decode(file_get_contents("php://input"));
$action = basename($_SERVER["REQUEST_URI"]);

switch ($action) {
    case "select":
        echo json_encode($database->query("SELECT * FROM tab")->fetchAll(PDO::FETCH_NUM));
        break;
    case "edit":
        $database->prepare("UPDATE tab SET login = ?, pass = ? WHERE id = ?")->execute($input);
        break;
    case "duplicate":
        $database->prepare("INSERT INTO tab (login, pass) SELECT login, pass FROM tab WHERE id = ?")->execute($input);
        echo $database->lastInsertId();
        break;
    case "delete":
        $database->prepare("DELETE FROM tab WHERE id = ?")->execute($input);
        break;
    case "clear":
        $database->prepare("UPDATE tab SET login = '', pass = '' WHERE id = ?")->execute($input);
        break;
}