<?php

include 'includes/header_visitante.php';
include 'includes/conexion_db.php';

$codCliente = $_SESSION['codUsuario'];

$sql = "SELECT up.codUso, up.fechaUsoPromo, up.estadoUsoPromo, p.textoPromo, p.imagen
        FROM uso_promociones up
        JOIN promociones p ON up.codPromo = p.codPromo
        WHERE up.codCliente = $codCliente
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

<div class="contenedor-mis-solicitudes">
    <h1 class="titulo-mis-solicitudes">Mis Solicitudes</h1>
    <?php if (empty($solicitudes)): ?>
        <p class="sin-datos-cliente">Todavía no realizaste ninguna solicitud.</p>
    <?php else: ?>
        <div class="tabla-wrapper-cliente">
            <table class="tabla-cliente">
                <thead>
                    <tr class="fila-header-cliente">
                        <th>Imagen</th>
                        <th>Promoción</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($solicitudes as $i => $sol): ?>
                        <tr class="fila-dato-cliente <?= $i % 2 == 0 ? 'fila-par-cliente' : 'fila-impar-cliente' ?>">
                            <td>
                                <?php if (!empty($sol['imagen'])): ?>
                                    <img src="assets/images/promociones/<?= htmlspecialchars($sol['imagen']) ?>" alt="Promo" class="imagen-solicitud">
                                <?php else: ?>
                                    <img src="assets/images/promociones/no-imagen.png" alt="Sin imagen" class="imagen-solicitud">
                                <?php endif; ?>
                            </td>
                            <td class="celda-texto-cliente"><?= htmlspecialchars($sol['textoPromo']) ?></td>
                            <td><?= htmlspecialchars($sol['fechaUsoPromo']) ?></td>
                            <td>
                                <span class="badge badge-cliente-<?= strtolower($sol['estadoUsoPromo']) ?>">
                                    <?= htmlspecialchars($sol['estadoUsoPromo']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>