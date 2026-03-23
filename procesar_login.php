<?php
session_start();
include 'includes/conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $email = $_POST['emailUsuario'];
    $password = $_POST['passwordUsuario'];
    
    if (empty($email) || empty($password)) {
        header('Location: login.php?error=credenciales');
        exit();
    }

    $sql = "SELECT * FROM usuarios WHERE emailUsuario = '$email'";
    $resultado = mysqli_query($conexion, $sql);

    if (!$resultado || mysqli_num_rows($resultado) == 0) {
        header('Location: login.php?error=credenciales');
        exit();
    }

    $usuario = mysqli_fetch_assoc($resultado);

    if (!password_verify($password, $usuario['claveUsuario'])) {
        header('Location: login.php?error=credenciales');
        exit();
    }

    if ($usuario['estadoUsuario'] != 'Activo') {
        header('Location: login.php?error=cuenta_inactiva');
        exit();
    }
    
    $_SESSION['codUsuario']      = $usuario['codUsuario'];
    $_SESSION['nombreUsuario']   = $usuario['nombreUsuario'];
    $_SESSION['apellidoUsuario'] = $usuario['apellidoUsuario'];
    $_SESSION['emailUsuario']    = $usuario['emailUsuario'];
    $_SESSION['tipoUsuario']     = $usuario['tipoUsuario'];

    if ($usuario['tipoUsuario'] == 'cliente') {
        $_SESSION['categoriaCliente'] = $usuario['categoriaCliente'];
    }

    mysqli_close($conexion);

    if ($usuario['tipoUsuario'] == 'admin') {
        header('Location: admin/index_admin.php');
    } elseif ($usuario['tipoUsuario'] == 'dueño') {
        header('Location: dueno/index_dueno.php');
    } else {
        header('Location: index.php');
    }
    exit();

} else {
    header('Location: login.php');
    exit();
}
?>