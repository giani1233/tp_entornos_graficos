<?php

$bodyClass = 'pagina-consumir';

include 'includes/header_visitante.php';
include 'includes/conexion_db.php';

$diasSemana       = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
$diaActual        = $diasSemana[date('N') - 1];
$categoriaCliente = $_SESSION['categoriaCliente'];

$sql_locales = "SELECT codLocal, nombreLocal FROM locales WHERE activo = 1 ORDER BY nombreLocal ASC";
$resultado_locales = mysqli_query($conexion, $sql_locales);
$locales = mysqli_fetch_all($resultado_locales, MYSQLI_ASSOC);

$codLocalSeleccionado    = isset($_GET['codLocal']) && is_numeric($_GET['codLocal']) ? intval($_GET['codLocal']) : null;
$codPromoPreseleccionada = isset($_GET['codPromo']) && is_numeric($_GET['codPromo']) ? intval($_GET['codPromo']) : null;
$promociones = [];

if ($codLocalSeleccionado) {
    $sql_promos = "SELECT codPromo, textoPromo
                   FROM promociones
                   WHERE codLocal = $codLocalSeleccionado
                   AND estadoPromo = 'Aprobada'
                   AND fechaDesdePromo <= CURDATE()
                   AND fechaHastaPromo >= CURDATE()
                   AND JSON_CONTAINS(diasSemana, '\"$diaActual\"')
                   AND (
                       categoriaCliente = 'Inicial'
                       OR (categoriaCliente = 'Medium' AND '$categoriaCliente' IN ('Medium', 'Premium'))
                       OR (categoriaCliente = 'Premium' AND '$categoriaCliente' = 'Premium')
                   )
                   ORDER BY fechaDesdePromo DESC";
    $resultado_promos = mysqli_query($conexion, $sql_promos);
    if ($resultado_promos) {
        $promociones = mysqli_fetch_all($resultado_promos, MYSQLI_ASSOC);
    }
}
?>

<div class="container mt-5" id="form-container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow" style="max-width: 500px; margin: 0 auto;">
                <div class="card-header bg-primary text-white text-center" id="tarjeta-registrarse">
                    <h4 class="mb-0">Consumir Promoción</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_GET['exito'])): ?>
                        <div class="alert alert-success text-center mb-3">
                            ¡Solicitud enviada exitosamente!
                        </div>
                    <?php endif; ?>
                    <form method="GET" action="consumir_promo.php">
                        <div class="mb-3">
                            <label for="codLocal" class="form-label">Local:</label>
                            <select class="form-select" id="codLocal" name="codLocal"
                                    onchange="this.form.submit()">
                                <option value="">Seleccione un local</option>
                                <?php foreach ($locales as $local): ?>
                                    <option value="<?= $local['codLocal'] ?>"
                                        <?= $codLocalSeleccionado == $local['codLocal'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($local['nombreLocal']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                    <?php if ($codLocalSeleccionado): ?>
                        <?php if (empty($promociones)): ?>
                            <p class="text-center mt-2" style="opacity: 0.7;">
                                No hay promociones disponibles para este local hoy.
                            </p>
                        <?php else: ?>
                            <form method="POST" action="procesar_solicitud_promo.php"
                                onsubmit="return confirm('¿Confirmás que querés solicitar esta promoción?')">
                                <input type="hidden" name="codLocal" value="<?= $codLocalSeleccionado ?>">
                                <div class="mb-3">
                                    <label for="codPromo" class="form-label">Promoción:</label>
                                    <select class="form-select" id="codPromo" name="codPromo" required>
                                        <option value="">Seleccione una promoción</option>
                                        <?php foreach ($promociones as $promo): ?>
                                            <option value="<?= $promo['codPromo'] ?>"
                                                <?= $codPromoPreseleccionada == $promo['codPromo'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($promo['textoPromo']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg" id="btn-registrarse">
                                        Solicitar Promoción
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>