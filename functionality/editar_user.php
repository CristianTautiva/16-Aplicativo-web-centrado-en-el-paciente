<?php
session_start();
require '../database/conexion_db.php';

if (!isset($_SESSION['user_id'])) {
    header('location: ../index.php');
   
} else {
    
    $id = $_GET['id'];
    if($_SESSION['user_id'] == $id){
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $_connection = Connection::getInstance();
    $records = $_connection->execute($sql);
    $datos_user = $records->fetch_array(MYSQLI_ASSOC);

    }else{
        header('location: editar_user.php?id='.$_SESSION['user_id']);
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

<body>

<?php require '../partials/header_secondary.php' ?>



    <div class="fondo3">
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
                            <h2>Actualizar Datos</h2>
                            o <a href="../index.php">Regresar</a>
                        </div>
                        <div class="card-body">

                            <form action="update.php" method="POST">
                                <div class="form-group">
                                    <input type="text" name="email" placeholder="Correo electronico" value="<?php echo $datos_user['email'] ?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="nombres" placeholder="Nombres" value="<?php echo  $datos_user['nombres'] ?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="apellidos" placeholder="Apellidos" value="<?php echo  $datos_user['apellidos'] ?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" placeholder="Contraseña Nueva" class="form-control">
                                    <button class="btn btn-secondary form-control" type="button" onclick="mostrarContrasena()">
                                        <ion-icon src="../assets/icons/eye-outline.svg"></ion-icon>
                                    </button>

                                </div>

                                <div class="form-group">
                                    <input type="text" name="documento" placeholder="N° Documento" value="<?php echo $data['documento'] ?>" class="form-control input-md" required>
                                    <select name="tipo_documento" class="form-control" required>

                                        <option value="Tarteja Identidad (TI)" <?php if ( $datos_user['tipo_documento'] == 'Tarteja Identidad (TI)') echo 'selected' ?>>Tarteja Identidad (TI)</option>
                                        <option value="Cedula Ciudadania (CC)" <?php if ( $datos_user['tipo_documento'] == 'Cedula Ciudadania (CC)') echo 'selected' ?>>Cedula Ciudadania (CC)</option>
                                        <option value="Cedula Extranjeria (CE)" <?php if ( $datos_user['tipo_documento'] == 'Cedula Extranjeria (CE)') echo 'selected' ?>>Cedula Extranjeria (CE)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sexo">Genero</label><br>
                                    <input type="radio" name="sexo" value="Masculino"<?php if ( $datos_user['sexo'] == 'Masculino') echo 'checked' ?>>&nbsp;Masculino
                                    &nbsp;&nbsp;
                                    <input type="radio" name="sexo" value="Femenino"<?php if ( $datos_user['sexo'] == 'Femenino') echo 'checked' ?>>&nbsp;Femenino
                                </div>


                                <input name="id" type="hidden" value="<?php echo  $datos_user['id'] ?>">
                                <div class="form-group">
                                    <input type="submit" value="Actualizar Informacion" class="btn btn-primary btn-block">
                                </div>
                            </form>
                        </div>
                    </div>
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