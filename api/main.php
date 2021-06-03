<?php
function main(PDO $database, string $action, $input) {
    switch ($action) {
        case "select":
            return $database->query("SELECT * FROM tab")->fetchAll(PDO::FETCH_NUM);
        case "edit":
            $database->prepare("UPDATE tab SET login = ?, pass = ? WHERE id = ?")->execute($input);
            break;
        case "duplicate":
            $database->prepare("INSERT INTO tab (login, pass) SELECT login, pass FROM tab WHERE id = ?")->execute($input);
            return $database->lastInsertId();
        case "delete":
            $database->prepare("DELETE FROM tab WHERE id = ?")->execute($input);
            break;
        case "clear":
            $database->prepare("UPDATE tab SET login = '', pass = '' WHERE id = ?")->execute($input);
            break;
    }
}