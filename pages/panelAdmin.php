<?php
require_once("../controllers/rutasProtegidas.php");
verificarAutenticacion();
require_once("../db/conexionDB.php"); 


$queryMedicos = "SELECT COUNT(*) as total_medicos FROM medicos";
$resultMedicos = mysqli_query($conexion, $queryMedicos);
$medicos = mysqli_fetch_assoc($resultMedicos)['total_medicos'];


$hoy = date('Y-m-d');
$queryTurnosHoy = "SELECT COUNT(*) as total_turnos_hoy FROM pacientes WHERE fecha = '$hoy'";
$resultTurnosHoy = mysqli_query($conexion, $queryTurnosHoy);
$turnosHoy = mysqli_fetch_assoc($resultTurnosHoy)['total_turnos_hoy'];


$queryProximosTurnos = "SELECT nombre, hora FROM pacientes WHERE fecha > CURDATE() ORDER BY fecha ASC LIMIT 3"; 
$resultadoProximosTurnos = mysqli_query($conexion, $queryProximosTurnos);
$proximosTurnos = [];
while ($row = mysqli_fetch_assoc($resultadoProximosTurnos)) {
    $proximosTurnos[] = $row;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro odontologico</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-nav">
            <div class="container">
              <h5 class="color-texto" href="#">Bienvenido <span class="active"> <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></span></h5>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active color-texto" aria-current="./panelAdmin.php" href="#">Inicio</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link color-texto" href="./medicos.php">Medicos</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link color-texto" href="./turnos.php">Turnos</a>
                  </li>
                  <li class="nav-item">
                    <a href="../controllers/cerrarSesion.php" class="btn  color-texto">Cerrar sesión</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
    </header>
    <main class="container my-4">
      <section class="text-center">
        <h1>Panel de Administración</h1>
        <hr>
      </section>
      <section class="row">
        <article class="col-md-4">
          <div class="card text-center h-100">
            <div class="card-body">
              <h5 class="card-title">Medicos registrados</h5>
              <h2 class="card-text"><?php echo $medicos; ?></h2>
              <a href="medicos.php" class="btn btn-success">Ver Médicos</a>
            </div>
          </div>
        </article>
        <article class="col-md-4">
          <div class="card text-center h-100">
            <div class="card-body">
              <h5 class="card-title">Turnos para Hoy</h5>
              <h2 class="card-text"><?php echo $turnosHoy; ?></h2>
              <a href="turnos.php" class="btn btn-success">Ver Turnos</a>
            </div>
          </div>
        </article>
        <article class="col-md-4">
          <div class="card text-center h-100">
            <div class="card-body">
              <h5 class="card-title">Próximos Turnos</h5>
                <ul class="list-unstyled">
                <?php foreach ($proximosTurnos as $turno): ?>
                      <li>Nombre: <?php echo htmlspecialchars($turno['nombre']) . ' - Hora ' . htmlspecialchars($turno['hora']); ?></li>
                  <?php endforeach; ?>
                </ul>
              <a href="turnos.php" class="btn btn-success">Ver Turnos</a>
            </div>
          </div>
        </article>
      </section>
      <section class="mt-5">
      <h2>Actividad Reciente</h2>
            <ul class="list-group">
                <li class="list-group-item">Turno agendado para el paciente Juan Pérez a las 10:00 AM</li>
                <li class="list-group-item">Dr. Carlos Fernandez añadido al sistema</li>
                <li class="list-group-item">Turno agendado para la paciente Ana Rodríguez a las 11:30 AM</li>
            </ul>
      </section>
    </main>
    <footer></footer>
</body>
</html>