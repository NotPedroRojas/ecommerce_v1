
<?php

require_once __DIR__ . "/../models/Carrito.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["idProducto"]) && isset($_POST["accion"])) {

        $idProducto = (int) $_POST["idProducto"];
        $accion = $_POST["accion"];

        if ($accion == "aumentar") {
            modificarCantidad($idProducto, 1);
        }

        if ($accion == "disminuir") {
            modificarCantidad($idProducto, -1);
        }

        if ($accion == "eliminar") {
            eliminarProducto($idProducto);
        }
    }
}

header("Location: ../views/carrito.php");
exit;

?>
