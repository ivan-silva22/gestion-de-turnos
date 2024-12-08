<?php
require_once("../db/conexionDB.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $query = "DELETE FROM medicos WHERE id = $id";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        header("Location: ../pages/medicos.php?mensaje=deleted");
    } else {
        header("Location: ../pages/medicos.php?mensaje=error");
    }
    exit;
}
?>