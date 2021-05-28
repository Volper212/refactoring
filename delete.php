<?php
include 'connect.php';

executeWithId($database, "DELETE FROM tab WHERE id = :id");