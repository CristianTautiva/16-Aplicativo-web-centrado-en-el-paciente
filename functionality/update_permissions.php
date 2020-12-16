<?php
require '../database/conexion_db.php';  
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location: ../index.php');
   
} else {
    $id = $_GET['id_user'];
    $tipo_user = $_GET['tipo_user'];
    
    $sql = "UPDATE users SET tipo_user='$tipo_user' WHERE id='$id'";
    $_connection = Connection::getInstance();
    if($_connection->execute($sql)){
        header('location: ../dashboard.php?message=act'); 
    }
}  
?>
