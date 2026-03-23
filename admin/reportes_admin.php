<?php

include '../includes/sesion.php';
verificarSesion();
verificarRol('admin');

include 'header_admin.php';
include '../includes/conexion_db.php';

$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'cantidad';

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$filtroBusqueda = '';
if (!empty($busqueda)) {
    $busquedaEscapada = mysqli_real_escape_string($conexion, $busqueda);
    $filtroBusqueda = "HAVING l.nombreLocal LIKE '%$busquedaEscapada%'";
}

switch ($filtro) {
    case 'consumidas':
        $orderBy = 'cuponesCanjeados DESC';
        break;
    case 'sin_consumir':
        $orderBy = 'promosSinUso DESC';
        break;
    default: 
        $orderBy = 'totalPromociones DESC';
        break;
}

$sql = "SELECT l.codLocal, l.nombreLocal, COUNT(DISTINCT p.codPromo) AS totalPromociones, COUNT(up.codUso) AS cuponesCanjeados, (
                                                                                                                                    SELECT COUNT(*) FROM promociones p2
                                                                                                                                    WHERE p2.codLocal = l.codLocal
                                                                                                                                    AND (SELECT COUNT(*) FROM uso_promociones up2 WHERE up2.codPromo = p2.codPromo) = 0
                                                                                                                                ) AS promosSinUso
        FROM locales l
        LEFT JOIN promociones p ON l.codLocal = p.codLocal
        LEFT JOIN uso_promociones up ON p.codPromo = up.codPromo
        GROUP BY l.codLocal, l.nombreLocal
        $filtroBusqueda
        ORDER BY $orderBy";

$resultado = mysqli_query($conexion, $sql);
$reportes = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $reportes[] = $fila;
    }
}
mysqli_close($conexion);

?>

<div class="contenedor-gestion-admin">
    <div class="cabecera-gestion-admin">
        <h1 class="titulo-gestion-admin">Reportes</h1>
    </div>
    <div class="barra-reportes-admin">
        <form method="GET" action="reportes_admin.php" class="form-busqueda-reporte-admin">
            <input type="hidden" name="filtro" value="<?= htmlspecialchars($filtro) ?>">
            <input type="text" name="busqueda" class="input-busqueda-reporte-admin" placeholder="Buscar local..." value="<?= htmlspecialchars($busqueda) ?>">
            <button type="submit" class="btn-admin">Buscar</button>
        </form>
        <div class="filtros-admin">
            <a href="reportes_admin.php?filtro=cantidad&busqueda=<?= urlencode($busqueda) ?>" class="btn-filtro-admin <?= $filtro == 'cantidad' ? 'btn-filtro-activo' : '' ?>">
                Por cantidad
            </a>
            <a href="reportes_admin.php?filtro=consumidas&busqueda=<?= urlencode($busqueda) ?>" class="btn-filtro-admin <?= $filtro == 'consumidas' ? 'btn-filtro-activo' : '' ?>">
                Por consumidas
            </a>
            <a href="reportes_admin.php?filtro=sin_consumir&busqueda=<?= urlencode($busqueda) ?>" class="btn-filtro-admin <?= $filtro == 'sin_consumir' ? 'btn-filtro-activo' : '' ?>">
                Sin consumir
            </a>
        </div>
    </div>
    <?php if (empty($reportes)): ?>
        <p class="sin-datos-admin">No hay locales que coincidan con la búsqueda.</p>
    <?php else: ?>
        <div class="tabla-wrapper-admin">
            <table class="tabla-gestion-admin">
                <thead>
                    <tr class="fila-header-admin">
                        <th>Local</th>
                        <th>Historial de promociones</th>
                        <th>Cupones canjeados</th>
                        <th>Promociones sin uso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reportes as $i => $reporte): ?>
                        <tr class="fila-dato-admin <?= $i % 2 == 0 ? 'fila-par-admin' : 'fila-impar-admin' ?>">
                            <td><?= htmlspecialchars($reporte['nombreLocal']) ?></td>
                            <td><?= $reporte['totalPromociones'] ?></td>
                            <td><?= $reporte['cuponesCanjeados'] ?></td>
                            <td><?= $reporte['promosSinUso'] ?? 0 ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer_admin.php'; ?>