
<?php

require_once __DIR__ . "/../models/Carrito.php";

if (isset($_POST["idProducto"])) {
    agregarProducto($_POST["idProducto"]);
}

header("Location: ../index.php");
exit;

?>
