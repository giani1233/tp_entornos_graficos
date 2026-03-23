<?php

$bodyClass = 'pagina-agregar-promocion';
include '../includes/sesion.php';
verificarSesion();
verificarRol('dueño');

include 'header_dueno.php';
include '../includes/conexion_db.php';

$codUsuario = $_SESSION['codUsuario'];
$sql_local = "SELECT codLocal FROM locales WHERE codUsuario = $codUsuario";
$resultado_local = mysqli_query($conexion, $sql_local);
$local = mysqli_fetch_assoc($resultado_local);
$codLocal = $local['codLocal'];
mysqli_close($conexion);

$diasSemana = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

?>

<div class="container mt-5" id="form-container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow" style="margin: 0 auto;">
                <div class="card-header bg-primary text-white text-center" id="tarjeta-registrarse">
                    <h4 class="mb-0">Agregar Promoción</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($_GET['error']) ?>
                        </div>
                    <?php endif; ?>
                    <form action="procesar_agregar_promocion.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="codLocal" value="<?= $codLocal ?>">
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen:</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="textoPromo" class="form-label">Texto de la promoción:</label>
                            <textarea class="form-control" id="textoPromo" name="textoPromo" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="fechaDesdePromo" class="form-label">Fecha desde:</label>
                            <input type="date" class="form-control" id="fechaDesdePromo" name="fechaDesdePromo" required>
                        </div>
                        <div class="mb-3">
                            <label for="fechaHastaPromo" class="form-label">Fecha hasta:</label>
                            <input type="date" class="form-control" id="fechaHastaPromo" name="fechaHastaPromo" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoriaCliente" class="form-label">Categoría de cliente:</label>
                            <select class="form-select" id="categoriaCliente" name="categoriaCliente" required>
                                <option value="">Seleccioná una categoría</option>
                                <option value="Inicial">Inicial</option>
                                <option value="Medium">Medium</option>
                                <option value="Premium">Premium</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Días de la semana:</label>
                            <div class="dias-check-grid">
                                <?php foreach ($diasSemana as $dia): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="diasSemana[]" id="dia_<?= $dia ?>" value="<?= $dia ?>">
                                        <label class="form-check-label" for="dia_<?= $dia ?>">
                                            <?= $dia ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn-registrarse">
                                Agregar Promoción
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer_dueno.php'; ?>