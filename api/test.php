<?php
require "autoload.php";

class Test extends PHPUnit\Framework\TestCase {
    private Api $api;

    protected function setUp(): void {
        $database = new PDO("mysql:host=localhost;encoding=utf8", "root", "");
        $database->exec("
            DROP DATABASE IF EXISTS test;
            CREATE DATABASE test;
            USE test;
            CREATE TABLE tab (id INT PRIMARY KEY AUTO_INCREMENT, login TEXT NOT NULL, pass TEXT NOT NULL);
            INSERT INTO tab (login, pass) VALUES
                ('prosty człowiek', 'nikt nie pytał0'),
                ('glock', 'admin123#'),
                ('oop', 'egondola');
        ");
        $this->api = new Api($database);
    }

    function testSelect(): void {
        $this->assertTable([
            ["1", "prosty człowiek", "nikt nie pytał0"],
            ["2", "glock", "admin123#"],
            ["3", "oop", "egondola"],
        ]);
    }

    function testEdit(): void {
        $this->api->edit(["prosty chłop", "I asked", 1]);
        $this->assertTable([
            ["1", "prosty chłop", "I asked"],
            ["2", "glock", "admin123#"],
            ["3", "oop", "egondola"],
        ]);
    }

    function testDuplicate(): void {
        $id = $this->api->duplicate([2]);
        $this->assertSame("4", $id);
        $this->assertTable([
            ["1", "prosty człowiek", "nikt nie pytał0"],
            ["2", "glock", "admin123#"],
            ["3", "oop", "egondola"],
            ["4", "glock", "admin123#"],
        ]);
    }

    function testDelete(): void {
        $this->api->delete([2]);
        $this->assertTable([
            ["1", "prosty człowiek", "nikt nie pytał0"],
            ["3", "oop", "egondola"],
        ]);
    }

    function testClear(): void {
        $this->api->clear([3]);
        $this->assertTable([
            ["1", "prosty człowiek", "nikt nie pytał0"],
            ["2", "glock", "admin123#"],
            ["3", "", ""],
        ]);
    }

    private function assertTable(array $content): void {
        $this->assertEquals($content, $this->api->select());
    }
}