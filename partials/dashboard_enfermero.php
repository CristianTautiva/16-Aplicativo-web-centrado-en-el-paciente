<?php
require_once "./database/conexion_db.php";

$id_enfermero = $_SESSION['user_id'];

$_connection = Connection::getInstance();
$result = $_connection->execute("SELECT historia.id_paciente,historia.fecha,hospitalizacion.activa,hospitalizacion.id_historia,users.nombres,users.apellidos,medico_historia.id_medico FROM historia INNER JOIN hospitalizacion ON hospitalizacion.id_historia = historia.id INNER JOIN users ON historia.id_paciente = users.id INNER JOIN medico_historia ON historia.id = medico_historia.id_historia where hospitalizacion.id_enfermero ='$id_enfermero'");


if ($result && $result->num_rows > 0) {
    $result->fetch_all(MYSQLI_ASSOC);
}


?>

<body background="./public/img/3.jpg" style="min-height:100%; background-repeat: no-repeat; background-size:cover;">
<div class="container-fluid">
    <div class="row">
        <?php require './partials/bar_navigation_vertical.php' ?>
        <div class="container">
            <?php
            if (isset($_GET['message']) && $_GET['message'] == 'act') {
                $message = 'Se Actualizo el registro correctamente';
                $tipo = 'alert-success';
            } elseif (isset($_GET['message']) && $_GET['message'] == 'del') {
                $message = 'Se elimino el registro correctamente';
                $tipo = 'alert-success';
            }

            ?>

            <?php if (!empty($message)) : ?>

                <div class="col-md-4 mx-auto">
                    <div class="alert <?= $tipo ?>">
                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                        <p><?= $message ?></p>
                    </div>
                </div>

            <?php endif; ?>
            <br>
            <div class="row">
                <br>
                <h2>Pacientes Asignados</h2>
                <br> <br><br>
                <div class="row table-responsive">

                    <table class="table table-hover table-bordered p-4" id="datatable" style="background-color: whitesmoke;">
                        <thead style="background-color:  #1F2F86;color: white; font-weight: bold;">
                            <tr>
                                <td>Fecha de Visita</td>
                                <td>Paciente</td>
                                <td>Hospitalizacion Activa</td>
                                <td>Funcion</td>
                                <td>Opciones de Hospitalizacion</td>
                            </tr>
                        </thead>
                        <tfoot style="background-color: #ccc;color: white; font-weight: bold;">
                            <tr>
                                <td>Fecha de Visita</td>
                                <td>Paciente</td>
                                <td>Hospitalizacion Activa</td>
                                <td>Funcion</td>
                                <td>Opciones de Hospitalizacion</td>
                            </tr>
                        </tfoot>
                        <tbody>

                            <?php
                            foreach ($result as $result) {
                            ?>
                            <?php
                            if($result['activa'] == 1) {
                            ?>
                                <tr>
                                   
                                    <?php $date = date_create($result['fecha']); ?>
                                    <td id="fecha"><?php echo date_format($date, "d M Y");?> </td>
                                    <td><?php echo $result['nombres'] . ' ' . $result['apellidos'] ?></td>
                                    <td><?php if ($result['activa'] == 1) { ?>
                                            <span class="ml-auto">Si &nbsp;&nbsp;<ion-icon src="./assets/icons/checkmark-done-sharp.svg"></ion-icon></span>
                                        <?php } else { ?>
                                            No &nbsp;&nbsp;<span class="ml-auto"><ion-icon src="./assets/icons/close-sharp.svg"></ion-icon></span>
                                        <?php } ?></td>
                                    <td style="text-align: center;">
                                        <a class="btn btn-info" href="functionality/hc_ver_mas.php?id=<?php echo $result['id_historia']; ?>">Ver Mas &nbsp;<span>
                                                <ion-icon src="./assets/icons/arrow-forward-outline.svg"></ion-icon>
                                            </span></a></td>
                                    </td>
                                    <td><a class="btn btn-warning" href="functionality/let_paciente.php?id=<?php echo $result['id_historia']; ?>">
                                            Cambiar a Inactiva&nbsp;&nbsp;&nbsp;&nbsp;<ion-icon src="./assets/icons/git-compare-outline.svg"></ion-icon>
                                        </a></td>


                                </tr>
                                <?php
                               }
                            ?>
                            <?php
                            }
                            ?>


                        </tbody>
                    </table>

                </div>

            </div>
            <br>
            <br>
        </div>
    </div>
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./datatable/jquery.dataTables.min.js"></script>
    <script src="./datatable/dataTables.bootstrap4.min.js"></script>
    <script src="./assets/js/main.js"></script>
    <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatable').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ entradas totales)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "lengthMenu": [
                    [3, 6, 10, -1],
                    [3, 6, 10, "All"]
                ]
            });
        });
    </script>

</body>