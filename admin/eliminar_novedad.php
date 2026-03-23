<?php

include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include '../includes/conexion_db.php';

if (!isset($_GET['codNovedad']) || !is_numeric($_GET['codNovedad'])) {
    header('Location: gestionar_novedades.php');
    exit;
}

$codNovedad = intval($_GET['codNovedad']);

$sql = "DELETE FROM novedades WHERE codNovedad = $codNovedad";
mysqli_query($conexion, $sql);
mysqli_close($conexion);

header('Location: gestionar_novedades.php');
exit;

?>