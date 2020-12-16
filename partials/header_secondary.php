<?php
require_once "../database/conexion_db.php";

$user = null;
if (isset($_SESSION['user_id'])) {
    $_connection = Connection::getInstance();
    $records = $_connection->execute("SELECT * FROM users WHERE id =" . $_SESSION['user_id']);
    $results = $records->fetch_array(MYSQLI_ASSOC);

    if (count($results) > 0) {
        $user = $results;
    }
}

?>




<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fixed-top">
    <div class="container-fluid">
        <a href="#" id="mostrar-nav"><img src="../public/img/menu.png" style="z-index: 30;" alt=""></a>
        <a href="../index.php" id="ancla2"><img id="imag" class="navbar-brand" src="../public/img/logo.png" alt="logo"></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $user['nombres'] . ' ' . $user['apellidos'] ?> &nbsp;
                        <?php if ($user['tipo_user'] == 0) {
                            echo '<b>[Admin]</b>';
                        } elseif ($user['tipo_user'] == 1) {
                            echo '<b>[Medico]</b>';
                        } elseif ($user['tipo_user'] == 2) {
                            echo '<b>[Enfermero]</b>';
                        } else {
                            echo '<b>[Paciente]</b>';
                        } ?>
                        <img src="../<?php echo $user['profile_img'] ?>" style="border-radius: 50%; padding:2%" title="user" alt="user" width="40px" height="40px">
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="../functionality/editar_user.php?id=<?php echo $user['id'] ?>">Editar Datos</a>
                        <a class="dropdown-item" data-href="../functionality/upload_photo.php?id=<?php echo $user['id'] ?>" data-toggle="modal" data-target="#upload-photo">Actualizar Foto de Perfil</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../functionality/logout.php">Cerrar sesion <img src="../public/img/logout.png" alt="logout"></a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Modal -->
<div class="modal fade" id="upload-photo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizando Foto de Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="file" id="fileToUpload" onchange="upload_image2();">
                    <b><p class="help-block">para subir</p></b>
                </div>
            </div>
            <div class="modal-footer">
            <div class="upload-msg"></div>
                <button type="button" class="btn btn-info" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>