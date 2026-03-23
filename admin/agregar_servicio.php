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
                    <h4 class="mb-0">Agregar Servicio</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($_GET['error']) ?>
                        </div>
                    <?php endif; ?>
                    <form action="procesar_agregar_servicio.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="imagenServicio" class="form-label">Imagen:</label>
                            <input type="file" class="form-control" id="imagenServicio" name="imagenServicio" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="nombreServicio" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombreServicio" name="nombreServicio" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcionServicio" class="form-label">Descripción:</label>
                            <textarea class="form-control" id="descripcionServicio" name="descripcionServicio" rows="3" required></textarea>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn-registrarse">
                                Agregar Servicio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer_admin.php'; ?>