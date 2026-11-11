<?php

$paginaCuenta = basename($_SERVER["PHP_SELF"]);
$esPedidos = ($paginaCuenta == "historialCompras.php");

if ($esPedidos) {
    $seccionActual = "pedidos";
} else {
    $seccionActual = $seccionCuenta ?? "datos";
}

?>
<div class="cuenta-menu-titulo">Mi cuenta</div>
<a  href="/ecommerce/views/usuario/miCuenta.php?seccion=datos"
    class="cuenta-menu-enlace <?php if ($seccionActual == "datos") { echo "activo"; } ?>">
    Mis datos
</a>

<a  href="/ecommerce/views/usuario/historialCompras.php"
    class="cuenta-menu-enlace <?php if ($seccionActual == "pedidos") { echo "activo"; } ?>">
    Mis pedidos
</a>

<a  href="/ecommerce/views/usuario/miCuenta.php?seccion=direcciones"
    class="cuenta-menu-enlace <?php if ($seccionActual == "direcciones") { echo "activo"; } ?>">
    Mis direcciones
</a>

<a  href="/ecommerce/views/usuario/miCuenta.php?seccion=pago"
    class="cuenta-menu-enlace <?php if ($seccionActual == "pago") { echo "activo"; } ?>">
    Método de pago
</a>

<a  href="/ecommerce/views/usuario/miCuenta.php?seccion=contrasena"
    class="cuenta-menu-enlace <?php if ($seccionActual == "contrasena") { echo "activo"; } ?>">
    Cambiar contraseña
</a>
