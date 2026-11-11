<?php

require_once __DIR__ . "/../../models/usuario/Usuario.php";

session_start();

if (!isset($_SESSION["idUsuario"])) {
    header("Location: /ecommerce/views/usuario/login.php");
    exit;
}

$idUsuario = $_SESSION["idUsuario"];

$usuario = obtenerUsuarioPorId($idUsuario);
$direcciones = listarDireccionesUsuario($idUsuario);

$seccionCuenta = $_GET["seccion"] ?? "datos";

$seccionesPermitidas = ["datos", "direcciones", "pago", "contrasena"];

if (!in_array($seccionCuenta, $seccionesPermitidas)) {
    $seccionCuenta = "datos";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi cuenta - SpaceTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ecommerce/assets/style/style.css">
</head>
<body>

<?php require_once __DIR__ . "/../../includes/header.php"; ?>

<main class="container py-5">

    <div class="cuenta-layout">

        <aside class="cuenta-sidebar">
            <?php require __DIR__ . "/../../includes/menuCuenta.php"; ?>
        </aside>

        <section class="cuenta-contenido">

            <?php if (isset($_GET["mensaje"])) { ?>
                <div class="alert alert-success">
                    <?php
                    if ($_GET["mensaje"] == "perfil") {
                        echo "Tus datos se actualizaron correctamente.";
                    } elseif ($_GET["mensaje"] == "pago") {
                        echo "Tu método de pago se actualizó correctamente.";
                    } elseif ($_GET["mensaje"] == "direccion") {
                        echo "La dirección se guardó correctamente.";
                    } elseif ($_GET["mensaje"] == "eliminada") {
                        echo "La dirección se eliminó correctamente.";
                    } elseif ($_GET["mensaje"] == "contrasena") {
                        echo "Tu contraseña se cambió correctamente.";
                    } else {
                        echo "Los cambios se guardaron correctamente.";
                    }
                    ?>
                </div>
            <?php } ?>

            <?php if (isset($_GET["error"])) { ?>
                <div class="alert alert-danger">
                    <?php
                    if ($_GET["error"] == "campos") {
                        echo "Completá todos los campos obligatorios.";
                    } elseif ($_GET["error"] == "email") {
                        echo "Ingresá un email válido.";
                    } elseif ($_GET["error"] == "emailExistente") {
                        echo "Ese email ya está siendo utilizado por otra cuenta.";
                    } elseif ($_GET["error"] == "contrasenaActual") {
                        echo "La contraseña actual es incorrecta.";
                    } elseif ($_GET["error"] == "contrasenas") {
                        echo "Las nuevas contraseñas no coinciden.";
                    } elseif ($_GET["error"] == "contrasenaVacia") {
                        echo "Completá los tres campos de contraseña.";
                    } elseif ($_GET["error"] == "direccion") {
                        echo "Completá todos los campos obligatorios de la dirección.";
                    } else {
                        echo "Ocurrió un error. Intentá nuevamente.";
                    }
                    ?>
                </div>
            <?php } ?>


            <?php if ($seccionCuenta == "datos") { ?>

                <div class="cuenta-panel">
                    <h4 class="mb-4">Mis datos</h4>

                    <form action="/ecommerce/controllers/usuario/MiCuentaController.php" method="POST">

                        <input type="hidden" name="accion" value="actualizarPerfil">
                        <input type="hidden" name="seccion" value="datos">

                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input
                                type="text"
                                name="nombre"
                                class="form-control"
                                value="<?php echo htmlspecialchars($usuario["nombre"]); ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo electrónico</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="<?php echo htmlspecialchars($usuario["email"]); ?>"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Guardar cambios
                        </button>

                    </form>
                </div>


            <?php } elseif ($seccionCuenta == "direcciones") { ?>

                <div class="cuenta-panel">
                    <h4 class="mb-4">Mis direcciones</h4>

                    <?php if (count($direcciones) == 0) { ?>
                        <p class="text-secondary">
                            Todavía no agregaste ninguna dirección.
                        </p>
                    <?php } ?>

                    <?php foreach ($direcciones as $direccion) { ?>

                        <div class="cuenta-direccion mb-4">

                            <form action="/ecommerce/controllers/usuario/MiCuentaController.php" method="POST">

                                <input type="hidden" name="accion" value="guardarDireccion">
                                <input type="hidden" name="seccion" value="direcciones">
                                <input
                                    type="hidden"
                                    name="idDireccion"
                                    value="<?php echo $direccion["idDireccion"]; ?>"
                                >

                                <h5 class="mb-3">Dirección guardada</h5>

                                <div class="row">

                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Calle</label>
                                        <input
                                            type="text"
                                            name="calle"
                                            class="form-control"
                                            value="<?php echo htmlspecialchars($direccion["calle"]); ?>"
                                            required
                                        >
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Número</label>
                                        <input
                                            type="text"
                                            name="numero"
                                            class="form-control"
                                            value="<?php echo htmlspecialchars($direccion["numero"]); ?>"
                                            required
                                        >
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Piso / Departamento</label>
                                        <input
                                            type="text"
                                            name="pisoDepto"
                                            class="form-control"
                                            value="<?php echo htmlspecialchars($direccion["pisoDepto"] ?? ""); ?>"
                                        >
                                    </div>

                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Localidad</label>
                                        <input
                                            type="text"
                                            name="localidad"
                                            class="form-control"
                                            value="<?php echo htmlspecialchars($direccion["localidad"]); ?>"
                                            required
                                        >
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Provincia</label>
                                        <input
                                            type="text"
                                            name="provincia"
                                            class="form-control"
                                            value="<?php echo htmlspecialchars($direccion["provincia"]); ?>"
                                            required
                                        >
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Código postal</label>
                                        <input
                                            type="text"
                                            name="codigoPostal"
                                            class="form-control"
                                            value="<?php echo htmlspecialchars($direccion["codigoPostal"]); ?>"
                                            required
                                        >
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Guardar cambios
                                </button>

                            </form>

                            <form
                                action="/ecommerce/controllers/usuario/MiCuentaController.php"
                                method="POST"
                                class="mt-2"
                            >
                                <input type="hidden" name="accion" value="eliminarDireccion">
                                <input type="hidden" name="seccion" value="direcciones">
                                <input
                                    type="hidden"
                                    name="idDireccion"
                                    value="<?php echo $direccion["idDireccion"]; ?>"
                                >

                                <button type="submit" class="btn btn-outline-danger">
                                    Eliminar dirección
                                </button>
                            </form>

                        </div>

                    <?php } ?>

                    <hr class="my-4">

                    <h5 class="mb-3">Agregar una dirección nueva</h5>

                    <form action="/ecommerce/controllers/usuario/MiCuentaController.php" method="POST">

                        <input type="hidden" name="accion" value="guardarDireccion">
                        <input type="hidden" name="seccion" value="direcciones">
                        <input type="hidden" name="idDireccion" value="0">

                        <div class="row">

                            <div class="col-md-8 mb-3">
                                <label class="form-label">Calle</label>
                                <input type="text" name="calle" class="form-control" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Número</label>
                                <input type="text" name="numero" class="form-control" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Piso / Departamento</label>
                                <input type="text" name="pisoDepto" class="form-control">
                            </div>

                            <div class="col-md-8 mb-3">
                                <label class="form-label">Localidad</label>
                                <input type="text" name="localidad" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Provincia</label>
                                <input type="text" name="provincia" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Código postal</label>
                                <input type="text" name="codigoPostal" class="form-control" required>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-success">
                            Agregar dirección
                        </button>

                    </form>
                </div>


            <?php } elseif ($seccionCuenta == "pago") { ?>

                <div class="cuenta-panel">
                    <h4 class="mb-4">Método de pago</h4>

                    <form action="/ecommerce/controllers/usuario/MiCuentaController.php" method="POST">

                        <input type="hidden" name="accion" value="actualizarPago">
                        <input type="hidden" name="seccion" value="pago">

                        <div class="mb-3">
                            <label class="form-label">Método de pago preferido</label>

                            <select name="metodoPago" class="form-select">
                                <option value="">Sin seleccionar</option>

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
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Guardar método de pago
                        </button>

                    </form>
                </div>


            <?php } elseif ($seccionCuenta == "contrasena") { ?>

                <div class="cuenta-panel">
                    <h4 class="mb-4">Cambiar contraseña</h4>

                    <form action="/ecommerce/controllers/usuario/MiCuentaController.php" method="POST">

                        <input type="hidden" name="accion" value="cambiarContrasena">
                        <input type="hidden" name="seccion" value="contrasena">

                        <div class="mb-3">
                            <label class="form-label">Contraseña actual</label>
                            <input
                                type="password"
                                name="contrasenaActual"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nueva contraseña</label>
                            <input
                                type="password"
                                name="contrasenaNueva"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirmar nueva contraseña</label>
                            <input
                                type="password"
                                name="confirmarContrasena"
                                class="form-control"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Cambiar contraseña
                        </button>

                    </form>
                </div>

            <?php } ?>

        </section>

    </div>

</main>

<?php require_once __DIR__ . "/../../includes/footer.php"; ?>

</body>
</html>
