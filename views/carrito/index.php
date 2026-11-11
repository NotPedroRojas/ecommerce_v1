<?php
require_once __DIR__ . "/../../models/carrito/Carrito.php";
$idCarrito = obtenerOCrearCarrito();
$consulta = $conexion->prepare(
    "SELECT productos.idProducto, productos.nombre, productos.foto,
            productos.precio, items_carrito.cantidad,
            (productos.precio * items_carrito.cantidad) AS subtotal
     FROM items_carrito
     INNER JOIN productos
     ON items_carrito.idProducto = productos.idProducto
     WHERE items_carrito.idCarrito = ?"
);

$consulta->execute([$idCarrito]);
$productos = $consulta->fetchAll(PDO::FETCH_ASSOC);
$total = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi carrito - SpaceTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ecommerce/assets/style/style.css">
</head>
<body>
    <?php include __DIR__ . "/../../includes/header.php"; ?>
    <main class="container py-5">
        <h2 class="mb-4">Mi carrito</h2>
        <?php if (count($productos) == 0) { ?>
            <div class="alert alert-info">
                Tu carrito está vacío.
            </div>
            <a href="/ecommerce/index.php" class="btn btn-primary">
                Seguir comprando
            </a>
        <?php } else { ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto) { ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img
                                            src="/ecommerce/assets/img/productos/<?php echo htmlspecialchars($producto['foto']); ?>"
                                            alt="<?php echo htmlspecialchars($producto['nombre']); ?>"
                                            style="width: 70px; height: 70px; object-fit: contain;"
                                        >
                                        <?php echo htmlspecialchars($producto["nombre"]); ?>
                                    </div>
                                </td>
                                <td>
                                    $<?php echo number_format($producto["precio"], 2, ",", "."); ?>
                                </td>
                                <td>
                                    <form
                                        action="/ecommerce/controllers/carrito/ModificarCarritoController.php"
                                        method="POST"
                                        class="d-flex align-items-center gap-2"
                                    >
                                        <input
                                            type="hidden"
                                            name="idProducto"
                                            value="<?php echo $producto['idProducto']; ?>"
                                        >
                                        <button
                                            type="submit"
                                            name="accion"
                                            value="disminuir"
                                            class="btn btn-outline-secondary btn-sm"
                                        >
                                        </button>
                                        <span>
                                            <?php echo $producto["cantidad"]; ?>
                                        </span>
                                        <button
                                            type="submit"
                                            name="accion"
                                            value="aumentar"
                                            class="btn btn-outline-secondary btn-sm"
                                        >
                                            +
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    $<?php echo number_format($producto["subtotal"], 2, ",", "."); ?>
                                </td>
                                <td>
                                    <form
                                        action="/ecommerce/controllers/carrito/ModificarCarritoController.php"
                                        method="POST"
                                    >
                                        <input
                                            type="hidden"
                                            name="idProducto"
                                            value="<?php echo $producto['idProducto']; ?>"
                                        >
                                        <button
                                            type="submit"
                                            name="accion"
                                            value="eliminar"
                                            class="btn btn-outline-danger btn-sm"
                                        >
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php $total = $total + $producto["subtotal"]; ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="text-end">
                <h4 class="mb-3">
                    Total: $<?php echo number_format($total, 2, ",", "."); ?>
                </h4>
                <a href="/ecommerce/index.php" class="btn btn-outline-secondary">
                    Seguir comprando
                </a>

                <a href="/ecommerce/views/carrito/checkout.php"
                class="btn btn-primary">
                    Finalizar compra
                </a>
            </div>
        <?php } ?>
    </main>
    <?php include __DIR__ . "/../../includes/footer.php"; ?>
</body>
</html>