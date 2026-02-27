<?php

$bodyClass = 'pagina-agregar-local';
include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include 'header_admin.php';
?>

<div class="container mt-5" id="form-container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow" style="margin: 0 auto;">
                <div class="card-header bg-primary text-white text-center" id="tarjeta-registrarse">
                    <h4 class="mb-0">Agregar Novedad</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($_GET['error']) ?>
                        </div>
                    <?php endif; ?>
                    <form action="procesar_agregar_novedad.php" method="POST">
                        <div class="mb-3">
                            <label for="textoNovedad" class="form-label">Texto:</label>
                            <textarea class="form-control" id="textoNovedad" name="textoNovedad" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="fechaDesdeNovedad" class="form-label">Fecha desde:</label>
                            <input type="date" class="form-control" id="fechaDesdeNovedad" name="fechaDesdeNovedad" required>
                        </div>
                        <div class="mb-3">
                            <label for="fechaHastaNovedad" class="form-label">Fecha hasta:</label>
                            <input type="date" class="form-control" id="fechaHastaNovedad" name="fechaHastaNovedad" required>
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
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn-registrarse">
                                Agregar Novedad
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer_admin.php'; ?>