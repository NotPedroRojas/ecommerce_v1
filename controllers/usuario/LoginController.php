
<?php

require_once __DIR__ . "/../../models/usuario/Usuario.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $contrasena = $_POST["contrasena"];

    if ($email == "" || $contrasena == "") {
        header("Location: /ecommerce/views/usuario/login.php?error=campos");
        exit;
    }

    try {

        $usuario = obtenerUsuarioPorEmail($email);

        if ($usuario != false && password_verify($contrasena, $usuario["contrasena"])) {

            $identificador = session_id();

            $consulta = $conexion->prepare(
                "SELECT idCarrito FROM carritos
                 WHERE identificadorSesion = ? AND idUsuario IS NULL"
            );
            $consulta->execute([$identificador]);
            $carritoInvitado = $consulta->fetch(PDO::FETCH_ASSOC);

            $consulta = $conexion->prepare(
                "SELECT idCarrito FROM carritos WHERE idUsuario = ?"
            );
            $consulta->execute([$usuario["idUsuario"]]);
            $carritoUsuario = $consulta->fetch(PDO::FETCH_ASSOC);

            $cantidadInvitado = 0;
            $cantidadUsuario = 0;

            if ($carritoInvitado) {
                $consulta = $conexion->prepare(
                    "SELECT COUNT(*) FROM items_carrito WHERE idCarrito = ?"
                );
                $consulta->execute([$carritoInvitado["idCarrito"]]);
                $cantidadInvitado = $consulta->fetchColumn();
            }

            if ($carritoUsuario) {
                $consulta = $conexion->prepare(
                    "SELECT COUNT(*) FROM items_carrito WHERE idCarrito = ?"
                );
                $consulta->execute([$carritoUsuario["idCarrito"]]);
                $cantidadUsuario = $consulta->fetchColumn();
            }

            if ($cantidadInvitado > 0 && $cantidadUsuario > 0) {

                $_SESSION["usuarioPendiente"] = [
                    "idUsuario" => $usuario["idUsuario"],
                    "nombre" => $usuario["nombre"],
                    "email" => $usuario["email"],
                    "tipoUsuario" => $usuario["tipoUsuario"]
                ];

                $_SESSION["idCarritoInvitadoPendiente"] = $carritoInvitado["idCarrito"];
                $_SESSION["idCarritoUsuarioPendiente"] = $carritoUsuario["idCarrito"];

                header("Location: /ecommerce/views/usuario/confirmarCarrito.php");
                exit;
            }

            if ($cantidadInvitado > 0) {
                if ($carritoUsuario) {
                    $consulta = $conexion->prepare(
                        "DELETE FROM carritos WHERE idCarrito = ?"
                    );
                    $consulta->execute([$carritoUsuario["idCarrito"]]);
                }

                $consulta = $conexion->prepare(
                    "UPDATE carritos
                     SET idUsuario = ?, identificadorSesion = NULL
                     WHERE idCarrito = ?"
                );
                $consulta->execute([
                    $usuario["idUsuario"],
                    $carritoInvitado["idCarrito"]
                ]);

            } elseif ($carritoInvitado) {
                $consulta = $conexion->prepare(
                    "DELETE FROM carritos WHERE idCarrito = ?"
                );
                $consulta->execute([$carritoInvitado["idCarrito"]]);
            }

            session_regenerate_id(true);

            $_SESSION["idUsuario"] = $usuario["idUsuario"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["email"] = $usuario["email"];
            $_SESSION["tipoUsuario"] = $usuario["tipoUsuario"];

            header("Location: /ecommerce/index.php");
            exit;

        } else {

            header("Location: /ecommerce/views/usuario/login.php?error=credenciales");
            exit;
        }

    } catch (PDOException $error) {

        header("Location: /ecommerce/views/usuario/login.php?error=desconocido");
        exit;
    }
}

header("Location: /ecommerce/views/usuario/login.php");
exit;

?>
