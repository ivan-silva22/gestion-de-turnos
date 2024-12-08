<?php
require_once("../db/conexionDB.php");

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$dni = $_POST['dni'];
$consulta = $_POST['consulta'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$estado = "No atendido";

$query = "INSERT INTO pacientes (nombre, apellido, dni, consulta, fecha, hora, estado) VALUES ('$nombre', '$apellido', '$dni', '$consulta', '$fecha', '$hora', '$estado')";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    header("Location: ../pages/turnos.php?mensaje=success");
} else {
    header("Location: ../pages/turnos.php?mensaje=error");
}
exit();

?>