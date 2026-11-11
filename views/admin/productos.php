<?php

require_once __DIR__ . "/../../controllers/admin/ProductosController.php";


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - SpaceTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ecommerce/assets/style/style.css">
</head>
<body>

<?php require_once __DIR__ . "/../../includes/header.php"; ?>
<main>



<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Administrar productos</h2>
        </div>
        <div>
            <a href="/ecommerce/views/admin/agregarProducto.php" class="btn btn-primary">
                Agregar producto
            </a>
            <a href="/ecommerce/views/admin/index.php" class="btn btn-secondary">
                Volver al panel
            </a>
        </div> 
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th style="width: 100px; min-width: 100px;">Foto</th>
                    <th>Nombre</th>
                    <th>Código</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto) { ?>
                    <tr>
                        <td>
                            <?php echo $producto["idProducto"]; ?>
                        </td>
                        <td class="text-center" style="width: 100px; min-width: 100px;">
                            <?php if (!empty($producto["foto"])) { ?>
                                <img
                                    src="/ecommerce/assets/img/productos/<?php echo htmlspecialchars($producto["foto"]); ?>"
                                    alt="<?php echo htmlspecialchars($producto["nombre"]); ?>"
                                    style="width: 70px; height: 70px; object-fit: contain; display: block; margin: auto;"
                                >
                            <?php } else { ?>
                                <span class="text-secondary">
                                    Sin foto
                                </span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($producto["nombre"]); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($producto["codigo"]); ?>
                        </td>
                        <td>
                            $<?php echo number_format($producto["precio"], 2, ",", "."); ?>
                        </td>
                        <td>
                            <?php echo $producto["stock"]; ?>
                        </td>
                        <td>
                            <a href="/ecommerce/views/admin/editarProducto.php?id=<?php echo $producto["idProducto"]; ?>" class="btn btn-warning btn-sm">
                            Editar
                            </a>
                            <form
                                action="/ecommerce/controllers/admin/EliminarProductoController.php"
                                method="POST"
                                style="display: inline;"
                                onsubmit="return confirm('¿Estás seguro de que querés eliminar este producto?');">
                                <input
                                    type="hidden"
                                    name="idProducto"
                                    value="<?php echo $producto["idProducto"]; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</main>

<?php
require_once __DIR__ . "/../../includes/footer.php";
?>

</body>
</html>
