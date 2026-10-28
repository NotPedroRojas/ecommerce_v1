<?php

require_once __DIR__ . "/../models/Categoria.php";

$categoriasPadre = listarCategoriasPadre();

$categoria = null;
$productos = [];
$subcategorias = [];

if (isset($_GET["idCategoria"])) {

    $idCategoria = (int) $_GET["idCategoria"];

    if ($idCategoria > 0) {

        $categoria = obtenerCategoria($idCategoria);

        if ($categoria) {
            $productos = listarProductosPorCategoria($idCategoria);

            $subcategorias = listarSubcategorias($idCategoria);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Categorías - SpaceTech</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>

    <?php include __DIR__ . "/../includes/header.php"; ?>

    <main class="container py-5">

        <?php if (!isset($_GET["idCategoria"])) { ?>

            <h2 class="mb-4">Categorías</h2>

            <div class="row g-4">

                <?php foreach ($categoriasPadre as $categoriaPadre) { ?>

                    <div class="col-12 col-sm-6 col-lg-3">

                        <div class="card h-100 shadow-sm">

                            <div class="card-body">

                                <h5 class="card-title">
                                    <?php echo htmlspecialchars($categoriaPadre["nombre"]); ?>
                                </h5>

                                <?php
                                $subcategoriasPadre = listarSubcategorias(
                                    $categoriaPadre["idCategoria"]
                                );
                                ?>

                                <ul>
                                    <?php foreach ($subcategoriasPadre as $subcategoria) { ?>

                                        <li>
                                            <a href="categorias.php?idCategoria=<?php echo $subcategoria['idCategoria']; ?>">
                                                <?php echo htmlspecialchars($subcategoria["nombre"]); ?>
                                            </a>
                                        </li>

                                    <?php } ?>
                                </ul>

                                <a
                                    href="categorias.php?idCategoria=<?php echo $categoriaPadre['idCategoria']; ?>"
                                    class="btn btn-primary"
                                >
                                    Ver productos
                                </a>

                            </div>

                        </div>

                    </div>

                <?php } ?>

            </div>

        <?php } elseif (!$categoria) { ?>

            <div class="alert alert-warning">
                La categoría que buscás no existe.
            </div>

            <a href="categorias.php" class="btn btn-primary">
                Ver categorías
            </a>

        <?php } else { ?>

            <h2 class="mb-2">
                <?php echo htmlspecialchars($categoria["nombre"]); ?>
            </h2>

            <?php if (count($subcategorias) > 0) { ?>

                <div class="d-flex flex-wrap gap-2 my-4">

                    <?php foreach ($subcategorias as $subcategoria) { ?>

                        <a
                            href="categorias.php?idCategoria=<?php echo $subcategoria['idCategoria']; ?>"
                            class="btn btn-outline-primary"
                        >
                            <?php echo htmlspecialchars($subcategoria["nombre"]); ?>
                        </a>

                    <?php } ?>

                </div>

            <?php } ?>

            <h4 class="mt-4 mb-3">Productos</h4>

            <?php if (count($productos) == 0) { ?>

                <div class="alert alert-info">
                    Todavía no hay productos en esta categoría.
                </div>

            <?php } else { ?>

                <div class="row g-4">

                    <?php foreach ($productos as $producto) { ?>

                        <div class="col-12 col-sm-6 col-lg-3">

                            <div class="card producto-card shadow-sm">

                                <div class="producto-imagen d-flex align-items-center justify-content-center">

                                    <img
                                        src="../assets/img/productos/<?php echo htmlspecialchars($producto['foto']); ?>"
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

                                    <form action="../controllers/CarritoController.php" method="POST">

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

            <?php } ?>

        <?php } ?>

    </main>

    <?php include __DIR__ . "/../includes/footer.php"; ?>

</body>

</html>