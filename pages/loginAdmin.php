<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Iniciar Sesion</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../css/estilos.css">
  </head>
  <body>
  <div class="container">
  <div class="row mt-3">
    <div class="col-md-6">
    <img class="img-login w-75" src="../img/login.jpg" alt="login">
    </div>
    <div class="col-md-6">
    <section class="container my-5">
    <form class="w-100 mx-auto bg-form" method="post" action="../controllers/controllers.php">
    <article class="text-center">
        <h3>Iniciar sesión</h3>
        <h5 class="text-secondary">(Panel administrador)</h5>
      </article>
      <hr>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label ">Email:</label>
        <input
          type="email"
          class="form-control"
          id="email"
          name="email"
          required
        />
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Contraseña:</label>
        <input
          type="password"
          class="form-control"
          id="password"
          name="password"
          required
        />
      </div>
      <?php
        if (isset($_SESSION['error_message'])) {
          echo "<div class='alert alert-danger mt-2'>" . $_SESSION['error_message'] . "</div>";
          unset($_SESSION['error_message']);
      }
      ?>
       <button type="submit" class="btn bg-btn" name="btn-login">Iniciar sesion</button>
       <div class="mt-4">
       <span class="ms-5">¿Todavia no tienes cuenta? <a href="./registro.php">Registrarse</a></span>
       </div>
    </form>
   
   </section>
    </div>
    
  </div>
</div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
