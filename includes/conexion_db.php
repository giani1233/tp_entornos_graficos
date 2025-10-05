<?php

$host = 'localhost';
$usuario = 'root';
$password = '1234';
$base_de_datos = 'shopping_entornos';

$conexion = mysqli_connect($host, $usuario, $password);

if (!$conexion) {
    die('Error de conexión: ' . mysqli_connect_error());
}

mysqli_select_db($conexion, $base_de_datos);

?>