<?php

$bodyClass = 'pagina-agregar-local';
include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include 'header_admin.php';
include '../includes/conexion_db.php';

if (!isset($_GET['codLocal']) || !is_numeric($_GET['codLocal'])) {
    header('Location: gestionar_locales.php');
    exit;
}

$codLocal = intval($_GET['codLocal']);
$sql = "SELECT * FROM locales WHERE codLocal = $codLocal";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    header('Location: gestionar_locales.php');
    exit;
}

$local = mysqli_fetch_assoc($resultado);
mysqli_close($conexion);

?>

<div class="container mt-5" id="form-container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow" style="margin: 0 auto;">
                <div class="card-header bg-primary text-white text-center" id="tarjeta-registrarse">
                    <h4 class="mb-0">Modificar Local</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($_GET['error']) ?>
                        </div>
                    <?php endif; ?>
                    <form action="procesar_modificar_local.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="codLocal" value="<?= $codLocal ?>">
                        <div class="mb-3">
                            <label class="form-label">Logo actual:</label><br>
                            <?php if (!empty($local['imagen'])): ?>
                                <img src="../assets/images/locales/<?= htmlspecialchars($local['imagen']) ?>" alt="Logo actual" style="width:80px; height:80px; object-fit:cover; border-radius:10px; margin-bottom:0.5rem;">
                            <?php else: ?>
                                <span>Sin imagen</span>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="nombreLocal" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombreLocal" name="nombreLocal" value="<?= htmlspecialchars($local['nombreLocal']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="informacionLocal" class="form-label">Información:</label>
                            <textarea class="form-control" id="informacionLocal" name="informacionLocal" rows="3" required><?= htmlspecialchars($local['informacionLocal']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="ubicacionLocal" class="form-label">Ubicación:</label>
                            <input type="text" class="form-control" id="ubicacionLocal" name="ubicacionLocal" value="<?= htmlspecialchars($local['ubicacionLocal']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="rubroLocal" class="form-label">Rubro:</label>
                            <input type="text" class="form-control" id="rubroLocal" name="rubroLocal" value="<?= htmlspecialchars($local['rubroLocal']) ?>" required>
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