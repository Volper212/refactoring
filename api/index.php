<?php
ini_set("display_errors", false);
require "autoload.php";

$database = new PDO('mysql:host=localhost;dbname=baza;encoding=utf8;port=3306', 'root', '');
$input = json_decode(file_get_contents("php://input")) ?? [];
$action = basename($_SERVER["REQUEST_URI"]);

$api = new Api($database);
echo json_encode($api->$action(...$input));