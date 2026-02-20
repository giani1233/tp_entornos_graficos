<?php 
$bodyClass = 'pagina-promocion';
include 'includes/header_visitante.php';
include 'includes/conexion_db.php';

if(!isset($_GET['codPromo']) || !is_numeric($_GET['codPromo'])) {
    echo "<h2>Código de promoción inválido.</h2>";
    include 'includes/footer.php';
    exit;
}

$codPromo = intval($_GET['codPromo']);

$sql = "SELECT p.*, l.nombreLocal
        FROM promociones p
        JOIN locales l ON p.codLocal = l.codLocal
        WHERE p.codPromo = $codPromo";

$resultado = mysqli_query($conexion, $sql);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    echo "<h2>Promoción no encontrada.</h2>";
    include 'includes/footer.php';
    exit;
}

$promo = mysqli_fetch_assoc($resultado);
?>

<div class="container my-5">
    <div class="card shadow-sm">
        <div class="row g-0">
            <div class="col-md-5 text-center">
                <?php if(!empty($promo['imagen'])): ?>
                    <img src="assets/images/promociones/<?php echo $promo['imagen']; ?>" 
                        class="img-fluid rounded-start" 
                        alt="<?php echo htmlspecialchars($promo['textoPromo']); ?>">
                <?php else: ?>
                    <img src="assets/images/promociones/no-imagen.png" 
                        class="img-fluid rounded-start" 
                        alt="Promoción sin imagen">
                <?php endif; ?>
            </div>
            <div class="col-md-7">
                <div class="card-body">
                    <h3 class="card-title mb-3"><?php echo htmlspecialchars($promo['nombreLocal']); ?></h3>
                    <p class="card-text"><strong>Desde:</strong> <?php echo htmlspecialchars($promo['fechaDesdePromo']); ?></p>
                    <p class="card-text"><strong>Hasta:</strong> <?php echo htmlspecialchars($promo['fechaHastaPromo']); ?></p>
                    <p class="card-text"><strong>Promoción:</strong> <?php echo htmlspecialchars($promo['textoPromo']); ?></p>
                </div>
                <?php if (isset($_SESSION['codUsuario']) && $_SESSION['tipoUsuario'] == 'cliente'): ?>
                    <div class="mt-4">
                        <a href="consumir_promo.php?codLocal=<?= $promo['codLocal'] ?>&codPromo=<?= $promo['codPromo'] ?>" 
                        class="btn-consumir">
                            Consumir Promoción
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>    
</div>

<?php
include 'includes/footer.php';
?>
