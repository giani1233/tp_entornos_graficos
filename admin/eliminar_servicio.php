<?php

include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include '../includes/conexion_db.php';

if (!isset($_GET['codServicio']) || !is_numeric($_GET['codServicio'])) {
    header('Location: gestionar_servicios.php');
    exit;
}

$codServicio = intval($_GET['codServicio']);

$sqlImagen = "SELECT imagenServicio FROM servicios WHERE codServicio = $codServicio";
$resImagen = mysqli_query($conexion, $sqlImagen);
$fila      = mysqli_fetch_assoc($resImagen);
if (!empty($fila['imagenServicio']) && file_exists('../assets/images/servicios/' . $fila['imagenServicio'])) {
    unlink('../assets/images/servicios/' . $fila['imagenServicio']);
}

$sql = "DELETE FROM servicios WHERE codServicio = $codServicio";
mysqli_query($conexion, $sql);
mysqli_close($conexion);

header('Location: gestionar_servicios.php');
exit;

?>