<?php
require_once "./database/conexion_db.php";
$_connection = Connection::getInstance();
$result = $_connection->execute("SELECT * FROM users WHERE tipo_user = 3");
?>

<body background="./public/img/13.jpg" style="min-height:100%; background-repeat: no-repeat; background-size:cover;">
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
                <h2>Pacientes en el Hospital</h2>
                <br> <br><br>
                <div class="row table-responsive">

                    <table class="table table-hover table-bordered p-4" id="datatable" style="background-color: whitesmoke;">
                        <thead style="background-color:  #1F2F86;color: white; font-weight: bold;">
                            <tr>
                                <td>Nombres</td>
                                <td>Apellidos</td>
                                <td>Documento</td>
                                <td>Tipo Documento</td>
                                <td>Email</td>
                                <td>Ver Historial Clinico</td>
                                <td>Añadir al Historial</td>
                            </tr>
                        </thead>
                        <tfoot style="background-color: #ccc;color: white; font-weight: bold;">
                            <tr>
                                <td>Nombres</td>
                                <td>Apellidos</td>
                                <td>Documento</td>
                                <td>Tipo Documento</td>
                                <td>Email</td>
                                <td>Ver Historial Clinico</td>
                                <td>Añadir al Historial</td>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            while ($mostrar = mysqli_fetch_row($result)) {
                            ?>
                                <tr>
                                    <td><?php echo $mostrar[1] ?></td>
                                    <td><?php echo $mostrar[2] ?></td>
                                    <td><?php echo $mostrar[5] ?></td>
                                    <td><?php echo $mostrar[6] ?></td>
                                    <td><?php echo $mostrar[4] ?></td>
                                    <td style="text-align: center;">
                                        <a class="btn btn-success"href="partials/historial_clinico.php?id=<?php echo $mostrar[0]; ?>"><span>
                                                <ion-icon src="./assets/icons/document-text-outline.svg"></ion-icon>
                                            </span></a></td>
                                    </td>
                                    <td style="text-align: center;">
                                        <a class="btn btn-primary" href="partials/anadir_historial.php?id=<?php echo $mostrar[0]; ?>"><span>
                                                <ion-icon src="./assets/icons/document-attach-outline.svg"></ion-icon>
                                            </span></a></td>
                                    </td>
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
                    [3, 6, 10, -1],
                    [3, 6, 10, "All"]
                ]
            });
        });
    </script>

</body>