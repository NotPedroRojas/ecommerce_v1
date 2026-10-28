<?php
$host = "localhost";
$database = "ecommerce";
$user = "root";
$password = "";

$conexion = new PDO(
    "mysql:host=$host;dbname=$database",
    $user,
    $password
);
?>