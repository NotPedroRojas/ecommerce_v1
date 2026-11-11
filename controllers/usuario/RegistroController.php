<?php

require_once __DIR__ . "/../../models/usuario/Usuario.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $contrasena = $_POST["contrasena"];
    $confirmarContrasena = $_POST["confirmarContrasena"];

    if ($nombre == "" || $email == "" || $contrasena == "" || $confirmarContrasena == "") {
        header("Location: /ecommerce/views/usuario/registro.php?error=campos");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: /ecommerce/views/usuario/registro.php?error=email");
        exit;
    }

    if ($contrasena != $confirmarContrasena) {
        header("Location: /ecommerce/views/usuario/registro.php?error=contrasenas");
        exit;
    }

    $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

    try {
        registrarUsuario($nombre, $email, $contrasenaHash);
        header("Location: /ecommerce/views/usuario/login.php?registro=exitoso");
        exit;
    } catch (PDOException $error) {

        if ($error->getCode() == 23000) {
            header("Location: /ecommerce/views/usuario/registro.php?error=email_existente");
            exit;

        } else {
            header("Location: /ecommerce/views/usuario/registro.php?error=desconocido");
            exit;
        }
    }
}

header("Location: /ecommerce/views/usuario/registro.php");
exit;

?>