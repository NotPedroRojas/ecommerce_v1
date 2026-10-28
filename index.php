
<?php
require_once "controllers/ProductoController.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tienda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <main class="container py-5">

        <div class="mb-4">
            <h2>Nuestros productos</h2>
            <p class="text-secondary">Descubrí algunos de los productos que tenemos para vos.</p>
        </div>

        <div class="row g-4">

            <?php foreach ($productos as $producto) { ?>

                <div class="col-12 col-sm-6 col-lg-3">

                    <div class="card producto-card shadow-sm">

                        <div class="producto-imagen d-flex align-items-center justify-content-center">

                            <img
                                src="assets/img/productos/<?php echo htmlspecialchars($producto['foto']); ?>"
                                class="card-img-top"
                                alt="<?php echo htmlspecialchars($producto['nombre']); ?>"
                                style="max-height: 180px; width: 100%; object-fit: contain;"
                            >

                        </div>

                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title">
                                <?php echo htmlspecialchars($producto["nombre"]); ?>
                            </h5>

                            <p class="card-text text-secondary">
                                <?php echo htmlspecialchars($producto["descripcion"]); ?>
                            </p>

                            <p class="producto-precio mt-auto">
                                $<?php echo number_format($producto["precio"], 2, ",", "."); ?>
                            </p>

                            <form action="controllers/CarritoController.php" method="POST">
                                <input
                                    type="hidden"
                                    name="idProducto"
                                    value="<?php echo $producto['idProducto']; ?>"
                                >

                                <button type="submit" class="btn btn-primary w-100">
                                    Agregar al carrito
                                </button>
                            </form>

                        </div>

                    </div>

                </div>

            <?php } ?>

        </div>

    </main>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
