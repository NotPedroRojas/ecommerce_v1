
<?php

require_once __DIR__ . "/../../controllers/catalogo/DetalleProductoController.php";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto - SpaceTech</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ecommerce/assets/style/style.css">
</head>
<body>

<?php require_once __DIR__ . "/../../includes/header.php"; ?>

<main class="container py-5">

    <?php if (!$producto) { ?>

        <div class="alert alert-warning">
            El producto que buscás no existe.
        </div>

        <a href="/ecommerce/index.php" class="btn btn-primary">
            Volver al inicio
        </a>

    <?php } else { ?>

        <div class="row g-5">

            <div class="col-12 col-md-6">
                <div class="d-flex align-items-center justify-content-center"
                    style="background: #202923; border-radius: 15px; padding: 30px; min-height: 450px;">

                    <img
                        src="/ecommerce/assets/img/productos/<?php echo htmlspecialchars($producto['foto']); ?>"
                        alt="<?php echo htmlspecialchars($producto['nombre']); ?>"
                        style="width: 100%; max-width: 400px; max-height: 400px; object-fit: contain;"
                    >

                </div>
            </div>

            <div class="col-12 col-md-6">

                <h2>
                    <?php echo htmlspecialchars($producto["nombre"]); ?>
                </h2>

                <h3 class="producto-precio my-4">
                    $<?php echo number_format($producto["precio"], 2, ",", "."); ?>
                </h3>

                <?php if ($producto["stock"] > 0) { ?>

                    <p class="text-success">
                        Disponible - <?php echo $producto["stock"]; ?> unidades
                    </p>

                <?php } else { ?>

                    <p class="text-danger">
                        Sin stock
                    </p>

                <?php } ?>

                <form action="/ecommerce/controllers/carrito/CarritoController.php" method="POST">

                    <input
                        type="hidden"
                        name="idProducto"
                        value="<?php echo $producto['idProducto']; ?>"
                    >

                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                        <?php if ($producto["stock"] <= 0) { echo "disabled"; } ?>
                    >
                        Agregar al carrito
                    </button>

                </form>

            </div>

        </div>

        <hr class="my-5">

        <h3>Descripción del producto</h3>

        <p>
            <?php echo nl2br(htmlspecialchars($producto["descripcion"])); ?>
        </p>

        <a href="/ecommerce/index.php" class="btn btn-outline-secondary mt-3">
            Volver al catálogo
        </a>

    <?php } ?>

</main>

<?php require_once __DIR__ . "/../../includes/footer.php"; ?>

</body>
</html>
