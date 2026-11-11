<?php

require_once __DIR__ . "/../../includes/verificarAdmin.php";
require_once __DIR__ . "/../../models/catalogo/Producto.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["idProducto"])) {
        $idProducto = $_POST["idProducto"];
        eliminarProducto($idProducto);
    }
}

header("Location: /ecommerce/views/admin/productos.php");
exit;

?>