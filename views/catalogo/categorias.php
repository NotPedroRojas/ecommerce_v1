<?php
require_once __DIR__ . "/../../models/catalogo/Categoria.php";

$categoriasPadre = listarCategoriasPadre();

$categoria = null;
$categoriaPadre = null;
$productos = [];
$subcategorias = [];
if (isset($_GET["idCategoria"])) {
    $idCategoria = (int) $_GET["idCategoria"];
    if ($idCategoria > 0) {
        $categoria = obtenerCategoria($idCategoria);
        if ($categoria) {
            $productos = listarProductosPorCategoria($idCategoria);
            if ($categoria["idCategoriaPadre"] == null) {
                $categoriaPadre = $categoria;
            } else {
                $categoriaPadre = obtenerCategoria(
                    $categoria["idCategoriaPadre"]
                );

            }
            $subcategorias = listarSubcategorias(
                $categoriaPadre["idCategoria"]
            );
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
    <link rel="stylesheet" href="/ecommerce/assets/style/style.css">
</head>
<body>
    <?php include __DIR__ . "/../../includes/header.php"; ?>
    <main class="container py-5">
        <?php if (!isset($_GET["idCategoria"])) { ?>
            <h2 class="mb-4">Categorías</h2>
            <div class="row g-4">
                <?php foreach ($categoriasPadre as $categoriaPadreLista) { ?>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo htmlspecialchars($categoriaPadreLista["nombre"]); ?>
                                </h5>
                                <?php
                                $subcategoriasLista = listarSubcategorias(
                                    $categoriaPadreLista["idCategoria"]
                                );
                                ?>
                                <ul>
                                    <?php foreach ($subcategoriasLista as $subcategoriaLista) { ?>
                                        <li>
                                            <a href="/ecommerce/views/catalogo/categorias.php?idCategoria=<?php echo $subcategoriaLista['idCategoria']; ?>">
                                                <?php echo htmlspecialchars($subcategoriaLista["nombre"]); ?>
                                            </a>
                                        </li>

                                    <?php } ?>
                                </ul>
                                <a
                                    href="/ecommerce/views/catalogo/categorias.php?idCategoria=<?php echo $categoriaPadreLista['idCategoria']; ?>"
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

            <a href="/ecommerce/views/catalogo/categorias.php" class="btn btn-primary">
                Ver categorías
            </a>
        <?php } else { ?>
            <h2 class="mb-2">
                <?php echo htmlspecialchars($categoriaPadre["nombre"]); ?>
            </h2>
            <?php if (count($subcategorias) > 0) { ?>
                <div class="d-flex flex-wrap gap-2 my-4">
                    <?php foreach ($subcategorias as $subcategoria) { ?>
                        <a
                            href="/ecommerce/views/catalogo/categorias.php?idCategoria=<?php echo $subcategoria['idCategoria']; ?>"
                            class="btn <?php echo ($subcategoria['idCategoria'] == $categoria['idCategoria']) ? 'btn-primary' : 'btn-outline-primary'; ?>"
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
    <?php include __DIR__ . "/../../includes/footer.php"; ?>
</body>
</html>
