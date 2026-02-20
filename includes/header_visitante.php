<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rio Shopping</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="assets/css/visitante.css" rel="stylesheet"> 
    <link href="assets/css/carrusel.css" rel="stylesheet">
    <link href="assets/css/promocion.css" rel="stylesheet">
    <link href="assets/css/seccionLocales.css" rel="stylesheet">
    <link href="assets/css/seccionGastronomia.css" rel="stylesheet">
    <link href="assets/css/local.css" rel="stylesheet">
    <link href="assets/css/seccionServicios.css" rel="stylesheet">
    <link href="assets/css/seccionNovedades.css" rel="stylesheet">
    <link href="assets/css/seccionUbicacion.css" rel="stylesheet">
    <link href="assets/css/consumirPromo.css" rel="stylesheet">
</head>
<body class="<?php echo $bodyClass ?? ''; ?>">
    <nav class="navbar navbar-expand-lg navbar-light" id="navbar-visitante">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <a class="navbar-brand" href="index.php">
                    <img src="assets/images/icono.svg" alt="Logo" id="logo-header">
                    <img src="assets/images/icono_reducido.svg" alt="Logo" id="logo-reducido">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav" id="navbar-items">
                    <a class="nav-item nav-link" href="index.php#ofertas">Ofertas</a>
                    <a class="nav-item nav-link" href="index.php#locales">Locales</a>
                    <a class="nav-item nav-link" href="index.php#gastronomia">Gastronomía</a>
                    <a class="nav-item nav-link" href="index.php#servicios">Servicios</a>
                    <a class="nav-item nav-link" href="index.php#novedades">Novedades</a>
                    <a class="nav-item nav-link" href="index.php#ubicacion">Ubicación</a>
                    <?php if (isset($_SESSION['codUsuario']) && $_SESSION['tipoUsuario'] == 'cliente'): ?>
                        <a class="nav-item nav-link" href="consumir_promo.php">Comprar</a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['codUsuario'])): ?>
                        <a class="nav-item nav-link" id="btn-cerrar-sesion" href="logout.php" 
                        onclick="return confirm('¿Está seguro que desea cerrar sesión?')">
                        Cerrar sesión
                        </a>
                    <?php else: ?>
                        <a class="nav-item nav-link" href="login.php">Ingresar</a>
                    <?php endif; ?>
                </div>
                <input type="text" id="barra-busqueda" placeholder="Buscar..." style="display:none; margin-left:1rem; max-width:200px;" class="form-control">
            </div>
            <div id="right-buttons">
                <img src="assets/images/busqueda.svg" alt="Buscar" id="icono-busqueda">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="boton-header">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </nav>
    <div id="espacio"></div>
    <main class="m-0 p-0" id="main-visitante">