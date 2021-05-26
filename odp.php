<?php
include './connect.php';

switch ($_GET['action']) {
    case 'edit':
        $a = $_GET['name'] % 2;
        $a == 0 ? $sql->exec('UPDATE tab SET pass = "' . $_GET['val'] . '" WHERE id=' . $_GET['id'])
            : $sql->exec('UPDATE tab SET login = "' . $_GET['val'] . '" WHERE id=' . $_GET['id']);
        break;
    case 'dup':
        $sql->exec('INSERT INTO tab (login, pass) SELECT t.login, t.pass FROM tab t WHERE id=' . $_GET['id']);
        $a = $sql->query('SELECT id, login, pass FROM tab ORDER BY id DESC LIMIT 1') ?: die('Nie udało się pobrać rekordów');

        echo json_encode($a->fetchAll(PDO::FETCH_NUM));
        break;
    case 'del':
        $sql->exec('DELETE FROM tab WHERE id=' . $_GET['id']);
        break;
    case 'clear':
        $sql->exec('UPDATE tab SET login = "", pass = "" WHERE id=' . $_GET['id']);
        break;
}
