<?php

include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include 'header_admin.php';
include '../includes/conexion_db.php';

$sql = "SELECT codNovedad, textoNovedad, fechaDesdeNovedad, fechaHastaNovedad, categoriaCliente
        FROM novedades
        ORDER BY fechaDesdeNovedad DESC";
$resultado = mysqli_query($conexion, $sql);
$novedades = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $novedades[] = $fila;
    }
}
mysqli_close($conexion);
?>

<div class="contenedor-gestion-admin">
    <div class="cabecera-gestion-admin">
        <h1 class="titulo-gestion-admin">Gestionar Novedades</h1>
        <a href="agregar_novedad.php" class="btn-admin">Agregar Novedad</a>
    </div>
    <?php if (empty($novedades)): ?>
        <p class="sin-datos-admin">No hay novedades cargadas aún.</p>
    <?php else: ?>
        <div class="tabla-wrapper-admin">
            <table class="tabla-gestion-admin">
                <thead>
                    <tr class="fila-header-admin">
                        <th>Código</th>
                        <th>Texto</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($novedades as $i => $novedad): ?>
                        <tr class="fila-dato-admin <?= $i % 2 == 0 ? 'fila-par-admin' : 'fila-impar-admin' ?>">
                            <td><?= $novedad['codNovedad'] ?></td>
                            <td class="celda-texto-admin" title="<?= htmlspecialchars($novedad['textoNovedad']) ?>">
                                <?= htmlspecialchars($novedad['textoNovedad']) ?>
                            </td>
                            <td><?= htmlspecialchars($novedad['fechaDesdeNovedad']) ?></td>
                            <td><?= htmlspecialchars($novedad['fechaHastaNovedad']) ?></td>
                            <td><?= htmlspecialchars($novedad['categoriaCliente']) ?></td>
                            <td class="celda-acciones-admin">
                                <a href="modificar_novedad.php?codNovedad=<?= $novedad['codNovedad'] ?>"
                                   class="btn-aceptar-admin" id="modificarNovedadBtn"
                                   title="Modificar">
                                    ✏️
                                </a>
                                <a href="eliminar_novedad.php?codNovedad=<?= $novedad['codNovedad'] ?>"
                                   class="btn-rechazar-admin"
                                   onclick="return confirm('Está seguro de que deseas eliminar esta novedad?')"
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

<?php include 'footer_admin.php'; ?>