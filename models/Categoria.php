<?php

require_once __DIR__ . "/../config/database.php";

function listarCategoriasPadre() {
    global $conexion;

    $consulta = $conexion->query(
        "SELECT * FROM categorias
         WHERE idCategoriaPadre IS NULL
         ORDER BY nombre"
    );

    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}


function listarSubcategorias($idCategoriaPadre) {
    global $conexion;

    $consulta = $conexion->prepare(
        "SELECT * FROM categorias
         WHERE idCategoriaPadre = ?
         ORDER BY nombre"
    );

    $consulta->execute([$idCategoriaPadre]);

    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}


function obtenerCategoria($idCategoria) {
    global $conexion;

    $consulta = $conexion->prepare(
        "SELECT * FROM categorias
         WHERE idCategoria = ?"
    );

    $consulta->execute([$idCategoria]);

    return $consulta->fetch(PDO::FETCH_ASSOC);
}


function listarProductosPorCategoria($idCategoria) {
    global $conexion;

    $consulta = $conexion->prepare(
        "SELECT productos.*
         FROM productos
         WHERE productos.idCategoria = ?
            OR productos.idCategoria IN (
                SELECT idCategoria
                FROM categorias
                WHERE idCategoriaPadre = ?
            )
         ORDER BY productos.nombre"
    );

    $consulta->execute([$idCategoria, $idCategoria]);

    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

?>