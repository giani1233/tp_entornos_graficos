<?php

include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include '../includes/conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $textoNovedad    = trim($_POST['textoNovedad']);
    $fechaDesde      = $_POST['fechaDesdeNovedad'];
    $fechaHasta      = $_POST['fechaHastaNovedad'];
    $categoria       = $_POST['categoriaCliente'];

    if (empty($textoNovedad) || empty($fechaDesde) || empty($fechaHasta) || empty($categoria)) {
        header('Location: agregar_novedad.php?error=Todos los campos son obligatorios.');
        exit;
    }

    if ($fechaHasta < $fechaDesde) {
        header('Location: agregar_novedad.php?error=La fecha hasta no puede ser anterior a la fecha desde.');
        exit;
    }

    $sql = "INSERT INTO novedades (textoNovedad, fechaDesdeNovedad, fechaHastaNovedad, categoriaCliente, tipoUsuario)
            VALUES ('$textoNovedad', '$fechaDesde', '$fechaHasta', '$categoria', 'cliente')";

    if (mysqli_query($conexion, $sql)) {
        mysqli_close($conexion);
        header('Location: gestionar_novedades.php');
        exit;
    } else {
        die("Error al guardar la novedad: " . mysqli_error($conexion));
    }

} else {
    header('Location: agregar_novedad.php');
    exit;
}

?>