
<?php

require_once __DIR__ . "/../../models/usuario/Usuario.php";

session_start();

if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_SESSION["usuarioPendiente"]) &&
    isset($_SESSION["idCarritoInvitadoPendiente"]) &&
    isset($_SESSION["idCarritoUsuarioPendiente"])
) {

    $opcion = $_POST["opcion"];

    if ($opcion == "cancelar") {

        unset($_SESSION["usuarioPendiente"]);
        unset($_SESSION["idCarritoInvitadoPendiente"]);
        unset($_SESSION["idCarritoUsuarioPendiente"]);

        header("Location: /ecommerce/views/usuario/login.php");
        exit;
    }

    if ($opcion != "conservar" && $opcion != "reemplazar") {
        header("Location: /ecommerce/views/usuario/login.php");
        exit;
    }

    $idCarritoInvitado = $_SESSION["idCarritoInvitadoPendiente"];
    $idCarritoUsuario = $_SESSION["idCarritoUsuarioPendiente"];
    $usuario = $_SESSION["usuarioPendiente"];

    try {

        $conexion->beginTransaction();

        $consulta = $conexion->prepare(
            "SELECT idProducto, cantidad
             FROM items_carrito
             WHERE idCarrito = ?"
        );
        $consulta->execute([$idCarritoInvitado]);
        $productosInvitado = $consulta->fetchAll(PDO::FETCH_ASSOC);

        if ($opcion == "reemplazar") {

            $consulta = $conexion->prepare(
                "DELETE FROM items_carrito WHERE idCarrito = ?"
            );
            $consulta->execute([$idCarritoUsuario]);
        }

        foreach ($productosInvitado as $producto) {

            if ($opcion == "conservar") {

                $consulta = $conexion->prepare(
                    "SELECT idItemCarrito, cantidad
                     FROM items_carrito
                     WHERE idCarrito = ? AND idProducto = ?"
                );
                $consulta->execute([
                    $idCarritoUsuario,
                    $producto["idProducto"]
                ]);

                $itemExistente = $consulta->fetch(PDO::FETCH_ASSOC);

            } else {
                $itemExistente = false;
            }

            if ($itemExistente) {

                $nuevaCantidad = $itemExistente["cantidad"] + $producto["cantidad"];

                $consulta = $conexion->prepare(
                    "UPDATE items_carrito
                     SET cantidad = ?
                     WHERE idItemCarrito = ?"
                );
                $consulta->execute([
                    $nuevaCantidad,
                    $itemExistente["idItemCarrito"]
                ]);

            } else {

                $consulta = $conexion->prepare(
                    "INSERT INTO items_carrito (idCarrito, idProducto, cantidad)
                     VALUES (?, ?, ?)"
                );
                $consulta->execute([
                    $idCarritoUsuario,
                    $producto["idProducto"],
                    $producto["cantidad"]
                ]);
            }
        }

        $consulta = $conexion->prepare(
            "DELETE FROM carritos WHERE idCarrito = ?"
        );
        $consulta->execute([$idCarritoInvitado]);

        $conexion->commit();

        unset($_SESSION["usuarioPendiente"]);
        unset($_SESSION["idCarritoInvitadoPendiente"]);
        unset($_SESSION["idCarritoUsuarioPendiente"]);

        session_regenerate_id(true);

        $_SESSION["idUsuario"] = $usuario["idUsuario"];
        $_SESSION["nombre"] = $usuario["nombre"];
        $_SESSION["email"] = $usuario["email"];
        $_SESSION["tipoUsuario"] = $usuario["tipoUsuario"];

        header("Location: /ecommerce/index.php");
        exit;

    } catch (PDOException $error) {

        if ($conexion->inTransaction()) {
            $conexion->rollBack();
        }

        header("Location: /ecommerce/views/usuario/login.php?error=desconocido");
        exit;
    }
}

header("Location: /ecommerce/views/usuario/login.php");
exit;

?>
