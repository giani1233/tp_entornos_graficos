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

<div class="contenedor-pagina-promocion">
    <div class="contenedor-contenido-promocion">
        <div class="contenedor-imagen-promocion">
            <?php if(!empty($promo['imagen'])): ?>
                <img src="assets/images/promociones/<?php echo $promo['imagen']; ?>" alt="<?php echo htmlspecialchars($promo['imagen']); ?>">
                <?php else: ?>
                <img src="assets/images/promociones/no-imagen.png" alt="Promoción sin imagen">
            <?php endif; ?>
        </div>
        <div class="contenedor-detalles-promocion">
            <p><strong>Local:</strong> <?php echo htmlspecialchars($promo['nombreLocal']); ?></p>
            <p><strong>Desde:</strong> <?php echo htmlspecialchars($promo['fechaDesdePromo']); ?></p>
            <p><strong>Hasta:</strong> <?php echo htmlspecialchars($promo['fechaHastaPromo']); ?></p>
            <p><strong>Promo:</strong> <?php echo htmlspecialchars($promo['textoPromo']); ?></p>
        </div>
    </div>    
</div>

<?php
include 'includes/footer.php';
?>