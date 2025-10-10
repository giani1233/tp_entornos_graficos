<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rio Shopping</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="assets/css/visitante.css" rel="stylesheet"> 
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light" id="navbar-visitante">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <a class="navbar-brand" href="#">
                    <img src="assets/images/icono.svg" alt="Logo" id="logo-header">
                    <img src="assets/images/icono_reducido.svg" alt="Logo" id="logo-reducido">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav" id="navbar-items">
                    <a class="nav-item nav-link" href="#">Ofertas</a>
                    <a class="nav-item nav-link" href="#">Entretenimiento</a>
                    <a class="nav-item nav-link" href="#">Locales</a>
                    <a class="nav-item nav-link" href="#">Compras</a>
                    <a class="nav-item nav-link" href="#">Gastronomía</a>
                    <a class="nav-item nav-link" href="#">Servicios</a>
                    <a class="nav-item nav-link" href="#">Ingresar</a>
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