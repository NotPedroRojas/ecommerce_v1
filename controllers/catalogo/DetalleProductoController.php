<?php
require_once __DIR__ . "/../../models/catalogo/Producto.php";

$idProducto = 0;
if (isset($_GET["id"])) {
    $idProducto = (int) $_GET["id"];
}
$producto = null;
if ($idProducto > 0) {
    $producto = obtenerProductoPorId($idProducto);
}

?>
