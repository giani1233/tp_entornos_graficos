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

$diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
$diaActual  = $diasSemana[date('N') - 1];
$promociones_local = [];

if (isset($_SESSION['codUsuario']) && $_SESSION['tipoUsuario'] == 'cliente') {
    $categoriaCliente = $_SESSION['categoriaCliente'];
    $sql_promos = "SELECT codPromo, textoPromo FROM promociones
                   WHERE codLocal = $codLocal
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
} else {
    $sql_promos = "SELECT codPromo, textoPromo FROM promociones
                   WHERE codLocal = $codLocal
                   AND estadoPromo = 'Aprobada'
                   AND fechaDesdePromo <= CURDATE()
                   AND fechaHastaPromo >= CURDATE()
                   AND JSON_CONTAINS(diasSemana, '\"$diaActual\"')
                   ORDER BY fechaDesdePromo DESC";
}

$resultado_promos = mysqli_query($conexion, $sql_promos);
if ($resultado_promos) {
    $promociones_local = mysqli_fetch_all($resultado_promos, MYSQLI_ASSOC);
}
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

                    <?php if (!empty($promociones_local)): ?>
                        <hr>
                        <h5 class="mb-3">Promociones disponibles hoy</h5>
                        <ul class="list-group list-group-flush mb-3">
                            <?php foreach ($promociones_local as $promo): ?>
                                <li class="list-group-item">
                                    <a href="promocion.php?codPromo=<?= $promo['codPromo'] ?>" class="promosLocal">
                                        <?= htmlspecialchars($promo['textoPromo']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <hr>
                        <p class="text-center">No hay promociones disponibles hoy para este local.</p>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['codUsuario']) && $_SESSION['tipoUsuario'] == 'cliente'): ?>
                        <div class="mt-2 text-center">
                            <a href="consumir_promo.php?codLocal=<?= $codLocal ?>" class="btn-consumir">
                                Consumir Promoción
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>    
</div>

<?php
include 'includes/footer.php';
?>
