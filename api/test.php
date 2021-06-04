<?php
include "main.php";

class Test extends PHPUnit\Framework\TestCase {
    private PDO $database;

    protected function setUp(): void {
        $this->database = new PDO("mysql:host=localhost;encoding=utf8", "root", "");
        $this->database->exec("
            DROP DATABASE IF EXISTS test;
            CREATE DATABASE test;
            USE test;
            CREATE TABLE tab (id INT PRIMARY KEY AUTO_INCREMENT, login TEXT NOT NULL, pass TEXT NOT NULL);
            INSERT INTO tab (login, pass) VALUES
                ('prosty człowiek', 'nikt nie pytał0'),
                ('glock', 'admin123#'),
                ('oop', 'egondola');
        ");
    }

    function testSelect(): void {
        $this->assertTable([
            ["1", "prosty człowiek", "nikt nie pytał0"],
            ["2", "glock", "admin123#"],
            ["3", "oop", "egondola"],
        ]);
    }

    function testEdit(): void {
        main($this->database, "edit", ["prosty chłop", "I asked", 1]);
        $this->assertTable([
            ["1", "prosty chłop", "I asked"],
            ["2", "glock", "admin123#"],
            ["3", "oop", "egondola"],
        ]);
    }

    function testDuplicate(): void {
        $id = main($this->database, "duplicate", [2]);
        $this->assertSame(4, $id);
        $this->assertTable([
            ["1", "prosty człowiek", "nikt nie pytał0"],
            ["2", "glock", "admin123#"],
            ["3", "oop", "egondola"],
            ["4", "glock", "admin123#"],
        ]);
    }

    function testDelete(): void {
        main($this->database, "delete", [2]);
        $this->assertTable([
            ["1", "prosty człowiek", "nikt nie pytał0"],
            ["3", "oop", "egondola"],
        ]);
    }

    function testClear(): void {
        main($this->database, "clear", [3]);
        $this->assertTable([
            ["1", "prosty człowiek", "nikt nie pytał0"],
            ["2", "glock", "admin123#"],
            ["3", "", ""],
        ]);
    }

    private function assertTable(array $content): void {
        $this->assertEquals($content, main($this->database, "select", null));
    }
}