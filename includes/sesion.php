<?php

session_start();

function verificarSesion() {
    if(!isset($_SESSION['codUsuario'])){
        header('Location: ../login.php');
        exit();
    }
}

function verificarRol($rolPermitido) {
    if ($_SESSION['tipoUsuario'] != $rolPermitido) {
        header('Location: ../login.php');
        exit();
    }
}

?>