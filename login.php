<?php 
include 'includes/header.php'; 
?>

<div class="container mt-5" id="form-container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow" style="max-width: 500px; margin: 0 auto;">
                <div class="card-header bg-primary text-white text-center" id="tarjeta-registrarse">
                    <h4 class="mb-0">Iniciar Sesión</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger text-center">
                            <?php
                                $error = $_GET['error'];
                                if ($error == 'credenciales') echo 'Email o contraseña incorrectos.';
                                elseif ($error == 'cuenta_inactiva') echo 'Tu cuenta está pendiente de aprobación.';
                            ?>
                        </div>
                    <?php endif; ?>
                    <form action="procesar_login.php" method="POST" id="formLogin">
                        <div class="mb-3">
                            <label for="emailUsuario" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="emailUsuario" name="emailUsuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="passwordUsuario" class="form-label">Contraseña:</label>
                            <input type="password" class="form-control" id="passwordUsuario" name="passwordUsuario" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn-registrarse">
                                Ingresar
                            </button>
                        </div>
                    </form>
                    <div class="text-center mt-3" id="posee-cuenta">
                        <p>Aun no posee cuenta?
                            <a href="registro.php" class="text-decoration-none">Registrarse</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>