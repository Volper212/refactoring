<?php
include 'connect.php';

switch ($_GET['action']) {
    case 'edit':
        $remainder = $_GET['name'] % 2;
        $remainder == 0 ? $database->exec('UPDATE tab SET pass = "' . $_GET['value'] . '" WHERE id=' . $_GET['id'])
            : $database->exec('UPDATE tab SET login = "' . $_GET['value'] . '" WHERE id=' . $_GET['id']);
        break;
    case 'duplicate':
        $database->exec('INSERT INTO tab (login, pass) SELECT login, pass FROM tab WHERE id=' . $_GET['id']);
        echo $database->lastInsertId();
        break;
    case 'delete':
        $database->exec('DELETE FROM tab WHERE id=' . $_GET['id']);
        break;
    case 'clear':
        $database->exec('UPDATE tab SET login = "", pass = "" WHERE id=' . $_GET['id']);
        break;
}
