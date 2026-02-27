<?php
include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include '../includes/conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $codServicio         = isset($_POST['codServicio']) && is_numeric($_POST['codServicio']) ? intval($_POST['codServicio']) : null;
    $nombreServicio      = trim($_POST['nombreServicio']);
    $descripcionServicio = trim($_POST['descripcionServicio']);

    if (!$codServicio) {
        header('Location: gestionar_servicios.php');
        exit;
    }

    if (empty($nombreServicio) || empty($descripcionServicio)) {
        header("Location: modificar_servicio.php?codServicio=$codServicio&error=Todos los campos son obligatorios.");
        exit;
    }

    $sqlImagen  = "SELECT imagenServicio FROM servicios WHERE codServicio = $codServicio";
    $resImagen  = mysqli_query($conexion, $sqlImagen);
    $fila       = mysqli_fetch_assoc($resImagen);
    $imagenActual = $fila['imagenServicio'];

    if (isset($_FILES['imagenServicio']) && $_FILES['imagenServicio']['error'] == 0) {
        $extension     = pathinfo($_FILES['imagenServicio']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid('servicio_') . '.' . $extension;
        $destino       = '../assets/images/servicios/' . $nombreArchivo;
        if (!move_uploaded_file($_FILES['imagenServicio']['tmp_name'], $destino)) {
            header("Location: modificar_servicio.php?codServicio=$codServicio&error=Error al subir la imagen.");
            exit;
        }
        if (!empty($imagenActual) && file_exists('../assets/images/servicios/' . $imagenActual)) {
            unlink('../assets/images/servicios/' . $imagenActual);
        }
        $imagenSQL = "'$nombreArchivo'";
    } else {
        $imagenSQL = $imagenActual ? "'$imagenActual'" : "NULL";
    }

    $sql = "UPDATE servicios
            SET nombreServicio = '$nombreServicio',
                descripcionServicio = '$descripcionServicio',
                imagenServicio = $imagenSQL
            WHERE codServicio = $codServicio";

    if (mysqli_query($conexion, $sql)) {
        mysqli_close($conexion);
        header('Location: gestionar_servicios.php');
        exit;
    } else {
        die("Error al actualizar el servicio: " . mysqli_error($conexion));
    }

} else {
    header('Location: gestionar_servicios.php');
    exit;
}
?>