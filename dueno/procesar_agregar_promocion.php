<?php

include '../includes/sesion.php';
verificarSesion();
verificarRol('dueño');

include '../includes/conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $codLocal = isset($_POST['codLocal']) && is_numeric($_POST['codLocal']) ? intval($_POST['codLocal']) : null;
    $textoPromo      = $_POST['textoPromo'];
    $fechaDesde      = $_POST['fechaDesdePromo'];
    $fechaHasta      = $_POST['fechaHastaPromo'];
    $categoria       = $_POST['categoriaCliente'];
    $diasSeleccionados = isset($_POST['diasSemana']) ? $_POST['diasSemana'] : [];

    if (empty($textoPromo) || empty($fechaDesde) || empty($fechaHasta) || empty($categoria)) {
        header('Location: agregar_promocion.php?error=Todos los campos son obligatorios.');
        exit;
    }

    if ($fechaHasta < $fechaDesde) {
        header('Location: agregar_promocion.php?error=La fecha hasta no puede ser anterior a la fecha desde.');
        exit;
    }

    if (empty($diasSeleccionados)) {
        header('Location: agregar_promocion.php?error=Debés seleccionar al menos un día.');
        exit;
    }

    $codUsuario = $_SESSION['codUsuario'];
    $sqlVerificar = "SELECT codLocal FROM locales WHERE codLocal = $codLocal AND codUsuario = $codUsuario";
    $resVerif = mysqli_query($conexion, $sqlVerificar);
    if (!$resVerif || mysqli_num_rows($resVerif) == 0) {
        header('Location: agregar_promocion.php?error=Local no válido.');
        exit;
    }

    $nombreArchivo = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $extension     = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid('promo_') . '.' . $extension;
        $destino       = '../assets/images/promociones/' . $nombreArchivo;
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
            header('Location: agregar_promocion.php?error=Error al subir la imagen.');
            exit;
        }
    }

    $diasJSON = json_encode($diasSeleccionados);

    $imagen = $nombreArchivo ? "'$nombreArchivo'" : "NULL";
    $sql = "INSERT INTO promociones (codLocal, imagen, textoPromo, fechaDesdePromo, fechaHastaPromo, categoriaCliente, diasSemana, estadoPromo)
            VALUES ($codLocal, $imagen, '$textoPromo', '$fechaDesde', '$fechaHasta', '$categoria', '$diasJSON', 'Pendiente')";

    if (mysqli_query($conexion, $sql)) {
        mysqli_close($conexion);
        header('Location: gestionar_promociones.php');
        exit;
    } else {
        die("Error al guardar la promoción: " . mysqli_error($conexion));
    }

} else {
    header('Location: agregar_promocion.php');
    exit;
}

?>