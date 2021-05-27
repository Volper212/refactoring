<?php
try {
    $database = new PDO('mysql:host=localhost;dbname=baza;encoding=utf8;port=3306', 'root', '');
} catch (PDOException $e) {
    die('Nie udało się nawiązać połączenia z bazą danych. Spróbuj ponownie później');
}
