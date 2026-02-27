<?php

$bodyClass = 'pagina-inicio-admin';
include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include 'header_admin.php';
?>

<div class="contenedor-inicio-admin">
    <div class="layout-inicio-admin">

        <div class="imagen-admin">
            <img src="../assets/images/icono.svg" alt="Rio Shopping">
        </div>

        <div class="info-admin">
            <h1 class="titulo-admin">Rio Shopping</h1>
            <div class="botones-admin">
                <a href="gestionar_promociones_admin.php" class="btn-admin">Gestionar Promociones</a>
                <a href="gestionar_locales.php" class="btn-admin">Gestionar Locales</a>
                <a href="gestionar_duenos.php" class="btn-admin">Gestionar Dueños</a>
                <a href="gestionar_novedades.php" class="btn-admin">Gestionar Novedades</a>
                <a href="gestionar_servicios.php" class="btn-admin">Gestionar Servicios</a>
                <a href="reportes_admin.php" class="btn-admin">Reportes</a>
            </div>
        </div>

    </div>
</div>

<?php include 'footer_admin.php'; ?>