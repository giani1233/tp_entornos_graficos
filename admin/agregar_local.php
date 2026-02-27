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
                    <h4 class="mb-0">Agregar Local</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($_GET['error']) ?>
                        </div>
                    <?php endif; ?>
                    <form action="procesar_agregar_local.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Logo del local:</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="nombreLocal" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombreLocal" name="nombreLocal" required>
                        </div>
                        <div class="mb-3">
                            <label for="informacionLocal" class="form-label">Información:</label>
                            <textarea class="form-control" id="informacionLocal" name="informacionLocal" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="ubicacionLocal" class="form-label">Ubicación:</label>
                            <input type="text" class="form-control" id="ubicacionLocal" name="ubicacionLocal" required>
                        </div>
                        <div class="mb-3">
                            <label for="rubroLocal" class="form-label">Rubro:</label>
                            <input type="text" class="form-control" id="rubroLocal" name="rubroLocal" required>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn-registrarse">
                                Agregar Local
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer_admin.php'; ?>