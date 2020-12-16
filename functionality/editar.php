<?php
session_start();
require '../database/conexion_db.php';

if (!isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    die();
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $_connection = Connection::getInstance();
    $records = $_connection->execute($sql);
    $datos_user = $records->fetch_array(MYSQLI_ASSOC);
    $user = null;
    if (isset($_SESSION['user_id'])) {

        $sql = "SELECT * FROM users WHERE id =" . $_SESSION['user_id'];
        $records = $_connection->execute($sql);
        $results = $records->fetch_array(MYSQLI_ASSOC);
        if (count($results) > 0) {
            $user = $results;
        }
    }
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
    <title>Editando</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style3.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,700;1,400&display=swap" rel="stylesheet">
</head>

<body background="../public/img/20.jpg" style="min-height:100%; background-repeat: no-repeat; background-size:cover;">

<?php require '../partials/header_secondary.php' ?>


  
        <?php require '../partials/bar_navigation_vertical.php' ?>
        <div class="container p-4">

            <?php if (!empty($message) && $message == 'del') : ?>

                <div class="col-md-4 mx-auto">
                    <div class="alert alert-danger">
                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                        <p><?= $message ?></p>
                    </div>
                </div>

            <?php endif ?>
            <div class="row">
                <div class="col-md-5 mx-auto">

                    <div class="card text-center">
                        <div class="card-header">
                            <h2>Seleccione el tipo de cargo que tiene <b><?php echo $datos_user['nombres'] . ' ' . $datos_user['apellidos'] ?></b></h2>
                            <br><a href="../index.php">Regresar</a>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <select id= "tipo_user" name="tipo_user" class="form-control" required>
                                    <optgroup label="Hospital">
                                        <option value=0 <?php if ($datos_user['tipo_user'] == 0) echo 'selected' ?>>Admin</option>
                                        <option value=1 <?php if ($datos_user['tipo_user'] == 1) echo 'selected' ?>>Medico</option>
                                        <option value=2 <?php if ($datos_user['tipo_user'] == 2) echo 'selected' ?>>Enfermero</option>
                                    </optgroup>
                                    <optgroup label="Persona Natural">
                                        <option value="3" <?php if ($datos_user['tipo_user'] == 3) echo 'selected' ?>>Paciente</option>
                                    </optgroup>
                                </select>
                            </div>
                            <input id="id_user" name="id_user" type="hidden" value="<?php echo $datos_user['id'] ?>">
                            <div class="form-group">
                                <a href="#" id="" class="btn btn-info" data-href="" data-toggle="modal" data-target="#confirm-permissions">
                                    Conceder Permisos
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    

    <!-- Modal -->
    <div class="modal fade" id="confirm-permissions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Otorgar permisos (Cambio de usuario)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Desea actualizar el tipo de usuario?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a href="javascript:getURL()" class="btn btn-success btn-ok">Estoy de acuerdo</a>
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
</body>

</html>