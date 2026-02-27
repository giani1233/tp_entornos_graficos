<?php

include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include '../includes/conexion_db.php';

if (!isset($_GET['codUsuario']) || !is_numeric($_GET['codUsuario'])) {
    header('Location: gestionar_duenos.php');
    exit;
}

$codUsuario = intval($_GET['codUsuario']);
$accion     = $_GET['accion'] ?? '';

if (!in_array($accion, ['aceptar', 'rechazar'])) {
    header('Location: gestionar_duenos.php');
    exit;
}

$sqlVerificar = "SELECT codUsuario, codLocalSeleccionado FROM usuarios
                 WHERE codUsuario = $codUsuario AND tipoUsuario = 'dueño' AND estadoUsuario = 'Pendiente'";
$resultado = mysqli_query($conexion, $sqlVerificar);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    header('Location: gestionar_duenos.php');
    exit;
}

$dueno = mysqli_fetch_assoc($resultado);
$codLocalSeleccionado = $dueno['codLocalSeleccionado'];

if ($accion == 'aceptar') {

    $sqlActivar = "UPDATE usuarios SET estadoUsuario = 'Activo' WHERE codUsuario = $codUsuario";
    mysqli_query($conexion, $sqlActivar);

    if ($codLocalSeleccionado) {
        $sqlAsignar = "UPDATE locales SET codUsuario = $codUsuario WHERE codLocal = $codLocalSeleccionado";
        mysqli_query($conexion, $sqlAsignar);
    }

    mysqli_close($conexion);
    header('Location: gestionar_duenos.php?actualizado=1');
    exit;

} elseif ($accion == 'rechazar') {

    $sqlEliminar = "DELETE FROM usuarios WHERE codUsuario = $codUsuario";
    mysqli_query($conexion, $sqlEliminar);

    mysqli_close($conexion);
    header('Location: gestionar_duenos.php?actualizado=1');
    exit;
}
?>