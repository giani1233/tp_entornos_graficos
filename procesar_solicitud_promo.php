<?php

include 'includes/sesion.php';
verificarSesion();
verificarRol('cliente');

include 'includes/conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $codPromo  = isset($_POST['codPromo'])  && is_numeric($_POST['codPromo'])  ? intval($_POST['codPromo'])  : null;
    $codLocal  = isset($_POST['codLocal'])  && is_numeric($_POST['codLocal'])  ? intval($_POST['codLocal'])  : null;
    $codCliente = $_SESSION['codUsuario'];

    if (!$codPromo || !$codLocal) {
        die("Error: datos incompletos.");
    }

    $sqlYaUsada = "SELECT codUso FROM uso_promociones 
                   WHERE codCliente = $codCliente AND codPromo = $codPromo";
    $resYaUsada = mysqli_query($conexion, $sqlYaUsada);
    if ($resYaUsada && mysqli_num_rows($resYaUsada) > 0) {
        header('Location: consumir_promo.php?error=Ya solicitaste esta promoción anteriormente.');
        exit;
    }

    $diasSemana = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
    $diaActual  = $diasSemana[date('N') - 1];
    $categoriaCliente = $_SESSION['categoriaCliente'];

    $fechaHoy = date('Y-m-d');
    $sqlInsertar = "INSERT INTO uso_promociones (fechaUsoPromo, estadoUsoPromo, codCliente, codPromo)
                    VALUES ('$fechaHoy', 'Enviada', $codCliente, $codPromo)";

    if (mysqli_query($conexion, $sqlInsertar)) {
        mysqli_close($conexion);
        header('Location: consumir_promo.php?exito=1');
        exit();
    } else {
        die("Error al registrar la solicitud: " . mysqli_error($conexion));
    }
    
} else {
    header('Location: consumir_promo.php');
    exit();
}

?>