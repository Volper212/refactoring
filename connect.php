<?php
try {
    $sql = new PDO('mysql:host=localhost;dbname=baza;encoding=utf8;port=3306', 'root', '');
} catch (PDOException $e) {
    die('Nie połączono z bazą "baza"');
}
