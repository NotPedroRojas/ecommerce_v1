<?php

require_once __DIR__ . "/../../includes/verificarAdmin.php";
require_once __DIR__ . "/../../models/ventas/Venta.php";

$ventas = listarVentasAdmin();

$itemsPorVenta = [];

foreach ($ventas as $venta) {
    $idVenta = $venta["idVenta"];
    $itemsPorVenta[$idVenta] = obtenerItemsVenta($idVenta);
}

?>