<?php 
$bodyClass = 'pagina-local';
include 'includes/header_visitante.php';
include 'includes/conexion_db.php';

if(!isset($_GET['codLocal']) || !is_numeric($_GET['codLocal'])) {
    echo "<h2>Código de local inválido.</h2>";
    include 'includes/footer.php';
    exit;
}

$codLocal = intval($_GET['codLocal']);

$sql = "SELECT l.nombreLocal, l.ubicacionLocal, l.rubroLocal, l.imagen, l.informacionLocal
        FROM locales l
        WHERE l.codLocal = $codLocal";

$resultado = mysqli_query($conexion, $sql);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    echo "<h2>Local no encontrado.</h2>";
    include 'includes/footer.php';
    exit;
}

$local = mysqli_fetch_assoc($resultado);
?>

<div class="container my-5">
    <div class="row g-4">
        <div class="col-md-6 text-center">
            <?php if(!empty($local['imagen'])): ?>
                <img src="assets/images/locales/<?php echo $local['imagen']; ?>" 
                    class="img-fluid rounded shadow" 
                    alt="<?php echo htmlspecialchars($local['nombreLocal']); ?>">
            <?php else: ?>
                <img src="assets/images/promociones/no-imagen.png" 
                    class="img-fluid rounded shadow" 
                    alt="Promoción sin imagen">
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title mb-3"><?php echo htmlspecialchars($local['nombreLocal']); ?></h3>
                    <p class="card-text"><?php echo htmlspecialchars($local['informacionLocal']); ?></p>
                    <p class="card-text"><strong>Ubicación:</strong> <?php echo htmlspecialchars($local['ubicacionLocal']); ?></p>
                    <p class="card-text"><strong>Rubro:</strong> <?php echo htmlspecialchars($local['rubroLocal']); ?></p>
                </div>
            </div>
        </div>
    </div>    
</div>

<?php
include 'includes/footer.php';
?>
