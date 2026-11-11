
<?php

require_once __DIR__ . "/../../controllers/admin/UsuariosController.php";


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - SpaceTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ecommerce/assets/style/style.css">
</head>
<body>

<?php require_once __DIR__ . "/../../includes/header.php"; ?>



<main class="container mt-5 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Usuarios registrados</h2>

        <a href="/ecommerce/views/admin/index.php"
           class="btn btn-outline-secondary">
            Volver al panel
        </a>

    </div>

    <p class="text-secondary">
        Cantidad de usuarios registrados: <?php echo count($usuarios); ?>
    </p>

    <?php if (count($usuarios) == 0) { ?>

        <div class="alert alert-info">
            Todavía no hay usuarios registrados.
        </div>

    <?php } else { ?>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-light">

                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Tipo de usuario</th>
                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($usuarios as $usuario) { ?>

                        <tr>

                            <td>
                                <?php echo $usuario["idUsuario"]; ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($usuario["nombre"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($usuario["email"]); ?>
                            </td>

                            <td>

                                <?php if ($usuario["tipoUsuario"] == "administrador") { ?>

                                    <span class="badge bg-primary">
                                        Administrador
                                    </span>

                                <?php } else { ?>

                                    <span class="badge bg-secondary">
                                        Cliente
                                    </span>

                                <?php } ?>

                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    <?php } ?>

</main>

<?php
require_once __DIR__ . "/../../includes/footer.php";
?>

</body>
</html>
