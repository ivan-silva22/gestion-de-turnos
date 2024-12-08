<?php
require_once("../db/conexionDB.php");

if (isset($_GET['id'], $_POST['nombre'], $_POST['especialidad'])) {
    $id = intval($_GET['id']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $especialidad = mysqli_real_escape_string($conexion, $_POST['especialidad']);

    $consulta = "UPDATE medicos SET nombre = '$nombre', especialidad = '$especialidad' WHERE id = $id";

    $mensaje = mysqli_query($conexion, $consulta) ? "updated" : "error";
    header("Location: ../pages/medicos.php?mensaje=$mensaje");
} else {
    header("Location: ../pages/medicos.php?mensaje=error");
}
?>