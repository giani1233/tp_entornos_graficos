<?php 

    include 'includes/header_visitante.php';

    session_start();
    include 'includes/conexion_db.php';

    $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    $diaActual = $diasSemana[date('N') - 1];

    if (isset($_SESSION['codUsuario']) && $_SESSION['tipoUsuario'] == 'cliente') {
        $categoriaCliente = $_SESSION['categoriaCliente'];
        $sql = "SELECT p.*, l.nombreLocal
                FROM promociones p
                JOIN locales l On p.codLocal = l.codLocal
                WHERE p.estadoPromo = 'Aprobada'
                AND p.fechaDesdePromo <= CURDATE()
                AND p.fechaHastaPromo >= CURDATE()
                AND JSON_CONTAINS(p.diasSemana, '\"$diaActual\"')
                AND (
                    p.categoriaCliente = 'Inicial'
                    OR p.categoriaCliente = 'Medium' and ? IN ('Medium', 'Premium')
                    OR p.categoriaCliente = 'Premium' and ? = 'Premium'
                )
                ORDER BY p.fechaDesdePromo DESC";
    $resultado = mysqli_query($conexion, $sql);
    
    } else {
        $sql = "SELECT p.*, l.nombreLocal
                FROM promociones p
                JOIN locales l On p.codLocal = l.codLocal
                WHERE p.estadoPromo = 'Aprobada'
                AND p.fechaDesdePromo <= CURDATE()
                AND p.fechaHastaPromo >= CURDATE()
                AND JSON_CONTAINS(p.diasSemana, '\"$diaActual\"')
                ORDER BY p.fechaDesdePromo DESC";
        $resultado = mysqli_query($conexion, $sql);
    } 

    $promociones = [];
    if ($resultado) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $promociones[] = $fila;
        }
    }
    
?>

<div class="contenedor-edificio">
    <img src="assets/images/edificio.svg" alt="Edificio" class="img-fluid" id="edificio">
</div>

<div class="seccion-promociones">
    <h2 class="titulo-seccion-promociones">Promociones del día</h2>
    <div class="contenedor-seccion-promociones">
        <?php if(empty($promociones)): ?>
            <div class="alert alert-info text-center">
                <h4>No hay promociones disponibles para hoy</h4>
            </div>
        <?php else: ?>
            <div class="contenedor-promociones">
                <button class="carousel-btn carousel-btn-prev" onclick="moverCarrusel(-1)">
                    ‹
                </button>
                <div class="carrusel-promociones">
                    <?php foreach($promociones as $promo): 
                        $dias_semana_promo = json_decode($promo['diasSemana'] ?? '[]', true);
                    ?>
                    <div class="tarjeta-promo">
                        <div class="imagen-promocion">
                            <?php if(!empty($promo['imagen'])): ?>
                                <img src="assets/images/promociones/<?php echo $promo['imagen']; ?>" 
                                    alt="<?php echo htmlspecialchars($promo['textoPromo']); ?>">
                            <?php else: ?>
                                <img src="assets/images/promociones/no-imagen.png" 
                                    alt="Promoción sin imagen">
                            <?php endif; ?>
                        </div>
                        <div class="contenido-promo">
                            <button class="boton-descubrir">
                                Descubrir más
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-btn carousel-btn-next" onclick="moverCarrusel(1)">
                    ›
                </button>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
    include 'includes/footer.php';
?>