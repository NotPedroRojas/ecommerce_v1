<?php

require_once __DIR__ . "/../config/database.php";

function listarProductos() {
    global $conexion;

    $consulta = $conexion->query("SELECT * FROM productos");

    $productos = $consulta->fetchAll(PDO::FETCH_ASSOC);

    return $productos;
}

?>