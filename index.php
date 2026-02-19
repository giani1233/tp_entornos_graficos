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

    $sql_locales = "SELECT * FROM locales WHERE activo = 1 AND rubroLocal != 'Gastronomia'";
    $resultado_locales = mysqli_query($conexion, $sql_locales);
    $locales = [];
    if ($resultado_locales) {
        while ($fila = mysqli_fetch_assoc($resultado_locales)) {
            $locales[] = $fila;
        }
    }

    $sql_gastronomia = "SELECT * FROM locales WHERE activo = 1 AND rubroLocal = 'Gastronomia'";
    $resultado_gastronomia = mysqli_query($conexion, $sql_gastronomia);
    $gastronomia = [];
    if ($resultado_gastronomia) {
        while ($fila = mysqli_fetch_assoc($resultado_gastronomia)) {
            $gastronomia[] = $fila;
        }
    }

    $promociones = [];
    if ($resultado) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $promociones[] = $fila;
        }
    }

    $query_servicios = "SELECT * FROM servicios";
    $resultado_servicios = mysqli_query($conexion, $query_servicios);
    $servicios = [];
    if ($resultado_servicios) {
        while ($fila = mysqli_fetch_assoc($resultado_servicios)) {
            $servicios[] = $fila;
        }
    }

    $sql_novedades = "SELECT * FROM novedades
                      WHERE (tipoUsuario = 'cliente' OR tipoUsuario IS NULL)
                      AND fechaDesdeNovedad <= CURDATE()
                      AND fechaHastaNovedad >= CURDATE()
                      ORDER BY fechaDesdeNovedad DESC";
    $resultado_novedades = mysqli_query($conexion, $sql_novedades);
    $novedades = [];
    if ($resultado_novedades) {
        while ($fila = mysqli_fetch_assoc($resultado_novedades)) {
            $novedades[] = $fila;
        }
    }
?>

<div class="contenedor-edificio">
    <img src="assets/images/edificio.svg" alt="Edificio" class="img-fluid" id="edificio">
</div>

<div class="seccion-promociones" id="ofertas">
    <h2 class="titulo-seccion-promociones mb-4 text-center">Promociones del día</h2>
    <div class="contenedor-seccion-promociones">
        <?php if (empty($promociones)): ?>
            <div class="text-center" style="opacity: 0.7;">
                <p>No hay promociones disponibles para hoy</p>
            </div>
        <?php else: ?>
            <div class="contenedor-promociones d-flex align-items-center position-relative">
                <button class="carousel-btn carousel-btn-prev btn btn-light position-absolute start-0" onclick="moverCarrusel(-1)">‹</button>
                
                <div class="carrusel-promociones d-flex overflow-auto">
                    <?php foreach ($promociones as $promo): ?>
                        <div class="tarjeta-promo flex-shrink-0 mx-2">
                            <div class="imagen-promocion">
                                <?php if (!empty($promo['imagen'])): ?>
                                    <img src="assets/images/promociones/<?php echo $promo['imagen']; ?>" 
                                        class="img-fluid" 
                                        alt="<?php echo htmlspecialchars($promo['imagen']); ?>">
                                <?php else: ?>
                                    <img src="assets/images/promociones/no-imagen.png" 
                                        class="img-fluid" 
                                        alt="Promoción sin imagen">
                                <?php endif; ?>
                            </div>
                            <div class="contenido-promo mt-2 text-center">
                                <a href="promocion.php?codPromo=<?= $promo['codPromo'] ?>" class="boton-descubrir">
                                    Descubrir más
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button class="carousel-btn carousel-btn-next btn btn-light position-absolute end-0" onclick="moverCarrusel(1)">›</button>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="separador"></div>

<div class="seccion-locales" id="locales">
    <h2 class="titulo-seccion-locales">Nuestros locales</h2>
    <div class="contenedor-seccion-locales">
        <?php if (empty($locales)): ?>
            <div class="alert alert-info text-center">
                <h4>No hay locales disponibles</h4>
            </div>
        <?php else: ?>
            <div class="grilla-locales">
                <?php foreach ($locales as $local): ?>
                    <div class="tarjeta-local">
                        <div class="imagen-local">
                            <?php if (!empty($local['imagen'])): ?>
                                <img src="assets/images/locales/<?php echo $local['imagen']; ?>" 
                                    alt="<?php echo htmlspecialchars($local['imagen']); ?>">
                            <?php else: ?>
                                <img src="assets/images/promociones/no-imagen.png" 
                                    alt="Local sin imagen">
                            <?php endif; ?>
                        </div>
                        <div class="contenido-local">
                            <a href="local.php?codLocal=<?= $local['codLocal'] ?>" class="boton-descubrir-local">
                                Descubrir más
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?> 
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="separador-2"></div>

