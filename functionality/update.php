<?php
require '../database/conexion_db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location: ../index.php');
} else {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $documento = $_POST['documento'];
    $tipo_documento = $_POST['tipo_documento'];
    $sexo = $_POST['sexo'];
    $_connection = Connection::getInstance();

    if ($_POST['password'] != '' || $_POST['password'] != null) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $sql = "UPDATE users SET nombres='$nombres', apellidos='$apellidos', email ='$email', password='$password', documento ='$documento', tipo_documento='$tipo_documento',sexo='$sexo' WHERE id='$id'";
        
        if ($_connection->execute($sql)) {
            header('location: ../dashboard.php?message=act');
        }
    } else {
        $sql = "UPDATE users SET nombres='$nombres', apellidos='$apellidos', email ='$email',documento ='$documento', tipo_documento='$tipo_documento',sexo='$sexo' WHERE id='$id'";
        if ($_connection->execute($sql)) {
            header('location: ../dashboard.php?message=act');
        }
    }
}
?>
