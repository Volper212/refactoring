<?php
include 'connect.php';

executeWithId($database, "UPDATE tab SET login = '', pass = '' WHERE id = :id");