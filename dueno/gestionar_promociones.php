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

$sql = "SELECT codPromo, imagen, textoPromo, fechaDesdePromo, fechaHastaPromo, categoriaCliente, diasSemana, estadoPromo
        FROM promociones
        WHERE codLocal = $codLocal
        ORDER BY fechaDesdePromo DESC";
$resultado = mysqli_query($conexion, $sql);
$promociones = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $promociones[] = $fila;
    }
}
mysqli_close($conexion);
?>

<div class="contenedor-gestion">
    <div class="cabecera-gestion">
        <h1 class="titulo-gestion">Gestionar Promociones</h1>
        <a href="agregar_promocion.php" class="btn-dueno">Agregar Promoción</a>
    </div>
    <?php if (empty($promociones)): ?>
        <p class="sin-datos">No hay promociones cargadas aún.</p>
    <?php else: ?>
        <div class="tabla-wrapper">
            <table class="tabla-gestion">
                <thead>
                    <tr class="fila-header">
                        <th>Imagen</th>
                        <th>Código</th>
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
                        <tr class="fila-dato <?= $i % 2 == 0 ? 'fila-par' : 'fila-impar' ?>">
                            <td class="celda-imagen">
                                <?php if (!empty($promo['imagen'])): ?>
                                    <img src="../assets/images/promociones/<?= htmlspecialchars($promo['imagen']) ?>"
                                        alt="Promo" class="imagen-promo">
                                <?php else: ?>
                                    <img src="../assets/images/promociones/no-imagen.png"
                                        alt="Sin imagen" class="imagen-promo">
                                <?php endif; ?>
                            </td>
                            <td><?= $promo['codPromo'] ?></td>
                            <td class="celda-texto"><?= htmlspecialchars($promo['textoPromo']) ?></td>
                            <td><?= htmlspecialchars($promo['fechaDesdePromo']) ?></td>
                            <td><?= htmlspecialchars($promo['fechaHastaPromo']) ?></td>
                            <td><?= htmlspecialchars($promo['categoriaCliente']) ?></td>
                            <td class="celda-dias">
                                <?php
                                    $dias = json_decode($promo['diasSemana'], true);
                                    $abreviaciones = ['Lunes'=>'L','Martes'=>'Ma','Miercoles'=>'Mi',
                                              'Jueves'=>'J','Viernes'=>'V','Sabado'=>'S','Domingo'=>'D'];
                                    $resultado_dias = [];
                                    foreach ($dias as $d) {
                                        $resultado_dias[] = $abreviaciones[$d] ?? $d;
                                    }
                                    echo implode("\n", $resultado_dias);
                                ?>
                            </td>
                            <td>
                                <span class="badge badge-<?= strtolower($promo['estadoPromo']) ?>">
                                    <?= htmlspecialchars($promo['estadoPromo']) ?>
                                </span>
                            </td>
                            <td class="celda-acciones">
                                <a href="eliminar_promocion.php?codPromo=<?= $promo['codPromo'] ?>"
                                   class="btn-eliminar"
                                   onclick="return confirm('Está seguro de que desea eliminar esta promoción?')">
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

<?php include 'footer_dueno.php'; ?>