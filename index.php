<?php
session_start();
require 'database/conexion_db.php';
$user = null;
if (isset($_SESSION['user_id'])) {

    $_connection = Connection::getInstance();
    $records = $_connection->execute("SELECT * FROM users WHERE id =".$_SESSION['user_id']);
    $results = $records->fetch_array(MYSQLI_ASSOC);

    if (count($results) > 0) {
        $user = $results;
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
    <title>Clinica</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
   
</head>

<body>
<?php require 'partials/header.php' ?>
    <?php if (!empty($user)) : ?>
            <?php header('location: dashboard.php'); ?>
    <?php else : ?>
       
        <div class="princ-pag">
            <h1 id="text-index">Comprometidos con su salud<br> a un nivel superior</h1>
            <h4 class="index-b">Al hacer parte de nuestra plataforma, accedera<br> a todos los beneficios y facilidades <br>que esta ofrece, a que esperas!</h4>
             <a href="login.php" class="index-a">Empezar</a><br>
             <a href="signup.php" class="index-a">¿Aun no tienes una cuenta?</a>
        </div>
    <?php endif; ?>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="datatable/jquery.dataTables.min.js"></script>
    <script src="datatable/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
</body>

</html>