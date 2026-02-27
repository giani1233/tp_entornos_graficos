<?php
include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include '../includes/conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $codNovedad   = isset($_POST['codNovedad']) && is_numeric($_POST['codNovedad']) ? intval($_POST['codNovedad']) : null;
    $textoNovedad = trim($_POST['textoNovedad']);
    $fechaDesde   = $_POST['fechaDesdeNovedad'];
    $fechaHasta   = $_POST['fechaHastaNovedad'];
    $categoria    = $_POST['categoriaCliente'];

    if (!$codNovedad) {
        header('Location: gestionar_novedades.php');
        exit;
    }

    if (empty($textoNovedad) || empty($fechaDesde) || empty($fechaHasta) || empty($categoria)) {
        header("Location: modificar_novedad.php?codNovedad=$codNovedad&error=Todos los campos son obligatorios.");
        exit;
    }

    if ($fechaHasta < $fechaDesde) {
        header("Location: modificar_novedad.php?codNovedad=$codNovedad&error=La fecha hasta no puede ser anterior a la fecha desde.");
        exit;
    }

    $sql = "UPDATE novedades
            SET textoNovedad = '$textoNovedad',
                fechaDesdeNovedad = '$fechaDesde',
                fechaHastaNovedad = '$fechaHasta',
                categoriaCliente = '$categoria'
            WHERE codNovedad = $codNovedad";

    if (mysqli_query($conexion, $sql)) {
        mysqli_close($conexion);
        header('Location: gestionar_novedades.php');
        exit;
    } else {
        die("Error al actualizar la novedad: " . mysqli_error($conexion));
    }

} else {
    header('Location: gestionar_novedades.php');
    exit;
}
?>