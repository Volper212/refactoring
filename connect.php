<?php
try
{
    if
    (
        $sql = new PDO('mysql:host=localhost;dbname=baza;encoding=utf8;port=3306', 'root', '' )
    )
    echo '';
}
catch( PDOException $e )
{
    die( 'Nie połączono z bazą "baza"' );
}