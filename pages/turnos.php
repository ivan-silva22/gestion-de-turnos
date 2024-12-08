<?php
require_once("../controllers/rutasProtegidas.php");
verificarAutenticacion();
require_once("../db/conexionDB.php");

$consultaTurnos = "SELECT id, nombre, apellido, dni, consulta, fecha, hora, estado FROM pacientes";
$resultadoConsulta = mysqli_query($conexion, $consultaTurnos);

if (!$resultadoConsulta) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

$pacientes = [];
while ($paciente = mysqli_fetch_assoc($resultadoConsulta)) {
    $pacientes[] = $paciente;
}

?>

<?php if (isset($_GET['mensaje'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let title, text, icon;

            switch ('<?php echo $_GET['mensaje']; ?>') {
                case 'success':
                    title = 'Éxito!';
                    text = 'Turno creado exitosamente.';
                    icon = 'success';
                    break;
                case 'deleted':
                    title = 'Eliminado!';
                    text = 'El turno se eliminó correctamente.';
                    icon = 'success';
                    break;
                case 'updated':
                    title = 'Éxito!';
                    text = 'El turno se modificó correctamente.';
                    icon = 'success';
                    break;
                default:
                    title = 'Error!';
                    text = 'Hubo un problema al realizar la operación.';
                    icon = 'error';
            }

            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonText: 'Ok'
            }).then(() => {
                const url = new URL(window.location.href);
                url.searchParams.delete('mensaje');
                window.history.replaceState(null, '', url);
            });
        });
    </script>
<?php endif; ?>



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
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-nav">
            <div class="container">
              <h5 class="color-texto">Bienvenido <span class="active"><?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></span></h5>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link color-texto" aria-current="page" href="./panelAdmin.php">Inicio</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link color-texto" href="./medicos.php">Medicos</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active color-texto" href="./turnos.php">Turnos</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link color-texto" href="../controllers/cerrarSesion.php">Cerrar sesión</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
    </header>
    <main class="container my-4">
        <h1 class="mb-4">Sección Turnos</h1>
        <div class="mb-4">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearTurnoModal" onclick="limpiarFormulario()">Crear Nuevo Turno</button>
        </div>
        <table class="table ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>DNI</th>
                    <th>Consulta</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $indice = 1; 
                foreach ($pacientes as $paciente): ?>
                <tr>
                    <td><?php echo $indice; ?></td>
                    <td><?php echo htmlspecialchars($paciente['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['apellido']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['dni']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['consulta']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['hora']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['estado']); ?></td>
                    <td>
                    <button class="btn btn-warning" onclick="confirmarAtencion(<?php echo htmlspecialchars($paciente['id']); ?>)">Confirmar atención</button>
                        <button class="btn btn-danger" onclick="confirmarEliminacion(<?php echo htmlspecialchars($paciente['id']); ?>)">Eliminar</button>
                        
                    </td>
                    
                </tr>
            <?php 
                $indice++; 
                endforeach; 
            ?>
            </tbody>
        </table>

        <div class="modal fade" id="crearTurnoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearTurnoModalLabel">Crear Nuevo Turno</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="formCrearTurno" method="POST" action="../controllers/crearTurno.php">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>
    <div class="mb-3">
        <label for="apellido" class="form-label">Apellido:</label>
        <input type="text" class="form-control" id="apellido" name="apellido" required>
    </div>
    <div class="mb-3">
        <label for="dni" class="form-label">DNI:</label>
        <input type="text" class="form-control" id="dni" name="dni" required>
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
        <label for="fecha" class="form-label">Fecha:</label>
        <input type="date" class="form-control" id="fecha" name="fecha" required>
    </div>
    <div class="mb-3">
        <label for="hora" class="form-label">Hora:</label>
        <input type="time" class="form-control" id="hora" name="hora" required>
    </div>
    <button type="submit" id="btnSubmit" class="btn btn-success w-100">Crear Turno</button>
</form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    function confirmarEliminacion(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás recuperar este turno después de eliminarlo.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                
                window.location.href = '../controllers/eliminarTurno.php?id=' + id;
            }
        });
    }

    function confirmarAtencion(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Cambiará el estado a 'Atendido'.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, confirmar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../controllers/confirmarAtencion.php?id=' + id;
        }
    });
}


</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>