<?php
include '../includes/sesion.php';
verificarSesion();
verificarRol('dueño');

include '../includes/conexion_db.php';

if (!isset($_GET['codPromo']) || !is_numeric($_GET['codPromo'])) {
    header('Location: gestionar_promociones.php');
    exit;
}

$codPromo   = intval($_GET['codPromo']);
$codUsuario = $_SESSION['codUsuario'];

$sqlVerificar = "SELECT p.codPromo FROM promociones p
                 JOIN locales l ON p.codLocal = l.codLocal
                 WHERE p.codPromo = $codPromo AND l.codUsuario = $codUsuario";
$resultado = mysqli_query($conexion, $sqlVerificar);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    header('Location: gestionar_promociones.php');
    exit;
}

$sqlEliminarUsos = "DELETE FROM uso_promociones WHERE codPromo = $codPromo";
mysqli_query($conexion, $sqlEliminarUsos);

$sqlEliminar = "DELETE FROM promociones WHERE codPromo = $codPromo";
mysqli_query($conexion, $sqlEliminar);
mysqli_close($conexion);

header('Location: gestionar_promociones.php');
exit;
?>