<?php
session_start();
require '../database/conexion_db.php';

if (!isset($_SESSION['user_id'])) {
    header('location: ../index.php');
} else {
    $id_user = $_GET['id'];
    $id_medico = $_SESSION['user_id'];
    $_connection = Connection::getInstance();
    $result = $_connection->execute("SELECT id,nombres,apellidos FROM users WHERE id = '$id_user'");
    $datas = mysqli_fetch_array($result);
    $tipo_user = 2;
    $enfermeros = $_connection->execute("SELECT id,nombres,apellidos FROM users WHERE tipo_user = '$tipo_user'");
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

<body background="../public/img/8.jpg" style="min-height:100%; background-repeat: no-repeat; 
  ">
    <?php require '../partials/header_secondary.php' ?>

    <?php require '../partials/bar_navigation_vertical.php' ?>

    <div class="container p-4">
        <form action="../functionality/add_historial.php" method="POST">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Creando Historial Para El Usuario: <br>
                                <b><?php echo $datas['nombres'] . ' ' . $datas['apellidos'] ?></h4></b>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 p-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5>Tension</h5>
                        </div>
                        <div class="card-body form-group">
                            <input class="form-control" type="text" name="tension" id="" placeholder="Ej: 120/80">
                            <p style="text-align: center;margin-top:5%">mm Hg</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 p-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5>Temperatura</h5>
                        </div>
                        <div class="card-body form-group">
                            <input class="form-control" type="text" name="temperatura" id="" placeholder="Ej: 36">
                            <p style="text-align: center;margin-top:5%">°C</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 p-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5>Ritmo Cardiaco</h5>
                        </div>
                        <div class="card-body form-group">
                            <input class="form-control" type="text" name="ritmo_cardiaco" id="" placeholder="Ej: 70 ">
                            <p style="text-align: center; margin-top:5%">BPM</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 p-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5>¿Se requiere Hospitalizar?</h5>
                        </div>
                        <div class="card-body form-group">
                            <select class="form-control" name="hospitalizar" onChange="mostrar(this.value);" required>
                                <option selected value="">Seleccione</option>
                                <option value="si">SI</option>
                                <option value="no">NO</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="enfermero" style="display: none;">
                    <div class="card">
                           <div class="card-header text-center">
                               <h5>Seleccione Enfermero</h5>
                           </div>

                           <div class="card-body form-group">
                        <select class="form-control" name="enfermero_selected">
                            <?php
                            while ($mostrar = mysqli_fetch_row($enfermeros)) {
                            ?>
                                <option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[1] . ' ' . $mostrar[2] ?></option>

                            <?php
                            }
                            ?>
                        </select>

                           </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Diagnostico</h4>
                        </div>
                        <div class="card-body form-group">
                            <textarea class="form-control" name="diagnostico" rows="7">Aqui, su diagnostico</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Tratamiento</h4>
                        </div>
                        <div class="card-body form-group">
                            <textarea class="form-control" name="tratamiento" rows="7">Aqui, el tratamiento a seguir</textarea>
                        </div>
                    </div>
                </div>
                <input name="id_user" type="hidden" value="<?php echo $id_user ?>">
                <input name="id_medico" type="hidden" value="<?php echo $id_medico ?>">
                <div class="col-md-12 p-4">
                    <input type="submit" value="Crear Historia" class="btn btn-success d-block mx-auto w-50">
                </div>


            </div>
    </div>
    </form>
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