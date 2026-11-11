
<?php

$mensaje = "";
$error = "";

if (isset($_GET["registro"])) {
    if ($_GET["registro"] == "exitoso") {
        $mensaje = "Tu cuenta se creó correctamente. Ahora podés iniciar sesión.";
    }
}

if (isset($_GET["error"])) {
    if ($_GET["error"] == "campos") {
        $error = "Completá todos los campos.";
    } elseif ($_GET["error"] == "credenciales") {
        $error = "El email o la contraseña son incorrectos.";
    } elseif ($_GET["error"] == "desconocido") {
        $error = "Ocurrió un problema al iniciar sesión.";
    } else {
        $error = "Ocurrió un error. Intentá nuevamente.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión - SpaceTech</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ecommerce/assets/style/style.css">
</head>

<body>

    <?php require_once __DIR__ . "/../../includes/header.php"; ?>

    <main>
        <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow">
                        <div class="card-body p-4">

                            <h2 class="text-center mb-4">Iniciar sesión</h2>

                            <?php if ($mensaje != "") { ?>
                                <div class="alert alert-success">
                                    <?php echo $mensaje; ?>
                                </div>
                            <?php } ?>

                            <?php if ($error != "") { ?>
                                <div class="alert alert-danger">
                                    <?php echo $error; ?>
                                </div>
                            <?php } ?>

                            <form action="/ecommerce/controllers/usuario/LoginController.php" method="POST">

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="email"
                                        name="email"
                                        required
                                    >
                                </div>

                                <div class="mb-3">
                                    <label for="contrasena" class="form-label">Contraseña</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="contrasena"
                                        name="contrasena"
                                        required
                                    >
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    Ingresar
                                </button>

                            </form>

                            <p class="text-center mt-3 mb-0">
                                ¿Todavía no tenés una cuenta?
                                <a href="/ecommerce/views/usuario/registro.php">Registrate</a>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once __DIR__ . "/../../includes/footer.php"; ?>

</body>
</html>
