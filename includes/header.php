
<?php

require_once __DIR__ . "/../models/Categoria.php";

$categoriasPadre = listarCategoriasPadre();

?>

<header class="st-header">

    <nav class="st-navbar">

        <div class="st-logo">
            <a href="/ecommerce/index.php" class="st-nombre">
                SpaceTech
            </a>

            <a href="/ecommerce/index.php">
                <img src="/ecommerce/assets/img/icono.png" alt="Logo de SpaceTech">
            </a>
        </div>

        <div class="st-enlaces">

            <a href="/ecommerce/index.php">Inicio</a>

            <details class="st-menu">

                <summary>Categorías</summary>

                <div class="st-lista-categorias">

                    <?php foreach ($categoriasPadre as $categoria) { ?>

                        <details class="st-categoria">

                            <summary>
                                <?php echo htmlspecialchars($categoria["nombre"]); ?>
                            </summary>

                            <div class="st-subcategorias">

                                <a href="/ecommerce/views/categorias.php?idCategoria=<?php echo $categoria['idCategoria']; ?>">
                                    Ver todos los productos
                                </a>

                                <?php
                                $subcategorias = listarSubcategorias(
                                    $categoria["idCategoria"]
                                );
                                ?>

                                <?php foreach ($subcategorias as $subcategoria) { ?>

                                    <a href="/ecommerce/views/categorias.php?idCategoria=<?php echo $subcategoria['idCategoria']; ?>">
                                        <?php echo htmlspecialchars($subcategoria["nombre"]); ?>
                                    </a>

                                <?php } ?>

                            </div>

                        </details>

                    <?php } ?>

                </div>

            </details>

            <a href="/ecommerce/views/carrito.php">Mi carrito</a>

            <a href="/ecommerce/views/login.php">Iniciar sesión / Registrarse</a>

        </div>

    </nav>

</header>

<style>
.st-header {
    background-color: #212529;
    position: relative;
    z-index: 1000;
}

.st-navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 25px;
    padding: 15px 30px;
}

.st-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
}

.st-logo a {
    text-decoration: none;
}

.st-nombre {
    color: white;
    font-size: 24px;
    font-weight: bold;
}

.st-logo img {
    display: block;
    width: 45px;
    height: 45px;
    object-fit: contain;
}

.st-enlaces {
    display: flex;
    align-items: center;
    gap: 25px;
}

.st-enlaces > a,
.st-menu > summary {
    color: white;
    text-decoration: none;
    white-space: nowrap;
    cursor: pointer;
}

.st-menu {
    position: relative;
}

.st-menu > summary,
.st-categoria > summary {
    list-style: none;
    cursor: pointer;
}

.st-menu > summary::-webkit-details-marker,
.st-categoria > summary::-webkit-details-marker {
    display: none;
}

.st-menu > summary::after,
.st-categoria > summary::after {
    content: " ▼";
    font-size: 10px;
}

.st-lista-categorias {
    position: absolute;
    top: calc(100% + 12px);
    left: 0;
    width: 260px;
    max-height: 70vh;
    overflow-y: auto;
    padding: 8px;
    background-color: white;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    box-sizing: border-box;
}

.st-categoria {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.st-categoria > summary {
    color: #212529;
    font-weight: bold;
}

.st-subcategorias {
    display: flex !important;
    flex-direction: column !important;
    align-items: stretch;
    gap: 10px;
    padding: 12px 0 4px 12px;
}

.st-subcategorias a {
    display: block !important;
    color: #495057;
    text-decoration: none;
    white-space: normal;
    font-size: 14px;
}

.st-subcategorias a:hover {
    color: #0d6efd;
    text-decoration: underline;
}

@media (max-width: 900px) {
    .st-navbar {
        flex-direction: column;
        gap: 15px;
    }

    .st-enlaces {
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
    }
}

@media (max-width: 480px) {
    .st-enlaces {
        flex-direction: column;
    }
}
</style>
