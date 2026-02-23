<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rio Shopping - Panel Dueño</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="../assets/css/dueno.css" rel="stylesheet"> 
    <link href="../assets/css/indexDueno.css" rel="stylesheet"> 
    <link href="../assets/css/gestionarPromociones.css" rel="stylesheet">
    <link href="../assets/css/agregarPromocion.css" rel="stylesheet">
</head>
<body class="<?php echo $bodyClass ?? ''; ?>">
    <nav class="navbar navbar-expand-lg navbar-light" id="navbar-dueno">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <a class="navbar-brand" href="index_dueno.php">
                    <img src="../assets/images/icono.svg" alt="Logo" id="logo-header-dueno">
                    <img src="../assets/images/icono_reducido.svg" alt="Logo" id="logo-reducido-dueno">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbarNavDueno">
                <div class="navbar-nav" id="navbar-items-dueno">
                    <a class="nav-item nav-link" href="gestionar_promociones.php">Gestionar Promociones</a>
                    <a class="nav-item nav-link" href="gestionar_solicitudes.php">Gestionar Solicitudes</a>
                    <a class="nav-item nav-link" href="reportes.php">Reportes</a>
                    <a class="nav-item nav-link" id="btn-cerrar-sesion-dueno" href="../logout.php"
                        onclick="return confirm('¿Está seguro que desea cerrar sesión?')">
                        Cerrar sesión
                    </a>
                </div>
            </div>
            <div id="right-buttons-dueno">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDueno"
                    aria-controls="navbarNavDueno" aria-expanded="false" aria-label="Toggle navigation" id="boton-header-dueno">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </nav>
    <div id="espacio-dueno"></div>
    <main class="m-0 p-0" id="main-dueno">