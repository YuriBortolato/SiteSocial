<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'site';

$conn = new mysqli($host, $user, $pass, $dbname);

if($conn->connect_error){
    die('Error na conexâo com banco de dados: '. $conn->connect_error);
}

$conn->set_charset('utf8');