<div class="seccion-gastronomia" id="gastronomia">
    <h2 class="titulo-seccion-gastronomia">Nuestra gastronomía</h2>
    <div class="contenedor-seccion-gastronomia">
        <?php if (empty($gastronomia)): ?>
            <div class="alert alert-info text-center">
                <h4>No hay opciones gastronómicas disponibles</h4>
            </div>
        <?php else: ?>
            <div class="grilla-gastronomia">
                <?php foreach ($gastronomia as $opcion): ?>
                    <div class="tarjeta-gastronomia">
                        <div class="imagen-gastronomia">
                            <?php if (!empty($opcion['imagen'])): ?>
                                <img src="assets/images/locales/<?php echo $opcion['imagen']; ?>" 
                                    alt="<?php echo htmlspecialchars($opcion['imagen']); ?>">
                            <?php else: ?>
                                <img src="assets/images/promociones/no-imagen.png" 
                                    alt="Local sin imagen">
                            <?php endif; ?>
                        </div>
                        <div class="contenido-gastronomia">
                            <a href="local.php?codLocal=<?= $opcion['codLocal'] ?>" class="boton-descubrir-gastronomia">
                                Descubrir más
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?> 
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="separador-3"></div>

<section class="seccion-servicios py-5" id="servicios">
    <div class="container text-center">
        <h2 class="titulo-seccion-servicios mb-5">Nuestros servicios</h2>

        <div class="row justify-content-center g-4">
            <?php foreach ($servicios as $servicio): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card tarjeta-servicio shadow-sm position-relative">
                        <div class="imagen-servicio">
                            <img 
                                src="assets/images/servicios/<?php echo $servicio['imagenServicio']; ?>" 
                                class="img-fluid" 
                                alt="<?php echo htmlspecialchars($servicio['nombreServicio']); ?>">
                        </div>

                        <div class="card-body contenido-servicio">
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($servicio['nombreServicio']); ?>
                            </h5>
                            <p class="card-text">
                                <?php echo htmlspecialchars($servicio['descripcionServicio']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<div class="separador-4"></div>

<section class="seccion-novedades" id="novedades">
    <div class="container">
        <h2 class="titulo-seccion-novedades">Novedades</h2>

        <?php if (empty($novedades)): ?>
            <div class="text-center" style="opacity: 0.7;">
                <p>No hay novedades disponibles en este momento.</p>
            </div>
        <?php else: ?>
            <div class="row g-4 justify-content-left">
                <?php foreach ($novedades as $novedad): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="tarjeta-novedad">
                            <div class="novedad-icono">📢</div>
                            <p class="novedad-texto">
                                <?php echo htmlspecialchars($novedad['textoNovedad']); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<div class="separador-5"></div>

<section class="seccion-ubicacion" id="ubicacion">
    <div class="container">
        <h2 class="titulo-seccion-ubicacion">Ubicación</h2>
        <div class="ubicacion-contenedor">
            <div class="ubicacion-mapa">
                <img src="assets/images/mapa.png" alt="Mapa de ubicación Rio Shopping">
            </div>
            <div class="ubicacion-info">
                <div class="ubicacion-bloque">
                    <div class="ubicacion-bloque-titulo">En colectivo</div>
                    <ul class="ubicacion-lista">
                        <li><strong>102</strong> | bandera negra y roja</li>
                        <li><strong>103</strong> | bandera negra y roja (Zona sur: San Martin - Corrientes - Salta)</li>
                        <li><strong>107</strong> | (Av. Pellegrini - Corrientes)</li>
                        <li><strong>113</strong> | (27 de Febrero - Cafferata - Santa Fe)</li>
                        <li><strong>143</strong> | bandera roja (por Av. Avellaneda) y bandera negra</li>
                        <li><strong>153</strong> | (Allende)</li>
                        <li><strong>35 / 9</strong> | bandera roja (Av. Rondeau) y bandera negra (Allende)</li>
                        <li><strong>Exp.</strong> | (Palladini / Baigorria) (Santa Fe - Corrientes - Cafferata / Puerto Gral. San Martin)</li>
                    </ul>
                </div>
                <div class="ubicacion-bloque">
                    <div class="ubicacion-bloque-titulo">En auto</div>
                    <p class="ubicacion-descripcion">
                        Rio Shopping está ubicado en una zona privilegiada de la ciudad de Rosario, muy cerca del río Paraná. Su emplazamiento estratégico atrae no solo a los residentes vecinos, sino a personas que viven en una extensa área de influencia, ya que posee amplias y rápidas vías de acceso.
                    </p>
                    <span class="ubicacion-direccion">
                        <strong> Ubicación: </strong> Nansen 323 — Rosario, Santa Fe
                    </span>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
