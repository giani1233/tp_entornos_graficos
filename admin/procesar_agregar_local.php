<?php

include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include '../includes/conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nombreLocal      = trim($_POST['nombreLocal']);
    $informacionLocal = trim($_POST['informacionLocal']);
    $ubicacionLocal   = trim($_POST['ubicacionLocal']);
    $rubroLocal       = trim($_POST['rubroLocal']);

    if (empty($nombreLocal) || empty($informacionLocal) || empty($ubicacionLocal) || empty($rubroLocal)) {
        header('Location: agregar_local.php?error=Todos los campos son obligatorios.');
        exit;
    }

    $nombreArchivo = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $extension     = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid('local_') . '.' . $extension;
        $destino       = '../assets/images/locales/' . $nombreArchivo;
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
            header('Location: agregar_local.php?error=Error al subir la imagen.');
            exit;
        }
    }

    $imagen = $nombreArchivo ? "'$nombreArchivo'" : "NULL";

    $sql = "INSERT INTO locales (nombreLocal, informacionLocal, ubicacionLocal, rubroLocal, imagen, activo)
            VALUES ('$nombreLocal', '$informacionLocal', '$ubicacionLocal', '$rubroLocal', $imagen, 1)";

    if (mysqli_query($conexion, $sql)) {
        mysqli_close($conexion);
        header('Location: gestionar_locales.php');
        exit;
    } else {
        die("Error al guardar el local: " . mysqli_error($conexion));
    }

} else {
    header('Location: agregar_local.php');
    exit;
}
?>