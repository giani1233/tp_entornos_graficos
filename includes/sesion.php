<?php

session_start();

function verificarSesion() {
    if(!isset($_SESSION['codUsuario'])){
        header('Location: ../index.php');
        exit();
    }
}

function verificarRol($rolPermitido) {
    if ($_SESSION['tipoUsuario'] != $rolPermitido) {
        header('Location: ../index.php');
        exit();
    }
}

?>