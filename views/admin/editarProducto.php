<?php

require_once __DIR__ . "/../../controllers/admin/EditarProductoController.php";


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar producto - SpaceTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ecommerce/assets/style/style.css">
</head>
<body>

<?php require_once __DIR__ . "/../../includes/header.php"; ?>
<main>



<div class="container mt-5 mb-5">
    <div class="mb-4">
        <h2>Editar producto</h2>
        <p class="text-secondary">
            Modificá los datos del producto seleccionado.
        </p>
    </div>
    <form action="/ecommerce/controllers/admin/EditarProductoController.php?id=<?php echo $producto["idProducto"]; ?>" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input
                type="text"
                class="form-control"
                id="nombre"
                name="nombre"
                value="<?php echo htmlspecialchars($producto["nombre"]); ?>"
                required>
        </div>
        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input
                type="text"
                class="form-control"
                id="codigo"
                name="codigo"
                value="<?php echo htmlspecialchars($producto["codigo"]); ?>"
                required>
        </div>
        <div class="mb-3">
            <label for="idCategoria" class="form-label">Categoría</label>
            <select class="form-select" id="idCategoria" name="idCategoria" required>
                <?php foreach ($categorias as $categoria) { ?>
                    <option
                        value="<?php echo $categoria["idCategoria"]; ?>"
                        <?php
                        if ($categoria["idCategoria"] == $producto["idCategoria"]) {
                            echo "selected";
                        }
                        ?>>
                        <?php echo htmlspecialchars($categoria["nombre"]); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea
                class="form-control"
                id="descripcion"
                name="descripcion"
                rows="4"
                required
            ><?php echo htmlspecialchars($producto["descripcion"]); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="costo" class="form-label">Costo</label>
            <input
                type="number"
                class="form-control"
                id="costo"
                name="costo"
                min="0"
                step="0.01"
                value="<?php echo $producto["costo"]; ?>"
                required>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input
                type="number"
                class="form-control"
                id="precio"
                name="precio"
                min="0"
                step="0.01"
                value="<?php echo $producto["precio"]; ?>"
                required>
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Nombre del archivo de la foto</label>
            <input
                type="text"
                class="form-control"
                id="foto"
                name="foto"
                value="<?php echo htmlspecialchars($producto["foto"]); ?>">
            <small class="text-secondary">
                La imagen debe estar guardada en assets/img/productos/.
            </small>
        </div>
        <div class="mb-3">
            <label for="idProveedor" class="form-label">Proveedor</label>
            <select class="form-select" id="idProveedor" name="idProveedor" required>
                <?php foreach ($proveedores as $proveedor) { ?>
                    <option
                        value="<?php echo $proveedor["idProveedor"]; ?>"
                        <?php
                        if ($proveedor["idProveedor"] == $producto["idProveedor"]) {
                            echo "selected";
                        }
                        ?>>
                        <?php echo htmlspecialchars($proveedor["nombre"]); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="stock" class="form-label">Stock</label>
            <input
                type="number"
                class="form-control"
                id="stock"
                name="stock"
                min="0"
                value="<?php echo $producto["stock"]; ?>"
                required>
        </div>
        <button type="submit" class="btn btn-primary">
            Guardar cambios
        </button>
        <a href="/ecommerce/views/admin/productos.php" class="btn btn-secondary">
            Cancelar
        </a>
    </form>
</div>
</main>

<?php
require_once __DIR__ . "/../../includes/footer.php";
?>

</body>
</html>
