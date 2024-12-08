<?php
require_once("./db/conexionDB.php");

$errorMensaje = ''; 
$successMessage = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $dni = trim($_POST['dni']);
    $consulta = $_POST['consulta']; 
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $estado = "No atendido";

    if (empty($nombre) || empty($apellido) || empty($dni) || $consulta === 'Seleccione una opción' || empty($fecha) || empty($hora)) {
        $errorMensaje = 'Los campos son obligatorios.';
    } else {
        $query = "INSERT INTO pacientes (nombre, apellido, dni, consulta, fecha, hora, estado) VALUES ('$nombre', '$apellido', '$dni', '$consulta', '$fecha', '$hora', '$estado')";
        $resultado = mysqli_query($conexion, $query);

        if ($resultado) {
            $successMessage = 'Turno creado exitosamente.';
        } else {
            $errorMensaje = 'Hubo un problema al crear el turno.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turnos</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="./css/estilos.css">
</head>
<body>
    <main class="container">
      <section class="row mt-3">
        <article  class="col-md-6 col-sm-12">
          <div class="mt-5">
          <img class="w-100" src="./img/logo-turno.jpg" alt="logo">
          <h2 >¡Tu salud bucal es nuestra prioridad! Reserva tu turno hoy mismo.</h2>
          </div>
        </article>
        <article class="col-md-6 col-sm-12">
        <form class="w-100 mx-auto bg-form my-5" method="POST" action="">
            <article class="text-center">
                <h3>Turnos</h3>
              </article>
              <hr>
              <div class="mb-3">
                <label for="exampleInputNombre" class="form-label ">Nombre:</label>
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  name="nombre"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="exampleInputApellido" class="form-label">Apellido:</label>
                <input
                  type="text"
                  class="form-control"
                  id="apellido"
                  name="apellido"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="exampleInputDNI" class="form-label">DNI:</label>
                <input
                  type="number"
                  class="form-control"
                  id="dni"
                  name="dni"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="exampleInputDNI" class="form-label">Consulta:</label>
                <select class="form-select" aria-label="Default select example" name="consulta" id="consulta">
                    <option selected>Seleccione una opción</option>
                    <option value="Consulta general">Consulta general</option>
                    <option value="Limpieza dental">Limpieza dental</option>
                    <option value="Ortodoncia">Ortodoncia</option>
                    <option value="Extracción de diente">Extracción de diente</option>
                    <option value="Blanqueamiento dental">Blanqueamiento dental</option>
                    <option value="Consulta de urgencia">Consulta de urgencia</option>
                  </select>
              </div>
              <div class="mb-3">
                <label for="exampleInputFecha" class="form-label">Fecha:</label>
                <input
                  type="date"
                  class="form-control"
                  id="fecha"
                  name="fecha"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="exampleInputHora" class="form-label">Hora:</label>
                <input
                  type="time"
                  class="form-control"
                  id="hora"
                  name="hora"
                  required
                />
              </div>
              <button type="submit" class="btn bg-btn w-100 p-2">Sacar turno</button>
            </form>
        </article>
      </section>
      <?php if ($errorMensaje || $successMessage): ?>
          <script>
              document.addEventListener('DOMContentLoaded', function() {
                  let title = '';
                  let text = '';
                  let icon = '';

                  <?php if ($errorMensaje): ?>
                      title = 'Error!';
                      text = '<?php echo addslashes($errorMensaje); ?>';
                      icon = 'error';
                  <?php elseif ($successMessage): ?>
                      title = 'Éxito!';
                      text = '<?php echo addslashes($successMessage); ?>'; 
                      icon = 'success';
                  <?php endif; ?>

                  Swal.fire({
                      title: title,
                      text: text,
                      icon: icon,
                      confirmButtonText: 'Ok'
                  });
              });
          </script>
      <?php endif; ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>