<?php

include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include 'header_admin.php';
include '../includes/conexion_db.php';

$sql = "SELECT l.codLocal, l.imagen, l.nombreLocal, l.informacionLocal,
               l.ubicacionLocal, l.rubroLocal,
               u.nombreUsuario, u.apellidoUsuario
        FROM locales l
        LEFT JOIN usuarios u ON l.codUsuario = u.codUsuario
        ORDER BY l.nombreLocal ASC";
$resultado = mysqli_query($conexion, $sql);
$locales = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $locales[] = $fila;
    }
}
mysqli_close($conexion);
?>

<div class="contenedor-gestion-admin">
    <div class="cabecera-gestion-admin">
        <h1 class="titulo-gestion-admin">Gestionar Locales</h1>
        <a href="agregar_local.php" class="btn-admin">Agregar Local</a>
    </div>
    <?php if (empty($locales)): ?>
        <p class="sin-datos-admin">No hay locales cargados aún.</p>
    <?php else: ?>
        <div class="tabla-wrapper-admin">
            <table class="tabla-gestion-admin">
                <thead>
                    <tr class="fila-header-admin">
                        <th>Logo</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Información</th>
                        <th>Ubicación</th>
                        <th>Rubro</th>
                        <th>Dueño</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($locales as $i => $local): ?>
                        <tr class="fila-dato-admin <?= $i % 2 == 0 ? 'fila-par-admin' : 'fila-impar-admin' ?>">
                            <td>
                                <?php if (!empty($local['imagen'])): ?>
                                    <img src="../assets/images/locales/<?= htmlspecialchars($local['imagen']) ?>"
                                         alt="Logo" class="imagen-promo-admin imagen-clickeable"
                                         onclick="abrirModal(this.src)">
                                <?php else: ?>
                                    <img src="../assets/images/promociones/no-imagen.png"
                                         alt="Sin imagen" class="imagen-promo-admin">
                                <?php endif; ?>
                            </td>
                            <td><?= $local['codLocal'] ?></td>
                            <td><?= htmlspecialchars($local['nombreLocal']) ?></td>
                            <td class="celda-info-admin"><?= htmlspecialchars($local['informacionLocal']) ?></td>
                            <td><?= htmlspecialchars($local['ubicacionLocal']) ?></td>
                            <td><?= htmlspecialchars($local['rubroLocal']) ?></td>
                            <td>
                                <?php if (!empty($local['nombreUsuario'])): ?>
                                    <?= htmlspecialchars($local['nombreUsuario'] . ' ' . $local['apellidoUsuario']) ?>
                                <?php endif; ?>
                            </td>
                            <td class="celda-acciones-admin">
                                <a href="modificar_local.php?codLocal=<?= $local['codLocal'] ?>"
                                   class="btn-aceptar-admin" id="btnModificar"
                                   title="Modificar">
                                    ✏️
                                </a>
                                <a href="procesar_eliminar_local.php?codLocal=<?= $local['codLocal'] ?>"
                                   class="btn-rechazar-admin"
                                   onclick="return confirm('Está seguro de que desea eliminar este local? Se eliminarán también sus promociones.')"
                                   title="Eliminar">
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
            <img id="imagenModal" src="" alt="Local" style="width:100%; border-radius:12px;">
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