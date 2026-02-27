<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rio Shopping - Panel Admin</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="../assets/css/admin.css" rel="stylesheet"> 
    <link href="../assets/css/gestionarPromociones.css" rel="stylesheet">
    <link href="../assets/css/indexAdmin.css" rel="stylesheet">
    <link href="../assets/css/gestionarPromocionesAdmin.css" rel="stylesheet">
    <link href="../assets/css/agregarLocal.css" rel="stylesheet">
</head>
<body class="<?php echo $bodyClass ?? ''; ?>">
    <nav class="navbar navbar-expand-lg navbar-light" id="navbar-admin">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <a class="navbar-brand" href="index_admin.php">
                    <img src="../assets/images/icono.svg" alt="Logo" id="logo-header-admin">
                    <img src="../assets/images/icono_reducido.svg" alt="Logo" id="logo-reducido-admin">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbarNavAdmin">
                <div class="navbar-nav" id="navbar-items-admin">
                    <a class="nav-item nav-link" href="gestionar_promociones_admin.php">Gestionar Promociones</a>
                    <a class="nav-item nav-link" href="gestionar_locales.php">Gestionar Locales</a>
                    <a class="nav-item nav-link" href="gestionar_duenos.php">Gestionar Dueños</a>
                    <a class="nav-item nav-link" href="gestionar_novedades.php">Gestionar Novedades</a>
                    <a class="nav-item nav-link" href="gestionar_servicios.php">Gestionar Servicios</a>
                    <a class="nav-item nav-link" href="reportes_admin.php">Reportes</a>
                    <a class="nav-item nav-link" id="btn-cerrar-sesion-admin" href="../logout.php"
                        onclick="return confirm('Está seguro de que desea cerrar sesión?')">
                        Cerrar sesión
                    </a>
                </div>
            </div>
            <div id="right-buttons-admin">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAdmin"
                    aria-controls="navbarNavAdmin" aria-expanded="false" aria-label="Toggle navigation" id="boton-header-admin">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </nav>
    <div id="espacio-admin"></div>
    <main class="m-0 p-0" id="main-admin">
