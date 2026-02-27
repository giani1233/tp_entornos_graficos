<?php

$bodyClass = 'pagina-agregar-local';
include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include 'header_admin.php';
include '../includes/conexion_db.php';

if (!isset($_GET['codServicio']) || !is_numeric($_GET['codServicio'])) {
    header('Location: gestionar_servicios.php');
    exit;
}

$codServicio = intval($_GET['codServicio']);
$sql = "SELECT * FROM servicios WHERE codServicio = $codServicio";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    header('Location: gestionar_servicios.php');
    exit;
}

$servicio = mysqli_fetch_assoc($resultado);
mysqli_close($conexion);
?>

<div class="container mt-5" id="form-container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow" style="margin: 0 auto;">
                <div class="card-header bg-primary text-white text-center" id="tarjeta-registrarse">
                    <h4 class="mb-0">Modificar Servicio</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($_GET['error']) ?>
                        </div>
                    <?php endif; ?>
                    <form action="procesar_modificar_servicio.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="codServicio" value="<?= $codServicio ?>">
                        <div class="mb-3">
                            <label class="form-label">Imagen actual:</label><br>
                            <?php if (!empty($servicio['imagenServicio'])): ?>
                                <img src="../assets/images/servicios/<?= htmlspecialchars($servicio['imagenServicio']) ?>"
                                     alt="Imagen actual"
                                     style="width:80px; height:80px; object-fit:cover; border-radius:10px; margin-bottom:0.5rem;">
                            <?php else: ?>
                                <span style="opacity:0.6; font-size:0.9rem;">Sin imagen</span>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="imagenServicio" name="imagenServicio" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="nombreServicio" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombreServicio" name="nombreServicio"
                                   value="<?= htmlspecialchars($servicio['nombreServicio']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcionServicio" class="form-label">Descripción:</label>
                            <textarea class="form-control" id="descripcionServicio" name="descripcionServicio"
                                      rows="3" required><?= htmlspecialchars($servicio['descripcionServicio']) ?></textarea>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn-registrarse">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer_admin.php'; ?>