
<?php

if (!isset($_SESSION['user_id'])) {
    header('location: ../index.php');
   
} else {
    
    $id = $_SESSION['user_id'];
    
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $records = $_connection->execute($sql);
    $data = $records->fetch_array(MYSQLI_ASSOC);
    $fechaint =  strtotime($data['fecha_nac']);
    $fecha_nac = date("Y", $fechaint);
    $anio_act = date("Y");
    $edad = $anio_act - $fecha_nac;


   
}
?>



<section class="mostrar">
    <ul class="menu">
        <li><a href="#"><b>Nombres:</b> &nbsp;<?php echo $data['nombres']?></a></li>
        <li><a href="#"><b>Apellidos:</b> &nbsp;<?php echo $data['apellidos']?></a></li>
        <li><a href="#"><b>Edad: </b>&nbsp;<?php echo $edad?></a></li>
        <li><a href="#"><b>F. Nacimiento:</b> &nbsp;<?php echo $data['fecha_nac']?></a></li>
        <li><a href="#"><b>Sexo:</b> &nbsp;<?php echo $data['sexo']?></a></li>
    </ul>
</section>