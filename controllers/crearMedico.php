<?php
require_once("../db/conexionDB.php");

$nombre = $_POST['nombre'];
$especialidad = $_POST['especialidad'];

$query = "INSERT INTO medicos (nombre, especialidad) VALUES ('$nombre', '$especialidad')";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    header("Location: ../pages/medicos.php?mensaje=success");
} else {
    header("Location: ../pages/medicos.php?mensaje=error");
}
exit();

?>