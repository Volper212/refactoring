<?php
try {
    $database = new PDO('mysql:host=localhost;dbname=baza;encoding=utf8;port=3306', 'root', '');
} catch (PDOException $e) {
    die('Nie udało się nawiązać połączenia z bazą danych. Spróbuj ponownie później');
}

function executeWithId(PDO $database, string $statement, array $extraParameters = []): void {
    $statement = $database->prepare($statement);
    $statement->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    foreach ($extraParameters as $parameter) {
        $statement->bindValue(":$parameter", $_GET[$parameter]);
    }
    $statement->execute();
}