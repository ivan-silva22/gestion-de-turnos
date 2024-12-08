<?php
require_once("../db/conexionDB.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $consulta = "UPDATE pacientes SET estado = 'Atendido' WHERE id = $id";

    if (mysqli_query($conexion, $consulta)) {
        header("Location: ../pages/turnos.php?mensaje=success");
    } else {
        header("Location: ../pages/turnos.php?mensaje=error");
    }

}
mysqli_close($conexion);
?>