<?php

require_once __DIR__ . "/../../config/database.php";

function obtenerOCrearCarrito() {
    global $conexion;

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION["idUsuario"])) {

        $idUsuario = (int) $_SESSION["idUsuario"];

        $consulta = $conexion->prepare(
            "SELECT idCarrito FROM carritos WHERE idUsuario = ?"
        );
        $consulta->execute([$idUsuario]);

        $carrito = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($carrito) {
            return $carrito["idCarrito"];
        }

        $consulta = $conexion->prepare(
            "INSERT INTO carritos (idUsuario) VALUES (?)"
        );
        $consulta->execute([$idUsuario]);

        return $conexion->lastInsertId();
    }

    $identificador = session_id();

    $consulta = $conexion->prepare(
        "SELECT idCarrito FROM carritos
         WHERE identificadorSesion = ? AND idUsuario IS NULL"
    );
    $consulta->execute([$identificador]);

    $carrito = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($carrito) {
        return $carrito["idCarrito"];
    }

    $consulta = $conexion->prepare(
        "INSERT INTO carritos (identificadorSesion) VALUES (?)"
    );
    $consulta->execute([$identificador]);

    return $conexion->lastInsertId();
}


function agregarProducto($idProducto) {
    global $conexion;
    $idProducto = (int) $idProducto;
    if ($idProducto <= 0) {
        return;
    }
    $consulta = $conexion->prepare(
        "SELECT idProducto, stock FROM productos WHERE idProducto = ?"
    );
    $consulta->execute([$idProducto]);
    $producto = $consulta->fetch(PDO::FETCH_ASSOC);

    if (!$producto || $producto["stock"] <= 0) {
        return;
    }

    $idCarrito = obtenerOCrearCarrito();

    $consulta = $conexion->prepare(
        "SELECT idItemCarrito, cantidad
         FROM items_carrito
         WHERE idCarrito = ? AND idProducto = ?"
    );
    $consulta->execute([$idCarrito, $idProducto]);
    $item = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($item) {
        $nuevaCantidad = $item["cantidad"] + 1;

        if ($nuevaCantidad > $producto["stock"]) {
            return;
        }

        $consulta = $conexion->prepare(
            "UPDATE items_carrito SET cantidad = ? WHERE idItemCarrito = ?"
        );
        $consulta->execute([$nuevaCantidad, $item["idItemCarrito"]]);
    } else {
        $consulta = $conexion->prepare(
            "INSERT INTO items_carrito (idCarrito, idProducto, cantidad)
             VALUES (?, ?, 1)"
        );
        $consulta->execute([$idCarrito, $idProducto]);
    }
}


function modificarCantidad($idProducto, $cambio) {
    global $conexion;
    $idProducto = (int) $idProducto;
    $cambio = (int) $cambio;

    if ($idProducto <= 0 || ($cambio != 1 && $cambio != -1)) {
        return;
    }

    $idCarrito = obtenerOCrearCarrito();
    $consulta = $conexion->prepare(
        "SELECT items_carrito.idItemCarrito, items_carrito.cantidad,
                productos.stock
         FROM items_carrito
         INNER JOIN productos
            ON items_carrito.idProducto = productos.idProducto
         WHERE items_carrito.idCarrito = ? AND items_carrito.idProducto = ?"
    );
    $consulta->execute([$idCarrito, $idProducto]);
    $item = $consulta->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        return;
    }

    $nuevaCantidad = $item["cantidad"] + $cambio;

    if ($cambio > 0 && $nuevaCantidad > $item["stock"]) {
        return;
    }

    if ($nuevaCantidad <= 0) {
        eliminarProducto($idProducto);
    } else {
        $consulta = $conexion->prepare(
            "UPDATE items_carrito SET cantidad = ? WHERE idItemCarrito = ?"
        );
        $consulta->execute([$nuevaCantidad, $item["idItemCarrito"]]);
    }
}

function eliminarProducto($idProducto) {
    global $conexion;
    $idProducto = (int) $idProducto;
    if ($idProducto <= 0) {
        return;
    }
    $idCarrito = obtenerOCrearCarrito();
    $consulta = $conexion->prepare(
        "DELETE FROM items_carrito WHERE idCarrito = ? AND idProducto = ?"
    );
    $consulta->execute([$idCarrito, $idProducto]);
}

?>
