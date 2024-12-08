<?php
    require_once("../db/conexionDB.php");
    session_start();

    $email = $_POST["email"];
    $password = $_POST["password"];
    

    $consultaUsuarios = "SELECT nombre, email, password FROM usuarios WHERE email = '$email'";

    $resultado = mysqli_query($conexion, $consultaUsuarios);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['logueado'] = true;
            $_SESSION['nombre_usuario'] = $usuario['nombre'];
            header("location:../pages/panelAdmin.php");
            exit;
        } else {
            $_SESSION['error_message'] = "Email o contraseña incorrectos";
            header("Location: ../pages/loginAdmin.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Email o contraseña incorrectos";
        header("Location: ../pages/loginAdmin.php");
        exit;
    }

?>