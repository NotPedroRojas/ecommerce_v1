<?php

require_once __DIR__ . "/../../includes/verificarAdmin.php";
require_once __DIR__ . "/../../models/catalogo/Producto.php";

if (!isset($_GET["id"])) {
    header("Location: /ecommerce/views/admin/productos.php");
    exit;
}

$idProducto = $_GET["id"];

$producto = obtenerProductoPorId($idProducto);

if (!$producto) {
    header("Location: /ecommerce/views/admin/productos.php");
    exit;
}

$categorias = listarCategorias();
$proveedores = listarProveedores();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $productoActualizado = [
        "idProducto" => $idProducto,
        "nombre" => $_POST["nombre"],
        "codigo" => $_POST["codigo"],
        "idCategoria" => $_POST["idCategoria"],
        "descripcion" => $_POST["descripcion"],
        "costo" => $_POST["costo"],
        "precio" => $_POST["precio"],
        "foto" => $_POST["foto"],
        "idProveedor" => $_POST["idProveedor"],
        "stock" => $_POST["stock"]
    ];

    actualizarProducto($productoActualizado);

    header("Location: /ecommerce/views/admin/productos.php");
    exit;
}
?>