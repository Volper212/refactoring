<?php
ini_set("display_errors", false);

$database = new PDO('mysql:host=localhost;dbname=baza;encoding=utf8;port=3306', 'root', '');
$input = json_decode(file_get_contents("php://input"));
$action = basename($_SERVER["REQUEST_URI"]);

require "main.php";
$output = main($database, $action, $input);
echo json_encode($output);