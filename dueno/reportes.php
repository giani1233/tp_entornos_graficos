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

$orden = isset($_GET['orden']) && $_GET['orden'] == 'ASC' ? 'ASC' : 'DESC';
$ordenInverso = $orden == 'DESC' ? 'ASC' : 'DESC';

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$filtroBusqueda = '';
if (!empty($busqueda)) {
    $busquedaEscapada = mysqli_real_escape_string($conexion, $busqueda);
    $filtroBusqueda = "AND p.textoPromo LIKE '%$busquedaEscapada%'";
}

$sql = "SELECT p.codPromo, p.textoPromo, COUNT(up.codUso) AS totalUsos
        FROM promociones p
        LEFT JOIN uso_promociones up ON p.codPromo = up.codPromo
        WHERE p.codLocal = $codLocal
        $filtroBusqueda
        GROUP BY p.codPromo, p.textoPromo
        ORDER BY totalUsos $orden";

$resultado = mysqli_query($conexion, $sql);
$reportes = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $reportes[] = $fila;
    }
}
mysqli_close($conexion);
?>

<div class="contenedor-gestion">
    <div class="cabecera-gestion">
        <h1 class="titulo-gestion">Reportes</h1>
    </div>
    <div class="barra-reportes">
        <form method="GET" action="reportes.php" class="form-busqueda-reporte">
            <input type="hidden" name="orden" value="<?= $orden ?>">
            <input type="text"
                   name="busqueda"
                   class="input-busqueda-reporte"
                   placeholder="Buscar promoción..."
                   value="<?= htmlspecialchars($busqueda) ?>">
            <button type="submit" class="btn-dueno">Buscar</button>
        </form>
        <a href="reportes.php?orden=<?= $ordenInverso ?>&busqueda=<?= urlencode($busqueda) ?>"
           class="btn-orden">
            Usos:  <?= $orden == 'DESC' ? ' ↑ Asc' : ' ↓ Desc' ?>
        </a>
    </div>
    <?php if (empty($reportes)): ?>
        <p class="sin-datos">No hay promociones que coincidan con la búsqueda.</p>
    <?php else: ?>
        <div class="tabla-wrapper">
            <table class="tabla-gestion">
                <thead>
                    <tr class="fila-header">
                        <th>Promoción</th>
                        <th>Usos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reportes as $i => $reporte): ?>
                        <tr class="fila-dato <?= $i % 2 == 0 ? 'fila-par' : 'fila-impar' ?>">
                            <td class="celda-texto"><?= htmlspecialchars($reporte['textoPromo']) ?></td>
                            <td><?= $reporte['totalUsos'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer_dueno.php'; ?>