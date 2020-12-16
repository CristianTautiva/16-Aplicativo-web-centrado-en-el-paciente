<?php
session_start();
require '../database/conexion_db.php';
$_connection = Connection::getInstance();

$id_user = (int)$_POST['id_user'];
$id_medico = (int) $_POST['id_medico'];
$hospitalizar = $_POST['hospitalizar'];
$id_enfermero = (int) $_POST['enfermero_selected'];
$tension = $_POST['tension'] . ' mm Hg';
$temperatura = $_POST['temperatura'] . utf8_decode(' °C');
$ritmo_cardiaco = $_POST['ritmo_cardiaco'] . ' BPM';
$diagnostico = $_POST['diagnostico'];
$tratamiento = $_POST['tratamiento'];
$id_historia;

if ($hospitalizar == 'si') {

    $result = $_connection->execute("INSERT INTO historia(id_paciente,hospitalizacion)VALUES('$id_user',1)");
    $query = $_connection->execute("SELECT @@identity AS id");
    if ($row = mysqli_fetch_row($query)) {

        $id_historia = trim($row[0]);
        $_connection->execute("INSERT INTO hospitalizacion(id_historia,activa,id_enfermero)VALUES('$id_historia',1,'$id_enfermero')");
        $query2 = $_connection->execute("SELECT @@identity AS id");
        if ($row2 = mysqli_fetch_row($query2)) {

            $id_hospitalizacion = trim($row2[0]);

            $_connection->execute("INSERT INTO estado_paciente(tension,temperatura,ritmo_cardiaco,id_hospitalizacion, diagnostico, tratamiento, id_paciente,id_enfermero)VALUES('$tension','$temperatura','$ritmo_cardiaco','$id_hospitalizacion','$diagnostico','$tratamiento','$id_user','$id_enfermero')");
            $_connection->execute("INSERT INTO medico_historia(id_historia,id_medico)VALUES('$id_historia','$id_medico')");
        }
    }

    header('location: ../dashboard.php?message=Se añadio la historia correctamente');
    die();
} else {
    $result = $_connection->execute("INSERT INTO historia(id_paciente,hospitalizacion)VALUES('$id_user',0)");
    $query = $_connection->execute("SELECT @@identity AS id");
    if ($row = mysqli_fetch_row($query)) {

        $id_historia = trim($row[0]);

        $_connection->execute("INSERT INTO consulta_paciente(tension,temperatura,ritmo_cardiaco, diagnostico, tratamiento, id_paciente,id_historia)VALUES('$tension','$temperatura','$ritmo_cardiaco','$diagnostico','$tratamiento','$id_user','$id_historia')");
        $_connection->execute("INSERT INTO medico_historia(id_historia,id_medico)VALUES('$id_historia','$id_medico')");
    }
    header('location: ../dashboard.php?message=Se añadio la historia correctamente');
    die();
}
?>