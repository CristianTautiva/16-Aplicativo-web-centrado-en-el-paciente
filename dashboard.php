<?php
session_start();
require 'database/conexion_db.php';

if (!isset($_SESSION['user_id'])) {
    header('location: index.php');
    die();
} else {
    $id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $_connection = Connection::getInstance();
    $result = $_connection->execute($sql);
    $data = $result->fetch_array(MYSQLI_ASSOC);
    $tipo_user = $data['tipo_user'];
    if (isset($_GET['message'])){
        $message=$_GET['message'];
    }
    $tipo = 'alert-success';
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
    <title>Inicio</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="datatable/bootstrap.css">
    <link rel="stylesheet" href="datatable/dataTables.bootstrap4.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style2.css">


</head>




    <?php require 'partials/header_primary.php'  ?>

    <?php
    if ($tipo_user == 0) {
        require 'partials/dashboard_admin.php';
    }elseif ($tipo_user == 1) {
        require 'partials/dashboard_medico.php';
    }elseif ($tipo_user == 2) {
        require 'partials/dashboard_enfermero.php';
    }elseif ($tipo_user == 3) {
        require 'partials/dashboard_paciente.php';
    }
    ?>






 

</html>