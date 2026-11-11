<?php

require_once __DIR__ . "/../../models/carrito/Carrito.php";
require_once __DIR__ . "/../../models/usuario/Usuario.php";

session_start();

if (!isset($_SESSION["idUsuario"])) {
    header("Location: /ecommerce/views/usuario/login.php");
    exit;
}

$idUsuario = $_SESSION["idUsuario"];

$direcciones = listarDireccionesUsuario($idUsuario);
$usuario = obtenerUsuarioPorId($idUsuario);

$idCarrito = obtenerOCrearCarrito();

$consulta = $conexion->prepare(
    "SELECT productos.idProducto, productos.nombre,
            productos.foto, productos.precio,
            productos.stock, items_carrito.cantidad,
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
    <title>Finalizar compra - SpaceTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ecommerce/assets/style/style.css">
</head>
<body>

<?php require_once __DIR__ . "/../../includes/header.php"; ?>



<main class="container py-5">

    <h2 class="mb-4">Finalizar compra</h2>

    <?php if (isset($_GET["error"])) { ?>

        <div class="alert alert-danger">
            <?php
            if ($_GET["error"] == "direccion") {
                echo "Seleccioná una dirección válida.";
            } elseif ($_GET["error"] == "pago") {
                echo "Seleccioná un método de pago válido.";
            } else {
                echo "No se pudo completar la compra. Revisá el carrito y el stock disponible.";
            }
            ?>
        </div>

    <?php } ?>


    <?php if (count($productos) == 0) { ?>

        <div class="alert alert-info">
            Tu carrito está vacío.
        </div>

        <a href="/ecommerce/index.php" class="btn btn-primary">
            Seguir comprando
        </a>

    <?php } elseif (count($direcciones) == 0) { ?>

        <div class="alert alert-warning">
            Primero tenés que agregar una dirección desde Mi cuenta.
        </div>

        <a href="/ecommerce/views/usuario/miCuenta.php" class="btn btn-primary">
            Ir a Mi cuenta
        </a>

    <?php } else { ?>

        <form
            action="/ecommerce/controllers/carrito/FinalizarCompraController.php"
            method="POST"
        >

            <div class="card shadow-sm mb-4">

                <div class="card-body p-4">

                    <h4 class="mb-3">1. Productos</h4>

                    <?php foreach ($productos as $producto) { ?>

                        <?php
                        $total = $total + $producto["subtotal"];
                        ?>

                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">

                            <div class="d-flex align-items-center gap-3">

                                <img
                                    src="/ecommerce/assets/img/productos/<?php echo htmlspecialchars($producto["foto"]); ?>"
                                    alt="<?php echo htmlspecialchars($producto["nombre"]); ?>"
                                    style="width: 65px; height: 65px; object-fit: contain;"
                                >

                                <div>
                                    <strong>
                                        <?php echo htmlspecialchars($producto["nombre"]); ?>
                                    </strong>

                                    <p class="text-secondary mb-0">
                                        Cantidad: <?php echo $producto["cantidad"]; ?>
                                    </p>

                                    <?php if ($producto["cantidad"] > $producto["stock"]) { ?>
                                        <p class="text-danger mb-0">
                                            Stock insuficiente.
                                        </p>
                                    <?php } ?>
                                </div>

                            </div>

                            <strong>
                                $<?php echo number_format($producto["subtotal"], 2, ",", "."); ?>
                            </strong>

                        </div>

                    <?php } ?>

                    <h4 class="text-end mt-4">
                        Total: $<?php echo number_format($total, 2, ",", "."); ?>
                    </h4>

                </div>

            </div>


            <div class="card shadow-sm mb-4">

                <div class="card-body p-4">

                    <h4 class="mb-3">2. Dirección de entrega</h4>

                    <?php foreach ($direcciones as $direccion) { ?>

                        <div class="form-check border rounded p-3 ps-5 mb-3">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="idDireccion"
                                value="<?php echo $direccion["idDireccion"]; ?>"
                                required
                            >

                            <label class="form-check-label">

                                <strong>
                                    <?php echo htmlspecialchars($direccion["calle"]); ?>
                                    <?php echo htmlspecialchars($direccion["numero"]); ?>
                                </strong>

                                <br>

                                <?php if ($direccion["pisoDepto"] != "") { ?>
                                    Piso / Departamento:
                                    <?php echo htmlspecialchars($direccion["pisoDepto"]); ?>
                                    <br>
                                <?php } ?>

                                <?php echo htmlspecialchars($direccion["localidad"]); ?>,
                                <?php echo htmlspecialchars($direccion["provincia"]); ?>

                                <br>

                                Código postal:
                                <?php echo htmlspecialchars($direccion["codigoPostal"]); ?>

                            </label>

                        </div>

                    <?php } ?>

                    <a href="/ecommerce/views/usuario/miCuenta.php">
                        Administrar mis direcciones
                    </a>

                </div>

            </div>


            <div class="card shadow-sm mb-4">

                <div class="card-body p-4">

                    <h4 class="mb-3">3. Método de pago</h4>

                    <select name="metodoPago" class="form-select" required>

                        <option value="">Seleccionar método de pago</option>

                        <option value="Transferencia bancaria"
                            <?php if ($usuario["metodoPago"] == "Transferencia bancaria") { echo "selected"; } ?>>
                            Transferencia bancaria
                        </option>

                        <option value="Mercado Pago"
                            <?php if ($usuario["metodoPago"] == "Mercado Pago") { echo "selected"; } ?>>
                            Mercado Pago
                        </option>

                        <option value="Efectivo"
                            <?php if ($usuario["metodoPago"] == "Efectivo") { echo "selected"; } ?>>
                            Efectivo
                        </option>

                    </select>

                    <p class="text-secondary small mt-2 mb-0">
                        Por ahora, la selección es únicamente informativa.
                        Todavía no se procesa ningún pago real.
                    </p>

                </div>

            </div>


            <div class="text-end">

                <a href="/ecommerce/views/carrito/index.php"
                   class="btn btn-outline-secondary">
                    Volver al carrito
                </a>

                <button type="submit" class="btn btn-primary">
                    Confirmar compra
                </button>

            </div>

        </form>

    <?php } ?>

</main>

<?php
require_once __DIR__ . "/../../includes/footer.php";
?>

</body>
</html>
