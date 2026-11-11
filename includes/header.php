
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../models/catalogo/Categoria.php";
$categoriasMenu = listarCategoriasPadre();
?>
<header class="st-header">
    <nav class="st-navbar">
        <div class="st-logo">
            <a href="/ecommerce/index.php" class="st-nombre">SpaceTech</a>
            <a href="/ecommerce/index.php">
                <img src="/ecommerce/assets/img/icono.png" alt="Logo de SpaceTech">
            </a>
        </div>
        <form action="/ecommerce/views/catalogo/buscar.php"
            method="GET"
            class="input-group st-buscador">

            <input
                type="search"
                name="q"
                class="form-control"
                placeholder="¿Qué producto estás buscando?"
                aria-label="Buscar productos"
                required
            >

            <button class="btn btn-primary" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    fill="currentColor"
                    viewBox="0 0 16 16">

                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.099zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>

                </svg>
            </button>
        </form>
        <div class="st-enlaces">
            <a href="/ecommerce/index.php">Inicio</a>
            <details class="st-menu">
                <summary>Categorías</summary>
                <div class="st-lista-categorias">
                    <?php foreach ($categoriasMenu as $categoriaMenu) { ?>
                        <details class="st-categoria">
                            <summary><?php echo htmlspecialchars($categoriaMenu["nombre"]); ?></summary>
                            <div class="st-subcategorias">
                                <a href="/ecommerce/views/catalogo/categorias.php?idCategoria=<?php echo $categoriaMenu['idCategoria']; ?>">Ver todos los productos</a>
                                <?php
                                $subcategoriasMenu = listarSubcategorias($categoriaMenu["idCategoria"]);
                                foreach ($subcategoriasMenu as $subcategoriaMenu) {
                                ?>
                                    <a href="/ecommerce/views/catalogo/categorias.php?idCategoria=<?php echo $subcategoriaMenu['idCategoria']; ?>"><?php echo htmlspecialchars($subcategoriaMenu["nombre"]); ?></a>
                                <?php } ?>
                            </div>
                        </details>
                    <?php } ?>
                </div>
            </details>
            <a href="/ecommerce/views/carrito/index.php">Mi carrito</a>
            <?php if (isset($_SESSION["idUsuario"])) { ?>
                <a href="/ecommerce/views/usuario/miCuenta.php">Mi cuenta</a>
                <?php if ($_SESSION["tipoUsuario"] == "administrador") { ?>
                    <a href="/ecommerce/views/admin/index.php">Administración</a>
                <?php } ?>
                <a href="/ecommerce/controllers/usuario/LogoutController.php" class="st-cerrar-sesion">Cerrar sesión</a>
            <?php } else { ?>
                <a href="/ecommerce/views/usuario/login.php">Iniciar sesión</a>
                <a href="/ecommerce/views/usuario/registro.php">Registrarse</a>
            <?php } ?>
        </div>
    </nav>
</header>
