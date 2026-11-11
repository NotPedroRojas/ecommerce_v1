<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (
    !isset($_SESSION["idUsuario"]) ||
    $_SESSION["tipoUsuario"] != "administrador"
) {

    header("Location: /ecommerce/index.php");
    exit;
}

?>
