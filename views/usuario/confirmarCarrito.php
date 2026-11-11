
<?php

session_start();

if (!isset($_SESSION["usuarioPendiente"])) {
    header("Location: /ecommerce/views/usuario/login.php");
    exit;
}



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar carrito - SpaceTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ecommerce/assets/style/style.css">
</head>
<body>

<?php require_once __DIR__ . "/../../includes/header.php"; ?>
<main>




<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <div class="card shadow">
                <div class="card-body p-4">

                    <h2 class="text-center mb-3">¿Qué hacemos con tu carrito?</h2>

                    <p class="text-center">
                        Encontramos productos en tu carrito de invitado
                        y también en el carrito de tu cuenta.
                    </p>

                    <form action="/ecommerce/controllers/usuario/ConfirmarCarritoController.php" method="POST">

                        <button
                            type="submit"
                            name="opcion"
                            value="conservar"
                            class="btn btn-primary w-100 mb-3"
                        >
                            Conservar ambos carritos
                        </button>

                        <p class="text-muted text-center">
                            Se combinarán los productos y se sumarán
                            las cantidades de los productos repetidos.
                        </p>

                        <button
                            type="submit"
                            name="opcion"
                            value="reemplazar"
                            class="btn btn-outline-danger w-100 mb-3"
                        >
                            Reemplazar mi carrito
                        </button>

                        <p class="text-muted text-center">
                            Se eliminarán los productos anteriores
                            de tu cuenta y se conservarán los del invitado.
                        </p>

                        <button
                            type="submit"
                            name="opcion"
                            value="cancelar"
                            class="btn btn-secondary w-100"
                        >
                            Cancelar inicio de sesión
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</main>

<?php
require_once __DIR__ . "/../../includes/footer.php";
?>

</body>
</html>
