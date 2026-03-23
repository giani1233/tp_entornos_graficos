<?php

include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include 'header_admin.php';
include '../includes/conexion_db.php';

$sql = "SELECT u.codUsuario, u.nombreUsuario, u.apellidoUsuario, u.emailUsuario, u.estadoUsuario, u.codLocalSeleccionado, l.nombreLocal
        FROM usuarios u
        LEFT JOIN locales l ON u.codLocalSeleccionado = l.codLocal
        WHERE u.tipoUsuario = 'dueño'
        ORDER BY u.estadoUsuario ASC, u.nombreUsuario ASC";
$resultado = mysqli_query($conexion, $sql);
$duenos = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $duenos[] = $fila;
    }
}
mysqli_close($conexion);

?>

<div class="contenedor-gestion-admin">
    <div class="cabecera-gestion-admin">
        <h1 class="titulo-gestion-admin">Gestionar Dueños</h1>
    </div>
    <?php if (empty($duenos)): ?>
        <p class="sin-datos-admin">No hay dueños registrados aún.</p>
    <?php else: ?>
        <div class="tabla-wrapper-admin">
            <table class="tabla-gestion-admin">
                <thead>
                    <tr class="fila-header-admin">
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Local Solicitado</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($duenos as $i => $dueno): ?>
                        <tr class="fila-dato-admin <?= $i % 2 == 0 ? 'fila-par-admin' : 'fila-impar-admin' ?>">
                            <td><?= $dueno['codUsuario'] ?></td>
                            <td><?= htmlspecialchars($dueno['nombreUsuario'] . ' ' . $dueno['apellidoUsuario']) ?></td>
                            <td><?= htmlspecialchars($dueno['emailUsuario']) ?></td>
                            <td>
                                <?php if (!empty($dueno['nombreLocal'])): ?>
                                    <?= htmlspecialchars($dueno['nombreLocal']) ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge badge-admin-<?= strtolower($dueno['estadoUsuario']) ?>">
                                    <?= htmlspecialchars($dueno['estadoUsuario']) ?>
                                </span>
                            </td>
                            <td class="celda-acciones-admin">
                                <?php if ($dueno['estadoUsuario'] == 'Pendiente'): ?>
                                    <a href="actualizar_dueno.php?codUsuario=<?= $dueno['codUsuario'] ?>&accion=aceptar" class="btn-aceptar-admin" onclick="return confirm('Está seguro de que desea aceptar a este dueño y asignarle el local solicitado?')" title="Aceptar">
                                        ✅
                                    </a>
                                    <a href="actualizar_dueno.php?codUsuario=<?= $dueno['codUsuario'] ?>&accion=rechazar" class="btn-rechazar-admin" onclick="return confirm('Está seguro de que desea rechazar y eliminar a este usuario?')" title="Rechazar">
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

<?php include 'footer_admin.php'; ?>