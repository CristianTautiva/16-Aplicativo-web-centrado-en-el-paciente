<?php
require '../database/conexion_db.php';

    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id='$id'";
    $_connection = Connection::getInstance();
    if ($_connection->execute($sql)) {
        header('location: ../dashboard.php?message=del');
    }

 ?>