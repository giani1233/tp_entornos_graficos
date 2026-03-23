<?php

include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include '../includes/conexion_db.php';

if (!isset($_GET['codPromo']) || !is_numeric($_GET['codPromo'])) {
    header('Location: gestionar_promociones_admin.php');
    exit;
}

$codPromo = intval($_GET['codPromo']);
$estado   = $_GET['estado'] ?? '';

if (!in_array($estado, ['Aprobada', 'Denegada'])) {
    header('Location: gestionar_promociones_admin.php');
    exit;
}

$sql = "UPDATE promociones SET estadoPromo = '$estado' WHERE codPromo = $codPromo";
mysqli_query($conexion, $sql);
mysqli_close($conexion);

header('Location: gestionar_promociones_admin.php');
exit;

?>
