<?php

require_once "controllers/catalogo/ProductoController.php";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpaceTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main class="container py-5">

        <div class="mb-4">
            <h2>Nuestros productos</h2>
        </div>

        <div class="row g-4">
            <?php foreach ($productos as $producto): ?>
                <?php
                $sinStock = $producto["stock"] <= 0;
                $id = $producto["idProducto"];
                ?>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card producto-card shadow-sm <?php echo $sinStock ? 'producto-agotado' : ''; ?>">
                        <div class="producto-imagen d-flex align-items-center justify-content-center">
                            <?php if ($sinStock): ?>
                                <span class="producto-etiqueta-sin-stock">
                                    Sin stock
                                </span>
                            <?php endif; ?>
                            <a href="/ecommerce/views/catalogo/producto.php?id=<?php echo $id; ?>">
                                <img
                                    src="assets/img/productos/<?php echo htmlspecialchars($producto['foto']); ?>"
                                    class="card-img-top"
                                    alt="<?php echo htmlspecialchars($producto['nombre']); ?>"
                                    style="max-height: 180px; width: 100%; object-fit: contain;">
                            </a>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <a
                                    href="/ecommerce/views/catalogo/producto.php?id=<?php echo $id; ?>"
                                    class="text-decoration-none text-reset">
                                    <?php echo htmlspecialchars($producto["nombre"]); ?>
                                </a>
                            </h5>
                            <p class="card-text text-secondary">
                                <?php echo htmlspecialchars($producto["descripcion"]); ?>
                            </p>
                            <p class="producto-precio mt-auto">
                                $<?php echo number_format($producto["precio"], 2, ",", "."); ?>
                            </p>

                            <form action="controllers/carrito/CarritoController.php" method="POST">
                                <input
                                    type="hidden"
                                    name="idProducto"
                                    value="<?php echo $id; ?>">
                                <button
                                    type="submit"
                                    class="btn btn-primary w-100"
                                    <?php echo $sinStock ? 'disabled' : ''; ?>>
                                    <?php echo $sinStock ? 'Sin stock' : 'Agregar al carrito'; ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>