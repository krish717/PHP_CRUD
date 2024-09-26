<?php
session_start();
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'player';


$conn = new mysqli($host, $username, $password, $database);

if(!$conn) echo "Not Connected";
?>
