<?php
require_once "./database/conexion_db.php";

$id_paciente = $_SESSION['user_id'];

$_connection = Connection::getInstance();
$result = $_connection->execute("SELECT historia.id,historia.fecha,historia.hospitalizacion, users.nombres, users.apellidos FROM historia INNER JOIN medico_historia on historia.id = medico_historia.id_historia INNER JOIN users on users.id = medico_historia.id_medico WHERE id_paciente = '$id_paciente'");



if ($result && $result->num_rows > 0) {
    $result->fetch_all(MYSQLI_ASSOC);
}


?>

<body background="./public/img/15.jpg" style="min-height:100%; background-repeat: no-repeat; background-size:cover;">
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
                <h2>Sus visitas e historias</h2>
                <br> <br><br>
                <div class="row table-responsive">

                    <table class="table table-hover table-bordered p-4" id="datatable" style="background-color: whitesmoke;">
                        <thead style="background-color:  #1F2F86;color: white; font-weight: bold;">
                            <tr>
                                <td>Fecha de Visita</td>
                                <td>Medico</td>
                                <td>Hospitalizacion</td>
                                <td>Detalles</td>
                                <td>Opcion</td>
                            </tr>
                        </thead>
                        <tfoot style="background-color: #ccc;color: white; font-weight: bold;">
                            <tr>
                                <td>Fecha de Visita</td>
                                <td>Medico</td>
                                <td>Hospitalizacion</td>
                                <td>Detalles</td>
                                <td>Opcion</td>
                            </tr>
                        </tfoot>
                        <tbody>

                            <?php
                            foreach ($result as $result) {
                            ?>
                                <tr>
                                    <?php $date = date_create($result['fecha']); ?>
                                    <td id="fecha"><?php echo date_format($date, "d M Y");?> </td>
                                    <td><?php echo $result['nombres'] . ' ' . $result['apellidos'] ?></td>
                                    <td><?php if ($result['hospitalizacion'] == 1) { ?>
                                            <span class="ml-auto">Si &nbsp;&nbsp;<ion-icon src="./assets/icons/checkmark-done-sharp.svg"></ion-icon></span>
                                        <?php } else { ?>
                                            No &nbsp;&nbsp;<span class="ml-auto">
                                                <ion-icon src="./assets/icons/close-sharp.svg"></ion-icon>
                                            </span>
                                        <?php } ?></td>
                                    <td style="text-align: center;">
                                        <a class="btn btn-info" href="functionality/hc_ver_mas.php?id=<?php echo $result['id']; ?>">Ver Mas &nbsp;<span>
                                                <ion-icon src="./assets/icons/arrow-forward-outline.svg"></ion-icon>
                                            </span></a></td>
                                    </td>
                                    <td><a class="btn btn-success" href="functionality/download_hc.php?id=<?php echo $result['id']; ?>">
                                            Descargar Orden&nbsp;&nbsp;&nbsp;&nbsp;<ion-icon src="./assets/icons/cloud-download-outline.svg"></ion-icon>
                                        </a></td>


                                </tr>
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
                    [4, 8, 12, -1],
                    [4, 8, 12, "All"]
                ]
            });
        });
    </script>

</body>