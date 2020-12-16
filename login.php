<?php
session_start();
require 'database/conexion_db.php';
$tipo = 'alert-danger';
if (!empty($_POST['documento']) && !empty($_POST['password'])) {
    
    $_connection = Connection::getInstance();
    $records = $_connection->execute("SELECT * FROM users WHERE documento =".$_POST['documento']);
    $results = $records->fetch_array(MYSQLI_ASSOC);

    $message = '';

    if (is_array($results)) {
        if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
            $_SESSION['user_id'] = $results['id'];
            header('location: index.php');
        } else {
            $message = 'Algo ha ido mal, por favor revise sus credenciales';
        }
    } else {
        $message = 'Algo ha ido mal, por favor revise sus credenciales';
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
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style3.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,700;1,400&display=swap" rel="stylesheet">
</head>

<body>

    <?php require 'partials/header.php' ?>

    <div class="fondo2">

        <?php
        if (isset($_GET['message'])) :
            $message = 'Se Registro correctamente, ahora puede iniciar sesion con su documento de identidad y contraseña';
            $tipo = 'alert-success';
        endif;
        ?>

        <?php if (!empty($message)) : ?>
           
                <div class="col-md-4 mx-auto p-4">
                    <div class="alert <?= $tipo ?>">
                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                        <p><?= $message ?></p>
                    </div>
                </div>
        
        <?php endif; ?>


        <div class="container p-4">
            <div class="row">
                <div class="col-md-4 mx-auto">
                    <div class="card text-center">
                        <div class="card-header">
                            <h2>Inicia sesion</h2>
                            o <a href="signup.php">Registrate</a>
                        </div>
                        <div class="card-body">

                            <form action="login.php" method="POST">

                                <input type="text" name="documento" placeholder="Documento" class="form-control" required>

                                <div class="form-group">
                                    <input type="password" name="password" id="password" placeholder="Contraseña" class="form-control" required>

                                    <button class="btn btn-secondary form-control" type="button" onclick="mostrarContrasena()">
                                        <ion-icon src="assets/icons/eye-outline.svg"></ion-icon>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Iniciar Sesion" class="btn btn-primary btn-block">
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