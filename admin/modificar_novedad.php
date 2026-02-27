<?php
$bodyClass = 'pagina-agregar-local';
include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include 'header_admin.php';
include '../includes/conexion_db.php';

if (!isset($_GET['codNovedad']) || !is_numeric($_GET['codNovedad'])) {
    header('Location: gestionar_novedades.php');
    exit;
}

$codNovedad = intval($_GET['codNovedad']);
$sql = "SELECT * FROM novedades WHERE codNovedad = $codNovedad";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    header('Location: gestionar_novedades.php');
    exit;
}

$novedad = mysqli_fetch_assoc($resultado);
mysqli_close($conexion);
?>

<div class="container mt-5" id="form-container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow" style="margin: 0 auto;">
                <div class="card-header bg-primary text-white text-center" id="tarjeta-registrarse">
                    <h4 class="mb-0">Modificar Novedad</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($_GET['error']) ?>
                        </div>
                    <?php endif; ?>
                    <form action="procesar_modificar_novedad.php" method="POST">
                        <input type="hidden" name="codNovedad" value="<?= $codNovedad ?>">
                        <div class="mb-3">
                            <label for="textoNovedad" class="form-label">Texto:</label>
                            <textarea class="form-control" id="textoNovedad" name="textoNovedad"
                                      rows="3" required><?= htmlspecialchars($novedad['textoNovedad']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="fechaDesdeNovedad" class="form-label">Fecha desde:</label>
                            <input type="date" class="form-control" id="fechaDesdeNovedad" name="fechaDesdeNovedad"
                                   value="<?= htmlspecialchars($novedad['fechaDesdeNovedad']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="fechaHastaNovedad" class="form-label">Fecha hasta:</label>
                            <input type="date" class="form-control" id="fechaHastaNovedad" name="fechaHastaNovedad"
                                   value="<?= htmlspecialchars($novedad['fechaHastaNovedad']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoriaCliente" class="form-label">Categoría de cliente:</label>
                            <select class="form-select" id="categoriaCliente" name="categoriaCliente" required>
                                <option value="">Seleccioná una categoría</option>
                                <option value="Inicial" <?= $novedad['categoriaCliente'] == 'Inicial' ? 'selected' : '' ?>>Inicial</option>
                                <option value="Medium"  <?= $novedad['categoriaCliente'] == 'Medium'  ? 'selected' : '' ?>>Medium</option>
                                <option value="Premium" <?= $novedad['categoriaCliente'] == 'Premium' ? 'selected' : '' ?>>Premium</option>
                            </select>
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