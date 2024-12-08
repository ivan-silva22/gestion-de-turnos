<?php
require_once("../db/conexionDB.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $query = "DELETE FROM pacientes WHERE id = $id";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        header("Location: ../pages/turnos.php?mensaje=deleted");
    } else {
        header("Location: ../pages/turnos.php?mensaje=error");
    }
    exit;
}
?>