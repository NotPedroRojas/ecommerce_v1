<?php

require_once __DIR__ . "/../../models/catalogo/Producto.php";

$termino = "";

$productos = [];

if (isset($_GET["q"])) {

    $termino = trim($_GET["q"]);

    if ($termino != "") {
        $productos = buscarProductos($termino);
    }

}

?>