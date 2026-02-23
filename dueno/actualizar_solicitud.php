<?php
include '../includes/sesion.php';
verificarSesion();
verificarRol('dueño');

include '../includes/conexion_db.php';

if (!isset($_GET['codUso']) || !is_numeric($_GET['codUso'])) {
    header('Location: gestionar_solicitudes.php');
    exit;
}

$codUso  = intval($_GET['codUso']);
$estado  = $_GET['estado'] ?? '';
$codUsuario = $_SESSION['codUsuario'];

if (!in_array($estado, ['Aceptada', 'Rechazada'])) {
    header('Location: gestionar_solicitudes.php');
    exit;
}

$sqlVerificar = "SELECT up.codUso FROM uso_promociones up
                 JOIN promociones p ON up.codPromo = p.codPromo
                 JOIN locales l ON p.codLocal = l.codLocal
                 WHERE up.codUso = $codUso AND l.codUsuario = $codUsuario";
$resultado = mysqli_query($conexion, $sqlVerificar);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    header('Location: gestionar_solicitudes.php');
    exit;
}

$sqlActualizar = "UPDATE uso_promociones SET estadoUsoPromo = '$estado' WHERE codUso = $codUso";
mysqli_query($conexion, $sqlActualizar);
mysqli_close($conexion);

header('Location: gestionar_solicitudes.php');
exit;
?>