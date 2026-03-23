<?php

include 'includes/conexion_db.php';

$mensaje = '';
$tipo    = '';

if (!isset($_GET['token']) || empty($_GET['token'])) {
    $mensaje = 'El enlace de verificación no es válido.';
    $tipo    = 'error';
} else {

    $token = mysqli_real_escape_string($conexion, $_GET['token']);

    $sql = "SELECT codUsuario, nombreUsuario, tokenExpiracion FROM usuarios
            WHERE tokenVerificacion = '$token'
            AND estadoUsuario = 'Pendiente'
            AND tipoUsuario = 'cliente'";

    $resultado = mysqli_query($conexion, $sql);

    if (!$resultado || mysqli_num_rows($resultado) == 0) {
        $mensaje = 'El enlace de verificación no es válido o ya fue utilizado.';
        $tipo    = 'error';
    } else {
        $usuario    = mysqli_fetch_assoc($resultado);
        $codUsuario = $usuario['codUsuario'];
        $nombre     = $usuario['nombreUsuario'];

        if (strtotime($usuario['tokenExpiracion']) < time()) {
            mysqli_query($conexion, "DELETE FROM usuarios WHERE codUsuario = $codUsuario");
            $mensaje = 'El enlace expiró. Por favor registrate nuevamente.';
            $tipo    = 'error';
        } else {
            $sqlActivar = "UPDATE usuarios
                           SET estadoUsuario = 'Activo', tokenVerificacion = NULL, tokenExpiracion = NULL
                           WHERE codUsuario = $codUsuario";
            mysqli_query($conexion, $sqlActivar);
            $mensaje = "¡Hola $nombre! Tu cuenta fue verificada correctamente. Ya podés iniciar sesión.";
            $tipo    = 'exito';
        }
    }
}

mysqli_close($conexion);

?>

<?php include 'includes/header_visitante.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow" style="max-width:500px; margin:0 auto;">
                <div class="card-header text-white text-center <?= $tipo == 'exito' ? 'bg-success' : 'bg-danger' ?>" id="tarjeta-registrarse">
                    <h4 class="mb-0"><?= $tipo == 'exito' ? 'Cuenta verificada' : 'Error de verificación' ?></h4>
                </div>
                <div class="card-body p-4 text-center">
                    <p style="font-family:'AsapCondensed',sans-serif; font-size:1.05rem; color:#4c596a;">
                        <?= htmlspecialchars($mensaje) ?>
                    </p>
                    <a href="<?= $tipo == 'exito' ? 'login.php' : 'registro.php' ?>" class="btn btn-primary mt-3" id="btn-registrarse">
                        <?= $tipo == 'exito' ? 'Ir al login' : 'Registrarse nuevamente' ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>