<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre   = trim($_POST['nombreContacto']);
    $apellido = trim($_POST['apellidoContacto']);
    $email    = trim($_POST['emailContacto']);
    $mensaje  = trim($_POST['mensajeContacto']);
    if (empty($nombre) || empty($apellido) || empty($email) || empty($mensaje)) {
        header('Location: index.php#contacto');
        exit;
    }
    $destinatario = 'gianimesapelle04@gmail.com'; 
    $asunto = 'Nueva consulta desde Rio Shopping';
    $cuerpo = "Nueva consulta recibida desde el sitio web.\n\n";
    $cuerpo .= "Nombre:   $nombre $apellido\n";
    $cuerpo .= "Email:    $email\n\n";
    $cuerpo .= "Motivo de consulta:\n$mensaje\n";
    $headers  = "From: no-reply@rioshopping.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    mail($destinatario, $asunto, $cuerpo, $headers);
}
header('Location: index.php?enviado=1#contacto');
exit;
?>