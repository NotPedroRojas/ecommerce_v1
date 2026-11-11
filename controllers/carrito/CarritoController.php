<?php

require_once __DIR__ . "/../../models/carrito/Carrito.php";

if (isset($_POST["idProducto"])) {
    agregarProducto($_POST["idProducto"]);
}

header("Location: /ecommerce/index.php");
exit;

?>
