<?php 

include 'includes/header.php'; 
include 'includes/conexion_db.php';

$sql_locales = 'SELECT codLocal, nombreLocal FROM locales WHERE codUsuario IS NULL AND activo = 1';
$resultado_locales = mysqli_query($conexion, $sql_locales);
$locales = mysqli_fetch_all($resultado_locales, MYSQLI_ASSOC);

mysqli_close($conexion);

?>

<div class="container mt-5" id="form-container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow" style="max-width: 500px; margin: 0 auto;">
                <div class="card-header bg-primary text-white text-center" id="tarjeta-registrarse">
                    <h4 class="mb-0">
                        Registrarse
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="procesar_registro.php" method="POST" id="formRegistro">
                        <div class="mb-3">
                            <label for="nombreUsuario" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellidoUsuario" class="form-label">Apellido:</label>
                            <input type="text" class="form-control" id="apellidoUsuario" name="apellidoUsuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="emailUsuario" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="emailUsuario" name="emailUsuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipoUsuario" class="form-label">Tipo de Usuario:</label>
                            <select class="form-select" id="tipoUsuario" name="tipoUsuario" required onchange="mostrarSelectorLocal()">
                                <option value="">Selecciona un tipo</option>
                                <option value="cliente">Cliente</option>
                                <option value="dueño">Dueño de Local</option>
                            </select>
                        </div>
                        <div class="mb-3" id="selector-local" style="display: none">
                            <label for="codLocal" class="form-label">Local:</label>
                            <select class="form-select" id="codLocal" name="codLocal">
                                <option value="">Selecciona un local</option>
                                <?php foreach($locales as $local): ?>
                                    <option value="<?php echo $local['codLocal']; ?>">
                                        <?php echo $local['nombreLocal']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if(empty($locales)): ?>
                                <div class="alert alert-warning mt-2">
                                    No hay locales disponibles.
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="passwordUsuario" class="form-label">Contraseña:</label>
                            <input type="password" class="form-control" id="passwordUsuario" name="passwordUsuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPasswordUsuario" class="form-label">Confirmar Contraseña:</label>
                            <input type="password" class="form-control" id="confirmPasswordUsuario" name="confirmPasswordUsuario" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn-registrarse">
                                Registrarse
                            </button>
                        </div>
                    </form>
                    <div class="text-center mt-3" id="posee-cuenta">
                        <p>¿Ya posee cuenta?
                            <a href="login.php" class="text-decoration-none">Inicia sesión aquí</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>

<?php include 'includes/footer.php'; ?>
