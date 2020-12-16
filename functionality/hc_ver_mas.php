<?php
session_start();
require '../database/conexion_db.php';
$_connection = Connection::getInstance();
$user = null;
$datos_user = null;
$enfermero = null;
$hospitalizacion = null;
$medico = null;
if (isset($_SESSION['user_id'])) {
    $_connection = Connection::getInstance();
    $records = $_connection->execute("SELECT * FROM users WHERE id =" . $_SESSION['user_id']);
    $results = $records->fetch_array(MYSQLI_ASSOC);
    $id_historia = $_GET['id'];

    $id_historia = $_GET['id'];
    $hosp = $_connection->execute("select hospitalizacion from historia where id = '$id_historia'");
    $hosp = $hosp->fetch_array(MYSQLI_ASSOC);

    if (count($results) > 0) {
        $user = $results;
    }
    $activa = '';
    if ($hosp['hospitalizacion']) {
        $query = $_connection->execute("SELECT estado_paciente.tension,estado_paciente.temperatura,estado_paciente.ritmo_cardiaco,estado_paciente.diagnostico,estado_paciente.tratamiento,estado_paciente.id_enfermero,historia.id,historia.id_paciente,historia.fecha,historia.hospitalizacion,hospitalizacion.activa,users.nombres,users.apellidos,users.sexo,users.fecha_nac,medico_historia.id_medico FROM estado_paciente INNER JOIN hospitalizacion ON estado_paciente.id_hospitalizacion = hospitalizacion.id INNER JOIN historia ON hospitalizacion.id_historia = historia.id INNER JOIN users ON historia.id_paciente = users.id INNER JOIN medico_historia ON historia.id = medico_historia.id_historia WHERE hospitalizacion.id_historia = '$id_historia'");
        $datos_user = mysqli_fetch_assoc($query);
        $enfermero = $_connection->execute("SELECT nombres, apellidos from users where id =" . $datos_user['id_enfermero']);
        $enfermero = mysqli_fetch_assoc($enfermero);
        $enfermero = $enfermero['nombres'] . ' ' . $enfermero['apellidos'];
        $hospitalizacion = 'SI';
        $medico = $_connection->execute("SELECT nombres, apellidos from users where id =" . $datos_user['id_medico']);
        $medico = mysqli_fetch_assoc($medico);
        $medico = $medico['nombres'] . ' ' . $medico['apellidos'];
        if ($datos_user['activa']) {
            $activa = 'El servicio esta activo';
        } else {
            $activa = 'El servicio no se encuentra activo';
        }
    } else {

        $query1 = $_connection->execute("SELECT consulta_paciente.tension,consulta_paciente.temperatura,consulta_paciente.ritmo_cardiaco,consulta_paciente.diagnostico,consulta_paciente.tratamiento,historia.id,historia.id_paciente,historia.fecha,historia.hospitalizacion,users.nombres,users.apellidos,users.sexo,users.fecha_nac,medico_historia.id_medico FROM consulta_paciente INNER JOIN historia ON consulta_paciente.id_historia = historia.id INNER JOIN users ON historia.id_paciente = users.id INNER JOIN medico_historia ON historia.id = medico_historia.id_historia WHERE consulta_paciente.id_historia = '$id_historia'");
        $datos_user = mysqli_fetch_assoc($query1);
        $enfermero = 'Ninguno';
        $hospitalizacion = 'NO';
        $medico = $_connection->execute("SELECT nombres, apellidos from users where id =" . $datos_user['id_medico']);
        $medico = mysqli_fetch_assoc($medico);
        $medico = $medico['nombres'] . ' ' . $medico['apellidos'];
        $activa = 'El servicio no se encuentra activo';
    }
    $fechaint =  strtotime($datos_user['fecha_nac']);
    $fecha_nac = date("Y", $fechaint);
    $anio_act = date("Y");
    $edad_paciente = $anio_act - $fecha_nac;
    $f_nacimiento = strftime("%A, %d de %B del %Y", strtotime($datos_user['fecha_nac']));
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <title>Historial</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style2.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,700;1,400&display=swap" rel="stylesheet">
</head>

<body background="../public/img/16.jpg" style="min-height:100%; background-repeat: no-repeat;
  ">
    <?php require '../partials/header_secondary.php' ?>

    <?php require '../partials/bar_navigation_vertical.php' ?>

    <div class="container p-4">
        <div class="row">

            <div class="col-md-12 p-2" style="background-color:whitesmoke;border-color: #D3D3D3; border-width: 1px;border-style: double; border-radius: 20px;">
                <br>
                <h4>Detalles de Historial N° <?php echo $datos_user['id']  ?></h4><br>
            </div>

            <div class="col-md-6 p-4" style="background-color:white;border-color: #D3D3D3; border-width: 1px;border-style: double; border-radius: 20px;">

                <h6>Paciente: </h6> <b><?php echo $datos_user['nombres'] . ' ' . $datos_user['apellidos'] ?></b>
                <h6>Edad: </h6> <b><?php echo $edad_paciente ?></b>
                <h6>Fecha Nacimiento: </h6><b><?php echo $f_nacimiento ?></b>
                <h6>Sexo: </h6><b><?php echo $datos_user['sexo'] ?></b>
            </div>
            <div class="col-md-6 p-4" style="background-color:white;border-color: #D3D3D3; border-width: 1px;border-style: double;border-radius: 20px; ">

                <h6>Medico Tratante: </h6> <b><?php echo $medico ?></b>
                <h6>Hospitalizacion: </h6> <b><?php echo $hospitalizacion ?></b>
                <h6>Activa: </h6><b><?php echo $activa ?></b>
                <h6>Enfermero Asignado: </h6><b><?php echo $enfermero ?></b>
            </div>


            <div class="col-md-12 p-4">
                <div class="table-responsive">

                    <table class="table table-hover p-4">
                        <thead style="background-color:  #1F2F86;color: white; font-weight: bold;">
                            <tr>
                                <td>Tension</td>
                                <td>Temperatura</td>
                                <td>Ritmo Cardiaco</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $datos_user['tension']  ?></td>
                                <td><?php echo $datos_user['temperatura']  ?></td>
                                <td><?php echo $datos_user['ritmo_cardiaco'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>





            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Diagnostico</h4>
                    </div>
                    <div class="card-body form-group">
                        <textarea readonly class="form-control" name="diagnostico" rows="7"><?php echo $datos_user['diagnostico']  ?></textarea>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Tratamiento</h4>
                    </div>
                    <div class="card-body form-group">
                        <textarea readonly class="form-control" name="tratamiento" rows="7"><?php echo $datos_user['tratamiento']  ?></textarea>
                    </div>
                </div>
            </div>

            <a href="../dashboard.php" class="btn btn-info d-block mx-auto w-50">Regresar</a>




        </div>
    </div>
    </div>
    </div>



    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../datatable/jquery.dataTables.min.js"></script>
    <script src="../datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatable').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay Historias Clinicas para mostrar",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Historias",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ Historias totales)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Historias",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se hallaron Historias",
                    "paginate": {
                        "first": "Primera",
                        "last": "Ultima",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "lengthMenu": [
                    [5, 10, 15, -1],
                    [5, 10, 15, "All"]
                ]
            });
        });
    </script>

</body>

</html>