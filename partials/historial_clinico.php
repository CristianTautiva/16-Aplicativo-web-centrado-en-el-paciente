<?php
session_start();
require '../database/conexion_db.php';

if (!isset($_SESSION['user_id'])) {
    header('location: ../index.php');
} else {
    $id = (int)$_GET['id'];
    $_connection = Connection::getInstance();


    $result = $_connection->execute("SELECT historia.id,historia.fecha, historia.hospitalizacion, users.nombres, users.apellidos FROM historia INNER JOIN medico_historia on historia.id = medico_historia.id_historia INNER JOIN users on users.id = medico_historia.id_medico WHERE id_paciente = '$id'");



    if ($result && $result->num_rows > 0) {
        $result->fetch_all(MYSQLI_ASSOC);
    }




    $result_user = $_connection->execute("SELECT * FROM users WHERE id = '$id'");
    $data_users = mysqli_fetch_array($result_user);
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

<body background="../public/img/3.jpg" style="min-height:100%; background-repeat: no-repeat;
  ">
    <?php require '../partials/header_secondary.php' ?>
    <div class="container-fluid">
        <div class="row">

            <?php require '../partials/bar_navigation_vertical.php' ?>

            <div class="container">
                <br>

                <div class="card">
                    <div class="card-header">
                        <h2 class=" w-40">Historias de <b><?php echo $data_users['nombres'] . ' ' . $data_users['apellidos'] ?></b></h2>
                    </div>
                    <br>

                    <div class="row">
                        <div class="card-body">
                            <br>
                            <a href="../index.php" class="btn btn-primary">Regresar</a>
                            <div class="row table-responsive">

                                <table class="table table-hover p-4" id="mitabla">
                                    <thead style="background-color: #ccc;color: white; font-weight: bold;">
                                        <tr>
                                            <td>ID</td>
                                            <td>Fecha</td>
                                            <td>Doctor</td>
                                            <td>Hospitalizacion</td>
                                            <td>Operacion</td>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($result as $result) {
                                        ?>
                                            <tr>
                                                <td><?php echo $result['id'] ?></td>
                                                <?php $date = date_create($result['fecha']); ?>
                                                <td id="fecha"><?php echo date_format($date, "d M Y"); ?> </td>
                                                <td><?php echo $result['nombres'] . ' ' . $result['apellidos'] ?></td>
                                                <td><?php if ($result['hospitalizacion'] == 1) { ?>
                                                        <span class="ml-auto">Si &nbsp;&nbsp;<ion-icon src="../assets/icons/checkmark-done-sharp.svg"></ion-icon></span>
                                                    <?php } else { ?>
                                                        No &nbsp;&nbsp;<span class="ml-auto">
                                                            <ion-icon src="../assets/icons/close-sharp.svg"></ion-icon>
                                                        </span>
                                                    <?php } ?></td>
                                                <td style="text-align: center;">
                                                    <a class="btn btn-info" href="../functionality/hc_ver_mas.php?id=<?php echo $result['id']; ?>">Ver Mas &nbsp;<span>
                                                            <ion-icon name="arrow-forward-outline"></ion-icon>
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
                    </div>



                    <br>
                    <br>
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
            $('#mitabla').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay historias",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Historias",
                    "infoFiltered": "(Filtrado de _MAX_ Historias totales)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Historias",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primera",
                        "last": "Ultima",
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

</html>