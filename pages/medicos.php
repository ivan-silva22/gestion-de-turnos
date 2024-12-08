<?php
require_once("../controllers/rutasProtegidas.php");
verificarAutenticacion();
require_once("../db/conexionDB.php");


$consultaMedicos = "SELECT id, nombre, especialidad FROM medicos";
$resultadoMedicos = mysqli_query($conexion, $consultaMedicos);


if (!$resultadoMedicos) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

$medicos = [];
while ($medico = mysqli_fetch_assoc($resultadoMedicos)) {
    $medicos[] = $medico;
}

?>

<?php if (isset($_GET['mensaje'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let title, text, icon;

            switch ('<?php echo $_GET['mensaje']; ?>') {
                case 'success':
                    title = 'Éxito!';
                    text = 'El médico creado exitosamente.';
                    icon = 'success';
                    break;
                case 'deleted':
                    title = 'Eliminado!';
                    text = 'El médico se eliminó correctamente.';
                    icon = 'success';
                    break;
                case 'updated':
                    title = 'Éxito!';
                    text = 'El médico se modificó correctamente.';
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
    <title>Medicos</title>
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
                    <a class="nav-link active color-texto" href="./medicos.php">Medicos</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link color-texto" href="./turnos.php">Turnos</a>
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
        <h1 class="mb-4">Sección Médicos</h1>
        <div class="mb-4">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearMedicoModal" onclick="limpiarFormulario()">Crear Nuevo Médico</button>
        </div>
        <table class="table ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Especialidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $indice = 1; 
                foreach ($medicos as $medico): ?>
                <tr>
                    <td><?php echo $indice; ?></td>
                    <td><?php echo htmlspecialchars($medico['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($medico['especialidad']); ?></td>
                    <td>
                    <button class="btn btn-warning" onclick="abrirModalModificar(<?php echo htmlspecialchars(json_encode($medico)); ?>)">Modificar</button>
                    <button class="btn btn-danger" onclick="confirmarEliminacion(<?php echo htmlspecialchars($medico['id']); ?>)">Eliminar</button>
                    </td>
                </tr>
            <?php 
                $indice++; 
                endforeach; 
            ?>
            </tbody>
        </table>

        <div class="modal fade" id="crearMedicoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearMedicoModalLabel">Crear Nuevo Médico</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="formCrearMedico" method="POST" action="../controllers/crearMedico.php">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>
    <div class="mb-3">
        <label for="especialidad" class="form-label">Especialidad:</label>
        <input type="text" class="form-control" id="especialidad" name="especialidad" required>
    </div>
    <button type="submit" id="btnSubmit" class="btn btn-success w-100">Crear Médico</button>
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
            text: "No podrás recuperar este médico después de eliminarlo.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                
                window.location.href = '../controllers/eliminarMedico.php?id=' + id;
            }
        });
    }

    function abrirModalModificar(medico) {
        document.getElementById('nombre').value = medico.nombre;
        document.getElementById('especialidad').value = medico.especialidad;
        document.getElementById('formCrearMedico').action = '../controllers/modificarMedico.php?id=' + medico.id;
        document.getElementById('crearMedicoModalLabel').innerText = 'Modificar Médico';
        document.getElementById('btnSubmit').innerText = 'Modificar Médico';

        new bootstrap.Modal(document.getElementById('crearMedicoModal')).show();
    }

    function limpiarFormulario() {
        document.getElementById('nombre').value = '';
        document.getElementById('especialidad').value = '';
        document.getElementById('formCrearMedico').action = '../controllers/crearMedico.php';
        document.getElementById('crearMedicoModalLabel').innerText = 'Crear Nuevo Médico';
        document.getElementById('btnSubmit').innerText = 'Crear Médico';
    }

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>