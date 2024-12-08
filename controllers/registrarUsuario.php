<?php
    session_start();
    require_once '../db/conexionDB.php';

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rol = "Administrador";

    if (empty($nombre) || empty($email) || empty($password)) {
        $_SESSION['error_message'] = 'Todos los campos son obligatorios.';
        header("Location: ../pages/registro.php");
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO usuarios (nombre, email, password, rol) VALUES ('$nombre', '$email', '$hashed_password', '$rol')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $_SESSION['logueado'] = true;
        $_SESSION['nombre_usuario'] = $nombre;
        header("Location: ../pages/panelAdmin.php?mensaje=success");
        exit;
    } else {
        $_SESSION['error_message'] = 'Error al crear el usuario: ' . mysqli_error($conexion);
        header("Location: ../pages/registro.php?mensaje=error");
    }
    exit();


?>