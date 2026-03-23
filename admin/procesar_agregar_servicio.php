<?php

include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include '../includes/conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nombreServicio      = trim($_POST['nombreServicio']);
    $descripcionServicio = trim($_POST['descripcionServicio']);

    if (empty($nombreServicio) || empty($descripcionServicio)) {
        header('Location: agregar_servicio.php?error=Todos los campos son obligatorios.');
        exit;
    }

    $nombreArchivo = null;
    if (isset($_FILES['imagenServicio']) && $_FILES['imagenServicio']['error'] == 0) {
        $extension = pathinfo($_FILES['imagenServicio']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid('servicio_') . '.' . $extension;
        $destino = '../assets/images/servicios/' . $nombreArchivo;
        if (!move_uploaded_file($_FILES['imagenServicio']['tmp_name'], $destino)) {
            header('Location: agregar_servicio.php?error=Error al subir la imagen.');
            exit;
        }
    }

    $imagen = $nombreArchivo ? "'$nombreArchivo'" : "NULL";

    $sql = "INSERT INTO servicios (nombreServicio, descripcionServicio, imagenServicio)
            VALUES ('$nombreServicio', '$descripcionServicio', $imagen)";

    if (mysqli_query($conexion, $sql)) {
        mysqli_close($conexion);
        header('Location: gestionar_servicios.php');
        exit;
    } else {
        die("Error al guardar el servicio: " . mysqli_error($conexion));
    }

} else {
    header('Location: agregar_servicio.php');
    exit;
}

?>