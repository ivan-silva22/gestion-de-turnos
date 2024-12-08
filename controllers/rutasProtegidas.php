<?php
session_start();

function verificarAutenticacion() {
    if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
        header("Location: ../pages/loginAdmin.php");
        exit;
    }
}
?>