<?php

require_once __DIR__ . "/../../controllers/admin/VentasController.php";


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas - SpaceTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ecommerce/assets/style/style.css">
</head>
<body>

<?php require_once __DIR__ . "/../../includes/header.php"; ?>



<main class="container mt-5 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Ventas realizadas</h2>

        <a href="/ecommerce/views/admin/index.php"
           class="btn btn-outline-secondary">
            Volver al panel
        </a>

    </div>


    <?php if (count($ventas) == 0) { ?>

        <div class="alert alert-info">
            Todavía no se realizaron ventas.
        </div>

    <?php } else { ?>

        <p class="text-secondary mb-4">
            Cantidad de ventas: <?php echo count($ventas); ?>
        </p>

        <?php foreach ($ventas as $venta) { ?>

            <div class="card shadow-sm mb-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between flex-wrap gap-3">

                        <div>

                            <h5 class="mb-1">
                                Venta #<?php echo $venta["idVenta"]; ?>
                            </h5>

                            <p class="text-secondary mb-0">
                                <?php
                                echo date(
                                    "d/m/Y H:i",
                                    strtotime($venta["fecha"])
                                );
                                ?>
                            </p>

                        </div>

                        <div class="text-end">

                            <h5 class="text-primary mb-1">
                                $<?php echo number_format(
                                    $venta["total"],
                                    2,
                                    ",",
                                    "."
                                ); ?>
                            </h5>

                            <span class="text-secondary">
                                <?php echo htmlspecialchars($venta["metodoPago"]); ?>
                            </span>

                        </div>

                    </div>


                    <hr>


                    <h6>Datos del cliente</h6>

                    <p class="mb-1">
                        <strong>Nombre:</strong>
                        <?php echo htmlspecialchars($venta["nombreCliente"]); ?>
                    </p>

                    <p class="mb-3">
                        <strong>Email:</strong>
                        <?php echo htmlspecialchars($venta["emailCliente"]); ?>
                    </p>


                    <h6>Dirección de entrega</h6>

                    <p class="mb-3">

                        <?php echo htmlspecialchars($venta["calle"]); ?>
                        <?php echo htmlspecialchars($venta["numero"]); ?>

                        <?php if (!empty($venta["pisoDepto"])) { ?>
                            - <?php echo htmlspecialchars($venta["pisoDepto"]); ?>
                        <?php } ?>

                        <br>

                        <?php echo htmlspecialchars($venta["ciudad"]); ?>,
                        <?php echo htmlspecialchars($venta["provincia"]); ?>

                        <br>

                        Código postal:
                        <?php echo htmlspecialchars($venta["codigoPostal"]); ?>

                    </p>


                    <details>

                        <summary class="text-primary">
                            Ver productos comprados
                        </summary>

                        <div class="table-responsive mt-3">

                            <table class="table table-bordered align-middle">

                                <thead class="table-light">

                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio unitario</th>
                                        <th>Subtotal</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <?php foreach ($itemsPorVenta[$venta["idVenta"]] as $item) { ?>

                                        <tr>

                                            <td>
                                                <?php echo htmlspecialchars($item["nombreProducto"]); ?>
                                            </td>

                                            <td>
                                                <?php echo $item["cantidad"]; ?>
                                            </td>

                                            <td>
                                                $<?php echo number_format(
                                                    $item["precioUnitario"],
                                                    2,
                                                    ",",
                                                    "."
                                                ); ?>
                                            </td>

                                            <td>
                                                $<?php echo number_format(
                                                    $item["subtotal"],
                                                    2,
                                                    ",",
                                                    "."
                                                ); ?>
                                            </td>

                                        </tr>

                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>

                    </details>

                </div>

            </div>

        <?php } ?>

    <?php } ?>

</main>

<?php
require_once __DIR__ . "/../../includes/footer.php";
?>

</body>
</html>
