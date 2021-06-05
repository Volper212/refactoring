<?php
class Api {
    function __construct(private PDO $database) {}

    function select(): array {
        return $this->database->query("SELECT * FROM tab")->fetchAll(PDO::FETCH_NUM);
    }

    function edit(int $id, array $fields): void {
        $this->database->prepare("UPDATE tab SET login = ?, pass = ? WHERE id = ?")->execute([...$fields, $id]);
    }

    function duplicate(int $id): string {
        $this->database->prepare("INSERT INTO tab (login, pass) SELECT login, pass FROM tab WHERE id = ?")->execute([$id]);
        return $this->database->lastInsertId();
    }

    function delete(int $id): void {
        $this->database->prepare("DELETE FROM tab WHERE id = ?")->execute([$id]);
    }

    function clear(int $id): void {
        $this->database->prepare("UPDATE tab SET login = '', pass = '' WHERE id = ?")->execute([$id]);
    }
}