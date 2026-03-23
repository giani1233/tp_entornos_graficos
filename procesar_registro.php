<?php 

include 'includes/conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email               = trim($_POST['emailUsuario']);
    $nombre              = trim($_POST['nombreUsuario']);
    $apellido            = trim($_POST['apellidoUsuario']);
    $contraseña          = $_POST['passwordUsuario'];
    $confirmarContraseña = $_POST['confirmPasswordUsuario'];
    $tipo                = $_POST['tipoUsuario'];
    $id_local            = isset($_POST['codLocal']) ? $_POST['codLocal'] : null;

    if (empty($email) || empty($nombre) || empty($apellido) || empty($contraseña) || empty($confirmarContraseña) || empty($tipo)) {
        die("Error: Todos los campos son obligatorios");
    }

    if ($contraseña != $confirmarContraseña) {
        die("Error: Las contraseñas no coinciden");
    }

    if (strlen($contraseña) < 8) {
        die("Error: La contraseña debe tener 8 caracteres como mínimo");
    }

    $password = password_hash($contraseña, PASSWORD_DEFAULT);

    if ($tipo == 'cliente') {
        $token           = bin2hex(random_bytes(32));
        $tokenExpiracion = date('Y-m-d H:i:s', strtotime('+24 hours'));
        $sql = "INSERT INTO usuarios (emailUsuario, claveUsuario, tipoUsuario, categoriaCliente, estadoUsuario, nombreUsuario, apellidoUsuario, tokenVerificacion, tokenExpiracion)
                VALUES ('$email', '$password', '$tipo', 'Inicial', 'Pendiente', '$nombre', '$apellido', '$token', '$tokenExpiracion')";

        if (mysqli_query($conexion, $sql)) {

            $baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/tp_entornos_graficos';
            $link    = "$baseUrl/verificar_email.php?token=$token";

            $destinatario = $email;
            $asunto       = 'Verificá tu cuenta en Rio Shopping';

            $cuerpo  = "Hola $nombre $apellido,\n\n";
            $cuerpo .= "Gracias por registrarte en Rio Shopping.\n";
            $cuerpo .= "Para activar tu cuenta hacé clic en el siguiente enlace:\n\n";
            $cuerpo .= "$link\n\n";
            $cuerpo .= "Este enlace expira en 24 horas.\n\n";
            $cuerpo .= "— Rio Shopping";

            $headers  = "From: no-reply@rioshopping.com\r\n";
            $headers .= "Reply-To: no-reply@rioshopping.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            mail($destinatario, $asunto, $cuerpo, $headers);

            mysqli_close($conexion);
            header('Location: login.php?pendiente=verificacion');
            exit();

        } else {
            die("Error al registrar: " . mysqli_error($conexion));
        }

    } elseif ($tipo == 'dueño') {

        $sqlVerificarLocal = "SELECT codUsuario FROM locales WHERE codLocal = '$id_local' AND codUsuario IS NOT NULL";
        $resultado = mysqli_query($conexion, $sqlVerificarLocal);

        if (mysqli_num_rows($resultado) > 0) {
            die('Error: El local ya tiene un dueño asignado.');
        }

        $sql = "INSERT INTO usuarios (emailUsuario, claveUsuario, tipoUsuario, categoriaCliente, estadoUsuario, nombreUsuario, apellidoUsuario, codLocalSolicitado)
                VALUES ('$email', '$password', '$tipo', NULL, 'Pendiente', '$nombre', '$apellido', '$id_local')";

        if (mysqli_query($conexion, $sql)) {
            mysqli_close($conexion);
            header('Location: login.php?pendiente=admin');
            exit();
        } else {
            die("Error al registrar: " . mysqli_error($conexion));
        }
    }
}
?>