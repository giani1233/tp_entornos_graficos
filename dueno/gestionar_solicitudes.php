<?php
include '../includes/sesion.php';
verificarSesion();
verificarRol('dueño');

include 'header_dueno.php';
include '../includes/conexion_db.php';

$codUsuario = $_SESSION['codUsuario'];

$sql_local = "SELECT codLocal FROM locales WHERE codUsuario = $codUsuario";
$resultado_local = mysqli_query($conexion, $sql_local);
$local = mysqli_fetch_assoc($resultado_local);
$codLocal = $local['codLocal'];

$sql = "SELECT up.codUso, up.fechaUsoPromo, up.estadoUsoPromo,
               p.textoPromo,
               u.nombreUsuario, u.apellidoUsuario
        FROM uso_promociones up
        JOIN promociones p ON up.codPromo = p.codPromo
        JOIN usuarios u ON up.codCliente = u.codUsuario
        WHERE p.codLocal = $codLocal
        ORDER BY up.fechaUsoPromo DESC";
$resultado = mysqli_query($conexion, $sql);
$solicitudes = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $solicitudes[] = $fila;
    }
}
mysqli_close($conexion);
?>

<div class="contenedor-gestion">
    <div class="cabecera-gestion">
        <h1 class="titulo-gestion">Gestionar Solicitudes</h1>
    </div>
    <?php if (empty($solicitudes)): ?>
        <p class="sin-datos">No hay solicitudes registradas aún.</p>
    <?php else: ?>
        <div class="tabla-wrapper">
            <table class="tabla-gestion">
                <thead>
                    <tr class="fila-header">
                        <th>Promoción</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($solicitudes as $i => $sol): ?>
                        <tr class="fila-dato <?= $i % 2 == 0 ? 'fila-par' : 'fila-impar' ?>">
                            <td class="celda-texto"><?= htmlspecialchars($sol['textoPromo']) ?></td>
                            <td><?= htmlspecialchars($sol['nombreUsuario'] . ' ' . $sol['apellidoUsuario']) ?></td>
                            <td><?= htmlspecialchars($sol['fechaUsoPromo']) ?></td>
                            <td>
                                <span class="badge badge-<?= strtolower($sol['estadoUsoPromo']) ?>">
                                    <?= htmlspecialchars($sol['estadoUsoPromo']) ?>
                                </span>
                            </td>
                            <td class="celda-acciones">
                                <?php if ($sol['estadoUsoPromo'] == 'Enviada'): ?>
                                    <a href="actualizar_solicitud.php?codUso=<?= $sol['codUso'] ?>&estado=Aceptada"
                                       class="btn-aceptar"
                                       onclick="return confirm('Está seguro de que desea aceptar esta solicitud?')">
                                        ✅
                                    </a>
                                    <a href="actualizar_solicitud.php?codUso=<?= $sol['codUso'] ?>&estado=Rechazada"
                                       class="btn-eliminar"
                                       onclick="return confirm('Está seguro de que desea rechazar esta solicitud?')">
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

<?php include 'footer_dueno.php'; ?>