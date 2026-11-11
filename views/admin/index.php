<?php

require_once __DIR__ . "/../../includes/verificarAdmin.php";


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración - SpaceTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ecommerce/assets/style/style.css">
</head>
<body>

<?php require_once __DIR__ . "/../../includes/header.php"; ?>
<main>

<div class="container mt-5 mb-5">

    <h2 class="mb-4">Panel de administración</h2>

    <div class="row">

        <div class="col-md-4 mb-3">

            <div class="card shadow">

                <div class="card-body">

                    <h5 class="card-title">Productos</h5>

                    <p class="card-text">
                        Administrar los productos de la tienda.
                    </p>

                    <a href="/ecommerce/views/admin/productos.php"
                       class="btn btn-primary">
                        Administrar productos
                    </a>

                </div>

            </div>

        </div>


        <div class="col-md-4 mb-3">

            <div class="card shadow">

                <div class="card-body">

                    <h5 class="card-title">Ventas</h5>

                    <p class="card-text">
                        Consultar las compras realizadas por los clientes.
                    </p>

                    <a href="/ecommerce/views/admin/ventas.php"
                       class="btn btn-primary">
                        Ver ventas
                    </a>

                </div>

            </div>

        </div>
        
        
        <div class="col-md-4 mb-3">

            <div class="card shadow">

                <div class="card-body">

                    <h5 class="card-title">Usuarios</h5>

                    <p class="card-text">
                        Consultar los usuarios registrados en la tienda.
                    </p>

                    <a href="/ecommerce/views/admin/usuarios.php"
                    class="btn btn-primary">
                        Ver usuarios
                    </a>

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
