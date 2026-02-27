<?php

include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include 'header_admin.php';
include '../includes/conexion_db.php';

$sql = "SELECT p.codPromo, p.imagen, p.textoPromo, p.fechaDesdePromo, p.fechaHastaPromo,
               p.categoriaCliente, p.diasSemana, p.estadoPromo, l.nombreLocal
        FROM promociones p
        JOIN locales l ON p.codLocal = l.codLocal
        ORDER BY p.estadoPromo ASC, p.fechaDesdePromo DESC";
$resultado = mysqli_query($conexion, $sql);
$promociones = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $promociones[] = $fila;
    }
}
mysqli_close($conexion);
?>

<div class="contenedor-gestion-admin">
    <div class="cabecera-gestion-admin">
        <h1 class="titulo-gestion-admin">Gestionar Promociones</h1>
    </div>
    <?php if (isset($_GET['actualizado'])): ?>
        <div class="alert alert-success">Estado de la promoción actualizado correctamente.</div>
    <?php endif; ?>
    <?php if (empty($promociones)): ?>
        <p class="sin-datos-admin">No hay promociones cargadas aún.</p>
    <?php else: ?>
        <div class="tabla-wrapper-admin">
            <table class="tabla-gestion-admin">
                <thead>
                    <tr class="fila-header-admin">
                        <th>Imagen</th>
                        <th>Código</th>
                        <th>Local</th>
                        <th>Texto</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Categoría</th>
                        <th>Días</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($promociones as $i => $promo): ?>
                        <tr class="fila-dato-admin <?= $i % 2 == 0 ? 'fila-par-admin' : 'fila-impar-admin' ?>">
                            <td>
                                <?php if (!empty($promo['imagen'])): ?>
                                    <img src="../assets/images/promociones/<?= htmlspecialchars($promo['imagen']) ?>"
                                        alt="Promo" class="imagen-promo-admin imagen-clickeable"
                                        onclick="abrirModal(this.src)">
                                <?php else: ?>
                                    <img src="../assets/images/promociones/no-imagen.png"
                                        alt="Sin imagen" class="imagen-promo-admin">
                                <?php endif; ?>
                            </td>
                            <td><?= $promo['codPromo'] ?></td>
                            <td><?= htmlspecialchars($promo['nombreLocal']) ?></td>
                            <td class="celda-texto-admin"><?= htmlspecialchars($promo['textoPromo']) ?></td>
                            <td><?= htmlspecialchars($promo['fechaDesdePromo']) ?></td>
                            <td><?= htmlspecialchars($promo['fechaHastaPromo']) ?></td>
                            <td><?= htmlspecialchars($promo['categoriaCliente']) ?></td>
                            <td class="celda-dias-admin">
                                <?php
                                    $dias = json_decode($promo['diasSemana'], true);
                                    $abrevs = ['Lunes'=>'L','Martes'=>'Ma','Miercoles'=>'Mi',
                                               'Jueves'=>'J','Viernes'=>'V','Sabado'=>'S','Domingo'=>'D'];
                                    $resultado_dias = [];
                                    foreach ($dias as $d) {
                                        $resultado_dias[] = $abrevs[$d] ?? $d;
                                    }
                                    echo implode("\n", $resultado_dias);
                                ?>
                            </td>
                            <td>
                                <span class="badge badge-admin-<?= strtolower($promo['estadoPromo']) ?>">
                                    <?= htmlspecialchars($promo['estadoPromo']) ?>
                                </span>
                            </td>
                            <td class="celda-acciones-admin">
                                <?php if ($promo['estadoPromo'] == 'Pendiente'): ?>
                                    <a href="procesar_gestion_promocion.php?codPromo=<?= $promo['codPromo'] ?>&estado=Aprobada"
                                       class="btn-aceptar-admin"
                                       onclick="return confirm('Está seguro de que desea aprobar esta promoción?')">
                                        ✅
                                    </a>
                                    <a href="procesar_gestion_promocion.php?codPromo=<?= $promo['codPromo'] ?>&estado=Denegada"
                                       class="btn-rechazar-admin"
                                       onclick="return confirm('Está seguro de que desea rechazar esta promoción?')">
                                        ❌
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>
<div class="modal fade" id="modalImagen" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:transparent; border:none;">
            <img id="imagenModal" src="" alt="Promoción" style="width:100%; border-radius:12px;">
        </div>
    </div>
</div>

<script>
function abrirModal(src) {
    document.getElementById('imagenModal').src = src;
    new bootstrap.Modal(document.getElementById('modalImagen')).show();
}
</script>

<?php include 'footer_admin.php'; ?>