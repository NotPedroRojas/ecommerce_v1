<?php

require_once __DIR__ . "/../../models/ventas/Venta.php";

session_start();

if (!isset($_SESSION["idUsuario"])) {
    header("Location: /ecommerce/views/usuario/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idUsuario = $_SESSION["idUsuario"];
    $idDireccion = (int) $_POST["idDireccion"];
    $metodoPago = $_POST["metodoPago"];

    if ($idDireccion <= 0) {
        header("Location: /ecommerce/views/carrito/checkout.php?error=direccion");
        exit;
    }

    if (
        $metodoPago != "Transferencia bancaria" &&
        $metodoPago != "Mercado Pago" &&
        $metodoPago != "Efectivo"
    ) {
        header("Location: /ecommerce/views/carrito/checkout.php?error=pago");
        exit;
    }
    $resultado = registrarCompra(
        $idUsuario,
        $idDireccion,
        $metodoPago
    );

    if ($resultado["exito"]) {
        header(
            "Location: /ecommerce/views/usuario/historialCompras.php?compra=" .
            $resultado["idVenta"]
        );
        exit;
    } else {
        header(
            "Location: /ecommerce/views/carrito/checkout.php?error=compra"
        );
        exit;
    }
}

header("Location: /ecommerce/views/carrito/index.php");
exit;

?>