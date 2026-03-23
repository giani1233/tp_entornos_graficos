<?php

include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include 'header_admin.php';
include '../includes/conexion_db.php';

$sql = "SELECT codServicio, imagenServicio, nombreServicio, descripcionServicio
        FROM servicios
        ORDER BY nombreServicio ASC";
$resultado = mysqli_query($conexion, $sql);
$servicios = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $servicios[] = $fila;
    }
}
mysqli_close($conexion);

?>

<div class="contenedor-gestion-admin">
    <div class="cabecera-gestion-admin">
        <h1 class="titulo-gestion-admin">Gestionar Servicios</h1>
        <a href="agregar_servicio.php" class="btn-admin">Agregar Servicio</a>
    </div>
    <?php if (empty($servicios)): ?>
        <p class="sin-datos-admin">No hay servicios cargados aún.</p>
    <?php else: ?>
        <div class="tabla-wrapper-admin">
            <table class="tabla-gestion-admin">
                <thead>
                    <tr class="fila-header-admin">
                        <th>Imagen</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($servicios as $i => $servicio): ?>
                        <tr class="fila-dato-admin <?= $i % 2 == 0 ? 'fila-par-admin' : 'fila-impar-admin' ?>">
                            <td>
                                <?php if (!empty($servicio['imagenServicio'])): ?>
                                    <img src="../assets/images/servicios/<?= htmlspecialchars($servicio['imagenServicio']) ?>" alt="Servicio" class="imagen-promo-admin imagen-clickeable" onclick="abrirModal(this.src)">
                                <?php else: ?>
                                    <img src="../assets/images/promociones/no-imagen.png" alt="Sin imagen" class="imagen-promo-admin">
                                <?php endif; ?>
                            </td>
                            <td><?= $servicio['codServicio'] ?></td>
                            <td><?= htmlspecialchars($servicio['nombreServicio']) ?></td>
                            <td class="celda-info-admin" title="<?= htmlspecialchars($servicio['descripcionServicio']) ?>">
                                <?= htmlspecialchars($servicio['descripcionServicio']) ?>
                            </td>
                            <td class="celda-acciones-admin">
                                <a href="modificar_servicio.php?codServicio=<?= $servicio['codServicio'] ?>" class="btn-aceptar-admin" id="btnModificarServicio" title="Modificar">
                                    ✏️
                                </a>
                                <a href="eliminar_servicio.php?codServicio=<?= $servicio['codServicio'] ?>" class="btn-rechazar-admin" onclick="return confirm('Está seguro de que desea eliminar este servicio?')" title="Eliminar">
                                    🗑️
                                </a>
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
            <img id="imagenModal" src="" alt="Servicio" style="width:100%; border-radius:12px;">
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