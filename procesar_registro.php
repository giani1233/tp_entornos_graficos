<?php 

include 'includes/conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['emailUsuario'];
    $nombre = $_POST['nombreUsuario'];
    $apellido = $_POST['apellidoUsuario'];
    $contraseña = $_POST['passwordUsuario'];
    $confirmarContraseña = $_POST['confirmPasswordUsuario'];
    $tipo = $_POST['tipoUsuario'];
    $id_local = isset($_POST['codLocal']) ? $_POST['codLocal'] : null;

    if(empty($email) || empty($nombre) || empty($apellido) || empty($contraseña) || empty($confirmarContraseña) || empty($tipo)){
        die("Error: Todos los campos son obligatorios");
    }

    if($contraseña != $confirmarContraseña){
        die("Error: Las contraseñas no coinciden");
    }

    if(strlen($contraseña) < 8){
        die("Error: La contraseña debe tener 8 caracteres como mínimo");
    }

    $password = password_hash($contraseña, PASSWORD_DEFAULT);

    if ($tipo == 'cliente') {
        $sql = "INSERT INTO usuarios (emailUsuario, claveUsuario, tipoUsuario, categoriaCliente, estadoUsuario, nombreUsuario, apellidoUsuario)
                VALUES ('$email', '$password', '$tipo', 'Inicial', 'Activo', '$nombre', '$apellido')";
    } elseif ($tipo == 'dueño') {
        $sqlVerificarLocal = "SELECT codUsuario FROM locales WHERE codLocal = '$id_local' and codUsuario IS NOT NULL";
        $resultado = mysqli_query($conexion, $sqlVerificarLocal);

        if (mysqli_num_rows($resultado) > 0) {
            die('Error: El local ya tiene un dueño asignado. ');
        } else {
            $sql = "INSERT INTO usuarios (emailUsuario, claveUsuario, tipoUsuario, categoriaCliente, estadoUsuario, nombreUsuario, apellidoUsuario)
                    VALUES ('$email', '$password', '$tipo', NULL, 'Pendiente', '$nombre', '$apellido')";
        }
    }

    if(mysqli_query($conexion, $sql)) {
        header('Location: login.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
}