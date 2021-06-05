<?php
class Api {
    function __construct(private PDO $database) {}

    function select(): array {
        return $this->database->query("SELECT * FROM tab")->fetchAll(PDO::FETCH_NUM);
    }

    function edit(array $input): void {
        $this->database->prepare("UPDATE tab SET login = ?, pass = ? WHERE id = ?")->execute($input);
    }

    function duplicate(array $input): string {
        $this->database->prepare("INSERT INTO tab (login, pass) SELECT login, pass FROM tab WHERE id = ?")->execute($input);
        return $this->database->lastInsertId();
    }

    function delete(array $input): void {
        $this->database->prepare("DELETE FROM tab WHERE id = ?")->execute($input);
    }

    function clear(array $input): void {
        $this->database->prepare("UPDATE tab SET login = '', pass = '' WHERE id = ?")->execute($input);
    }
}