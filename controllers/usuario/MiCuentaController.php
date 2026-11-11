<?php

require_once __DIR__ . "/../../models/usuario/Usuario.php";

session_start();

if (!isset($_SESSION["idUsuario"])) {
    header("Location: /ecommerce/views/usuario/login.php");
    exit;
}

$idUsuario = $_SESSION["idUsuario"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST["accion"] ?? "";
    if ($accion == "actualizarPerfil") {
        $nombre = trim($_POST["nombre"] ?? "");
        $email = trim($_POST["email"] ?? "");
        if ($nombre == "" || $email == "") {
            header("Location: /ecommerce/views/usuario/miCuenta.php?seccion=datos&error=campos");
            exit;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: /ecommerce/views/usuario/miCuenta.php?seccion=datos&error=email");
            exit;
        }
        try {
            actualizarDatosUsuario($idUsuario, $nombre, $email, "");
            $_SESSION["nombre"] = $nombre;
            $_SESSION["email"] = $email;
            header("Location: /ecommerce/views/usuario/miCuenta.php?seccion=datos&mensaje=perfil");
            exit;

        } catch (PDOException $error) {

            if ($error->getCode() == "23000") {
                header("Location: /ecommerce/views/usuario/miCuenta.php?seccion=datos&error=emailExistente");
                exit;
            }
            header("Location: /ecommerce/views/usuario/miCuenta.php?seccion=datos&error=desconocido");
            exit;
        }
    }

    if ($accion == "cambiarContrasena") {
        $contrasenaActual = $_POST["contrasenaActual"] ?? "";
        $contrasenaNueva = $_POST["contrasenaNueva"] ?? "";
        $confirmarContrasena = $_POST["confirmarContrasena"] ?? "";
        if ($contrasenaActual == "" || $contrasenaNueva == "" || $confirmarContrasena == "") {
            header("Location: /ecommerce/views/usuario/miCuenta.php?seccion=contrasena&error=contrasenaVacia");
            exit;
        }
        $usuario = obtenerUsuarioPorId($idUsuario);
        if (!password_verify($contrasenaActual, $usuario["contrasena"])) {
            header("Location: /ecommerce/views/usuario/miCuenta.php?seccion=contrasena&error=contrasenaActual");
            exit;
        }
        if ($contrasenaNueva != $confirmarContrasena) {
            header("Location: /ecommerce/views/usuario/miCuenta.php?seccion=contrasena&error=contrasenas");
            exit;
        }
        $contrasenaHash = password_hash($contrasenaNueva, PASSWORD_DEFAULT);
        actualizarDatosUsuario(
            $idUsuario,
            $usuario["nombre"],
            $usuario["email"],
            $contrasenaHash
        );
        header("Location: /ecommerce/views/usuario/miCuenta.php?seccion=contrasena&mensaje=contrasena");
        exit;
    }
    if ($accion == "actualizarPago") {
        $metodoPago = $_POST["metodoPago"] ?? "";
        if (
            $metodoPago != "" &&
            $metodoPago != "Transferencia bancaria" &&
            $metodoPago != "Mercado Pago" &&
            $metodoPago != "Efectivo"
        ) {
            header("Location: /ecommerce/views/usuario/miCuenta.php?seccion=pago&error=desconocido");
            exit;
        }
        actualizarMetodoPago($idUsuario, $metodoPago);
        header("Location: /ecommerce/views/usuario/miCuenta.php?seccion=pago&mensaje=pago");
        exit;
    }
    if ($accion == "guardarDireccion") {
        $idDireccion = (int) ($_POST["idDireccion"] ?? 0);
        $calle = trim($_POST["calle"] ?? "");
        $numero = trim($_POST["numero"] ?? "");
        $pisoDepto = trim($_POST["pisoDepto"] ?? "");
        $localidad = trim($_POST["localidad"] ?? "");
        $provincia = trim($_POST["provincia"] ?? "");
        $codigoPostal = trim($_POST["codigoPostal"] ?? "");

        if (
            $calle == "" ||
            $numero == "" ||
            $localidad == "" ||
            $provincia == "" ||
            $codigoPostal == ""
        ) {
            header("Location: /ecommerce/views/usuario/miCuenta.php?seccion=direcciones&error=direccion");
            exit;
        }

        guardarDireccion(
            $idUsuario,
            $idDireccion,
            $calle,
            $numero,
            $pisoDepto,
            $localidad,
            $provincia,
            $codigoPostal
        );

        header("Location: /ecommerce/views/usuario/miCuenta.php?seccion=direcciones&mensaje=direccion");
        exit;
    }
    if ($accion == "eliminarDireccion") {
        $idDireccion = (int) ($_POST["idDireccion"] ?? 0);
        eliminarDireccion($idDireccion, $idUsuario);
        header("Location: /ecommerce/views/usuario/miCuenta.php?seccion=direcciones&mensaje=eliminada");
        exit;
    }
}

header("Location: /ecommerce/views/usuario/miCuenta.php?seccion=datos");
exit;

?>
