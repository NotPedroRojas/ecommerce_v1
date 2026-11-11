<?php

require_once __DIR__ . "/../../config/database.php";

function listarProductos() {
    global $conexion;
    $consulta = $conexion->query("SELECT * FROM productos");
    $productos = $consulta->fetchAll(PDO::FETCH_ASSOC);
    return $productos;
}

function listarProductosCatalogo() {
    global $conexion;

    $consulta = $conexion->query(
        "SELECT *
         FROM productos
         ORDER BY (stock <= 0) ASC, nombre ASC"
    );

    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

function listarCategorias() {
    global $conexion;
    $consulta = $conexion->query("SELECT * FROM categorias");
    $categorias = $consulta->fetchAll(PDO::FETCH_ASSOC);
    return $categorias;
}

//no se si usar
function listarProveedores() {
    global $conexion;
    $consulta = $conexion->query("SELECT * FROM proveedores");
    $proveedores = $consulta->fetchAll(PDO::FETCH_ASSOC);
    return $proveedores;
}


function crearProducto($producto) {
    global $conexion;
    $consulta = $conexion->prepare(
        "INSERT INTO productos
        (nombre, codigo, idCategoria, descripcion, costo, precio, foto, idProveedor, stock)
        VALUES
        (:nombre, :codigo, :idCategoria, :descripcion, :costo, :precio, :foto, :idProveedor, :stock)"
    );

    $consulta->execute([
        ":nombre" => $producto["nombre"],
        ":codigo" => $producto["codigo"],
        ":idCategoria" => $producto["idCategoria"],
        ":descripcion" => $producto["descripcion"],
        ":costo" => $producto["costo"],
        ":precio" => $producto["precio"],
        ":foto" => $producto["foto"],
        ":idProveedor" => $producto["idProveedor"],
        ":stock" => $producto["stock"]
    ]);
}



function obtenerProductoPorId($idProducto) {
    global $conexion;
    $consulta = $conexion->prepare(
        "SELECT * FROM productos WHERE idProducto = :idProducto"
    );
    $consulta->execute([
        ":idProducto" => $idProducto
    ]);
    $producto = $consulta->fetch(PDO::FETCH_ASSOC);
    return $producto;
}

function actualizarProducto($producto) {
    global $conexion;
    $consulta = $conexion->prepare(
        "UPDATE productos SET
            nombre = :nombre,
            codigo = :codigo,
            idCategoria = :idCategoria,
            descripcion = :descripcion,
            costo = :costo,
            precio = :precio,
            foto = :foto,
            idProveedor = :idProveedor,
            stock = :stock
        WHERE idProducto = :idProducto"
    );

    $consulta->execute([
        ":nombre" => $producto["nombre"],
        ":codigo" => $producto["codigo"],
        ":idCategoria" => $producto["idCategoria"],
        ":descripcion" => $producto["descripcion"],
        ":costo" => $producto["costo"],
        ":precio" => $producto["precio"],
        ":foto" => $producto["foto"],
        ":idProveedor" => $producto["idProveedor"],
        ":stock" => $producto["stock"],
        ":idProducto" => $producto["idProducto"]
    ]);
}

function eliminarProducto($idProducto) {
    global $conexion;
    $consulta = $conexion->prepare(
        "DELETE FROM productos WHERE idProducto = :idProducto"
    );
    $consulta->execute([
        ":idProducto" => $idProducto
    ]);
}

function buscarProductos($termino) {
    global $conexion;

    $consulta = $conexion->prepare(
        "SELECT *
         FROM productos
         WHERE nombre LIKE :termino
         ORDER BY (stock <= 0) ASC, nombre ASC"
    );

    $consulta->execute([
        ":termino" => "%" . $termino . "%"
    ]);

    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

?>