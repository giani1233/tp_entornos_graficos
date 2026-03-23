<?php

$bodyClass = 'pagina-inicio-dueno';
include '../includes/sesion.php';
verificarSesion();
verificarRol('dueño');

include 'header_dueno.php';
include '../includes/conexion_db.php';

$codUsuario = $_SESSION['codUsuario'];
$sql = "SELECT codLocal, nombreLocal, imagen 
        FROM locales 
        WHERE codUsuario = $codUsuario";
$resultado = mysqli_query($conexion, $sql);
$local = mysqli_fetch_assoc($resultado);
mysqli_close($conexion);
?>

<div class="contenedor-inicio-dueno">
    <div class="layout-inicio-dueno">
        <div class="imagen-dueno">
            <?php if (!empty($local['imagen'])): ?>
                <img src="../assets/images/locales/<?= htmlspecialchars($local['imagen']) ?>"
                    alt="<?= htmlspecialchars($local['nombreLocal']) ?>">
            <?php else: ?>
                <img src="../assets/images/promociones/no-imagen.png" alt="Sin imagen">
            <?php endif; ?>
        </div>
        <div class="info-dueno">
            <h1 class="titulo-local-dueno"><?= htmlspecialchars($local['nombreLocal']) ?></h1>
            <div class="botones-dueno">
                <a href="gestionar_promociones.php" class="btn-dueno">Gestionar Promociones</a>
                <a href="gestionar_solicitudes.php" class="btn-dueno">Gestionar Solicitudes</a>
                <a href="reportes.php" class="btn-dueno">Reportes</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer_dueno.php'; ?>