<?php

require_once __DIR__ . "/../../models/ventas/Venta.php";

session_start();

if (!isset($_SESSION["idUsuario"])) {
    header("Location: /ecommerce/views/usuario/login.php");
    exit;
}

$idUsuario = $_SESSION["idUsuario"];
$ventas = listarVentasUsuario($idUsuario);

$seccionCuenta = "pedidos";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis pedidos - SpaceTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ecommerce/assets/style/style.css">
</head>
<body>

<?php require_once __DIR__ . "/../../includes/header.php"; ?>

<main class="container py-5">

    <div class="cuenta-layout">

        <aside class="cuenta-sidebar">
            <?php require __DIR__ . "/../../includes/menuCuenta.php"; ?>
        </aside>

        <section class="cuenta-contenido">

            <h4 class="mb-4">Mis pedidos</h4>

            <?php if (isset($_GET["compra"])) { ?>
                <div class="alert alert-success">
                    ¡Tu pedido se realizó correctamente!
                    Número de pedido: #<?php echo (int) $_GET["compra"]; ?>
                </div>
            <?php } ?>

            <?php if (count($ventas) == 0) { ?>

                <div class="alert alert-info">
                    Todavía no realizaste ningún pedido.
                </div>

                <a href="/ecommerce/index.php" class="btn btn-primary">
                    Explorar productos
                </a>

            <?php } else { ?>

                <?php foreach ($ventas as $venta) { ?>

                    <div class="card shadow-sm mb-4">

                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between flex-wrap gap-3">

                                <div>
                                    <h5>Pedido #<?php echo $venta["idVenta"]; ?></h5>

                                    <p class="text-secondary mb-1">
                                        Fecha:
                                        <?php echo date("d/m/Y H:i", strtotime($venta["fecha"])); ?>
                                    </p>

                                    <p class="text-secondary mb-1">
                                        Método de pago:
                                        <?php echo htmlspecialchars($venta["metodoPago"]); ?>
                                    </p>
                                </div>

                                <div class="text-end">
                                    <h5>
                                        $<?php echo number_format($venta["total"], 2, ",", "."); ?>
                                    </h5>
                                </div>

                            </div>

                            <hr>

                            <details>
                                <summary class="text-primary">
                                    Ver detalles del pedido
                                </summary>

                                <?php
                                $itemsVenta = obtenerItemsVenta($venta["idVenta"]);
                                ?>

                                <div class="table-responsive mt-3">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Precio unitario</th>
                                                <th>Cantidad</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach ($itemsVenta as $item) { ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($item["nombreProducto"]); ?></td>
                                                    <td>$<?php echo number_format($item["precioUnitario"], 2, ",", "."); ?></td>
                                                    <td><?php echo $item["cantidad"]; ?></td>
                                                    <td>$<?php echo number_format($item["subtotal"], 2, ",", "."); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <h6 class="mt-3">Dirección de entrega</h6>

                                <p class="text-secondary mb-0">
                                    <?php echo htmlspecialchars($venta["calle"]); ?>
                                    <?php echo htmlspecialchars($venta["numero"]); ?>

                                    <?php if (!empty($venta["pisoDepto"])) { ?>
                                        Piso / Departamento:
                                        <?php echo htmlspecialchars($venta["pisoDepto"]); ?>.
                                    <?php } ?>,

                                    <?php echo htmlspecialchars($venta["ciudad"]); ?>,
                                    <?php echo htmlspecialchars($venta["provincia"]); ?>.

                                    Código postal:
                                    <?php echo htmlspecialchars($venta["codigoPostal"]); ?>
                                </p>

                            </details>

                        </div>

                    </div>

                <?php } ?>

            <?php } ?>

        </section>

    </div>

</main>

<?php require_once __DIR__ . "/../../includes/footer.php"; ?>

</body>
</html>
