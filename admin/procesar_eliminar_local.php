<?php

include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include '../includes/conexion_db.php';

if (!isset($_GET['codLocal']) || !is_numeric($_GET['codLocal'])) {
    header('Location: gestionar_locales.php');
    exit;
}

$codLocal = intval($_GET['codLocal']);

$sqlUsos = "DELETE up FROM uso_promociones up
            JOIN promociones p ON up.codPromo = p.codPromo
            WHERE p.codLocal = $codLocal";
mysqli_query($conexion, $sqlUsos);

$sqlPromos = "DELETE FROM promociones WHERE codLocal = $codLocal";
mysqli_query($conexion, $sqlPromos);

$sqlLocal = "DELETE FROM locales WHERE codLocal = $codLocal";
mysqli_query($conexion, $sqlLocal);

mysqli_close($conexion);

header('Location: gestionar_locales.php');
exit;

?>