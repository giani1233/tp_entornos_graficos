<?php
include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include '../includes/conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $codLocal         = isset($_POST['codLocal']) && is_numeric($_POST['codLocal']) ? intval($_POST['codLocal']) : null;
    $nombreLocal      = trim($_POST['nombreLocal']);
    $informacionLocal = trim($_POST['informacionLocal']);
    $ubicacionLocal   = trim($_POST['ubicacionLocal']);
    $rubroLocal       = trim($_POST['rubroLocal']);

    if (!$codLocal) {
        header('Location: gestionar_locales.php');
        exit;
    }

    if (empty($nombreLocal) || empty($informacionLocal) || empty($ubicacionLocal) || empty($rubroLocal)) {
        header("Location: modificar_local.php?codLocal=$codLocal&error=Todos los campos son obligatorios.");
        exit;
    }

    $sqlImagen = "SELECT imagen FROM locales WHERE codLocal = $codLocal";
    $resImagen = mysqli_query($conexion, $sqlImagen);
    $filaImagen = mysqli_fetch_assoc($resImagen);
    $imagenActual = $filaImagen['imagen'];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $extension    = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid('local_') . '.' . $extension;
        $destino      = '../assets/images/locales/' . $nombreArchivo;
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
            header("Location: modificar_local.php?codLocal=$codLocal&error=Error al subir la imagen.");
            exit;
        }
        if (!empty($imagenActual) && file_exists('../assets/images/locales/' . $imagenActual)) {
            unlink('../assets/images/locales/' . $imagenActual);
        }
        $imagenSQL = "'$nombreArchivo'";
    } else {
        $imagenSQL = $imagenActual ? "'$imagenActual'" : "NULL";
    }

    $sql = "UPDATE locales
            SET nombreLocal = '$nombreLocal',
                informacionLocal = '$informacionLocal',
                ubicacionLocal = '$ubicacionLocal',
                rubroLocal = '$rubroLocal',
                imagen = $imagenSQL
            WHERE codLocal = $codLocal";

    if (mysqli_query($conexion, $sql)) {
        mysqli_close($conexion);
        header('Location: gestionar_locales.php');
        exit;
    } else {
        die("Error al actualizar el local: " . mysqli_error($conexion));
    }

} else {
    header('Location: gestionar_locales.php');
    exit;
}
?>