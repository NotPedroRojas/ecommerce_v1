<?php

require_once __DIR__ . "/../../config/database.php";

function listarVentasUsuario($idUsuario) {
    global $conexion;

    $consulta = $conexion->prepare(
        "SELECT *
         FROM ventas
         WHERE idUsuario = ?
         ORDER BY fecha DESC"
    );
    $consulta->execute([$idUsuario]);
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}


function obtenerItemsVenta($idVenta) {
    global $conexion;

    $consulta = $conexion->prepare(
        "SELECT nombreProducto, cantidad, precioUnitario, subtotal
         FROM items
         WHERE idVenta = ?"
    );
    $consulta->execute([$idVenta]);
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}


function registrarCompra($idUsuario, $idDireccion, $metodoPago) {
    global $conexion;

    try {
        require_once __DIR__ . "/../carrito/Carrito.php";
        $idCarrito = obtenerOCrearCarrito();
        $conexion->beginTransaction();
        $consulta = $conexion->prepare(
            "SELECT *
             FROM direcciones
             WHERE idDireccion = ? AND idUsuario = ?"
        );
        $consulta->execute([$idDireccion, $idUsuario]);
        $direccion = $consulta->fetch(PDO::FETCH_ASSOC);
        if (!$direccion) {
            throw new Exception("La dirección seleccionada no es válida.");
        }
        $consulta = $conexion->prepare(
            "SELECT productos.idProducto, productos.nombre,
                    productos.precio, productos.stock,
                    items_carrito.cantidad
             FROM items_carrito
             INNER JOIN productos
                ON items_carrito.idProducto = productos.idProducto
             WHERE items_carrito.idCarrito = ?
             FOR UPDATE"
        );
        $consulta->execute([$idCarrito]);
        $productos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        if (count($productos) == 0) {
            throw new Exception("El carrito está vacío.");
        }

        $total = 0;
        foreach ($productos as $producto) {
            if ($producto["cantidad"] > $producto["stock"]) {
                throw new Exception(
                    "No hay stock suficiente de " . $producto["nombre"] . "."
                );
            }
            $total = $total + (
                $producto["precio"] * $producto["cantidad"]
            );
        }

        $consulta = $conexion->prepare(
            "INSERT INTO ventas
             (idUsuario, total, calle, numero, pisoDepto,
              ciudad, provincia, codigoPostal, metodoPago)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $consulta->execute([
            $idUsuario,
            $total,
            $direccion["calle"],
            $direccion["numero"],
            $direccion["pisoDepto"],
            $direccion["localidad"],
            $direccion["provincia"],
            $direccion["codigoPostal"],
            $metodoPago
        ]);

        $idVenta = $conexion->lastInsertId();
        foreach ($productos as $producto) {
            $subtotal = $producto["precio"] * $producto["cantidad"];
            $consulta = $conexion->prepare(
                "INSERT INTO items
                 (idVenta, idProducto, nombreProducto,
                  cantidad, precioUnitario, subtotal)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );

            $consulta->execute([
                $idVenta,
                $producto["idProducto"],
                $producto["nombre"],
                $producto["cantidad"],
                $producto["precio"],
                $subtotal
            ]);

            $consulta = $conexion->prepare(
                "UPDATE productos
                 SET stock = stock - ?
                 WHERE idProducto = ?"
            );

            $consulta->execute([
                $producto["cantidad"],
                $producto["idProducto"]
            ]);
        }
        $consulta = $conexion->prepare(
            "DELETE FROM items_carrito WHERE idCarrito = ?"
        );
        $consulta->execute([$idCarrito]);
        $conexion->commit();

        return [
            "exito" => true,
            "idVenta" => $idVenta
        ];

    } catch (Throwable $error) {

        if ($conexion->inTransaction()) {
            $conexion->rollBack();
        }

        return [
            "exito" => false,
            "mensaje" => $error->getMessage()
        ];
    }
}

function listarVentasAdmin() {
    global $conexion;

    $consulta = $conexion->query(
        "SELECT ventas.*, 
                usuarios.nombre AS nombreCliente,
                usuarios.email AS emailCliente
         FROM ventas
         INNER JOIN usuarios
            ON ventas.idUsuario = usuarios.idUsuario
         ORDER BY ventas.fecha DESC, ventas.idVenta DESC"
    );
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

?>