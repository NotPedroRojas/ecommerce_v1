
<?php

require_once __DIR__ . "/../../controllers/catalogo/BuscarProductosController.php";


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar productos - SpaceTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ecommerce/assets/style/style.css">
</head>
<body>

<?php require_once __DIR__ . "/../../includes/header.php"; ?>



<main class="container py-5">

    <h2 class="mb-2">Resultados de búsqueda</h2>

    <?php if ($termino == "") { ?>

        <div class="alert alert-info mt-4">
            Escribí el nombre de un producto para realizar una búsqueda.
        </div>

    <?php } else { ?>

        <p class="text-secondary mb-4">
            Resultados para:
            <strong><?php echo htmlspecialchars($termino); ?></strong>
        </p>

        <?php if (count($productos) == 0) { ?>

            <div class="alert alert-warning">
                No se encontraron productos que coincidan con tu búsqueda.
            </div>

        <?php } else { ?>

            <div class="row g-4">

                <?php foreach ($productos as $producto) { ?>

                    <div class="col-12 col-sm-6 col-lg-3">

                        <div class="card producto-card shadow-sm <?php if ($producto["stock"] <= 0) { echo "producto-agotado"; } ?>">

                            <div class="producto-imagen d-flex align-items-center justify-content-center">

                                <?php if ($producto["stock"] <= 0) { ?>
                                    <span class="producto-etiqueta-sin-stock">Sin stock</span>
                                <?php } ?>

                                <a href="/ecommerce/views/catalogo/producto.php?id=<?php echo $producto['idProducto']; ?>">
                                    <img
                                        src="/ecommerce/assets/img/productos/<?php echo htmlspecialchars($producto['foto']); ?>"
                                        class="card-img-top"
                                        alt="<?php echo htmlspecialchars($producto['nombre']); ?>"
                                        style="max-height: 180px; width: 100%; object-fit: contain;"
                                    >
                                </a>

                            </div>

                            <div class="card-body d-flex flex-column">

                                <h5 class="card-title">
                                    <a
                                        href="/ecommerce/views/catalogo/producto.php?id=<?php echo $producto['idProducto']; ?>"
                                        class="text-decoration-none text-reset"
                                    >
                                        <?php echo htmlspecialchars($producto["nombre"]); ?>
                                    </a>
                                </h5>

                                <p class="card-text text-secondary">
                                    <?php echo htmlspecialchars($producto["descripcion"]); ?>
                                </p>

                                <p class="producto-precio mt-auto">
                                    $<?php echo number_format($producto["precio"], 2, ",", "."); ?>
                                </p>

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
                                        <?php if ($producto["stock"] <= 0) { ?>
                                        Sin stock
                                    <?php } else { ?>
                                        Agregar al carrito
                                    <?php } ?>
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                <?php } ?>

            </div>

        <?php } ?>

    <?php } ?>

</main>

<?php
require_once __DIR__ . "/../../includes/footer.php";
?>

</body>
</html>
