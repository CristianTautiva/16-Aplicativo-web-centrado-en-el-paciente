<?php
session_start();
require 'database/conexion_db.php';
$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])) {



    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $documento = $_POST['documento'];
    $tipo_documento = $_POST['tipo_documento'];
    $tipo_user = (int) $_POST['tipo_user'];
    $sexo = $_POST['sexo'];
    $fecha_nac = $_POST['fecha_nac'];

    $_connection = Connection::getInstance();
    $registro = $_connection->execute("INSERT INTO users (nombres,apellidos,password,email,documento,tipo_documento,tipo_user,sexo,fecha_nac) VALUES ('$nombres','$apellidos','$password','$email','$documento','$tipo_documento','$tipo_user','$sexo','$fecha_nac')");

    if ($registro) {
        $user = $nombres . ' ' . $apellidos;
        $message = "Se registro Correctamente el usuario" . ' ' . $user;
    } else {
        $message = 'Algo ha ido mal, vuelva a intentarlo por favor';
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
    <title>Registro de Nuevo Usuario</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style4.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,700;1,400&display=swap" rel="stylesheet">
</head>

<body>

    <?php require 'partials/header_primary.php' ?>

    <div class="fondo3">
        <?php require 'partials/bar_navigation_vertical.php' ?>
        <div class="container p-4">
            <?php if (!empty($message)) : ?>

                <div class="col-md-4 mx-auto">
                    <div class="alert alert-success">
                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                        <p><?= $message ?></p>
                    </div>
                </div>

            <?php endif ?>
            <div class="row">
                <div class="col-md-5 mx-auto">

                    <div class="card text-center">
                        <div class="card-header">
                            <h2>Registrando Usuario</h2>

                        </div>
                        <div class="card-body">

                            <form action="nuevo.php" method="POST">
                                <div class="form-group">
                                    <input type="text" name="email" placeholder="Correo electronico" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="nombres" placeholder="Nombres" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="apellidos" placeholder="Apellidos" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" placeholder="Contraseña" class="form-control" required>
                                    <button class="btn btn-secondary form-control" type="button" onclick="mostrarContrasena()">
                                        <ion-icon src="assets/icons/eye-outline.svg"></ion-icon>
                                    </button>

                                </div>

                                <div class="form-group">
                                    <input type="text" name="documento" placeholder="N° Documento" class="form-control input-md" required>
                                    <select name="tipo_documento" class="form-control" required>
                                        <option selected value="">Tipo</option>
                                        <option>Tarjeta Identidad (TI)</option>
                                        <option>Cedula Ciudadania (CC)</option>
                                        <option>Cedula Extranjeria (CE)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select name="tipo_user" class="form-control" required>
                                        <option selected value="">Tipo de Usuario</option>
                                        <optgroup label="Hospital">
                                            <option value="1">Medico</option>
                                            <option value="2">Enfermero</option>
                                        </optgroup>
                                        <optgroup label="Persona Natural">
                                            <option value="3">Paciente</option>
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="fecha_nac">Fecha Nacimiento</label><br>
                                    <input class="form-control" type="date" name="fecha_nac" value="1990-12-24" min="1750-01-01" max="2030-12-31">
                                </div> 

                                <div class="form-group">
                                    <label for="sexo">Genero</label><br>
                                    <input type="radio" name="sexo" value="Masculino">&nbsp;Masculino
                                    &nbsp;&nbsp;
                                    <input type="radio" name="sexo" value="Femenino">&nbsp;Femenino
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="Registrarse" class="btn btn-primary btn-block">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="datatable/jquery.dataTables.min.js"></script>
    <script src="datatable/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
</body>

</html>