<?php 

include 'includes/conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['nombreUsuario'];
    $password = password_hash($_POST['passwordUsuario'], PASSWORD_DEFAULT);
    $tipo = $_POST['tipoUsuario'];
    $id_local = isset($_POST['codLocal']) ? $_POST['codLocal'] : null;

    if ($tipo == 'cliente') {
        $sql = "INSERT INTO usuarios (nombreUsuario, claveUsuario, tipoUsuario, categoriaCliente, estadoUsuario)
                VALUES ('$email', '$password', '$tipo', 'Inicial', 'Activo')";
    } elseif ($tipo == 'dueño') {
        $sqlVerificarLocal = "SELECT codUsuario FROM locales WHERE codLocal = '$id_local'";
        $resultado = mysqli_query($conexion, $sqlVerificarLocal);

        if (mysqli_num_rows($resultado) > 0) {
            die('Error: El local ya tiene un dueño asignado. ');
        } else {
            $sql = "INSERT INTO usuarios (nombreUsuario, claveUsuario, tipoUsuario, categoriaCliente, estadoUsuario)
                    VALUES ('$email', '$password', '$tipo', NULL, 'Pendiente')";
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