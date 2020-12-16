<?php
require('../assets/fpdf/fpdf.php');
session_start();
require '../database/conexion_db.php';
$_connection = Connection::getInstance();
$user = null;
$datos_user = null;
$enfermero = null;
$hospitalizacion = null;
$medico = null;
if (isset($_SESSION['user_id'])) {
    $_connection = Connection::getInstance();
    $records = $_connection->execute("SELECT * FROM users WHERE id =" . $_SESSION['user_id']);
    $results = $records->fetch_array(MYSQLI_ASSOC);
    $id_historia = $_GET['id'];

    $id_historia = $_GET['id'];
    $hosp = $_connection->execute("select hospitalizacion from historia where id = '$id_historia'");
    $hosp = $hosp->fetch_array(MYSQLI_ASSOC);

    if (count($results) > 0) {
        $user = $results;
    }
    $activa = '';
    if ($hosp['hospitalizacion']) {
        $query = $_connection->execute("SELECT estado_paciente.tension,estado_paciente.temperatura,estado_paciente.ritmo_cardiaco,estado_paciente.diagnostico,estado_paciente.tratamiento,estado_paciente.id_enfermero,historia.id,historia.id_paciente,historia.fecha,historia.hospitalizacion,hospitalizacion.activa,users.nombres,users.apellidos,users.sexo,users.documento,users.tipo_documento,users.fecha_nac,medico_historia.id_medico FROM estado_paciente INNER JOIN hospitalizacion ON estado_paciente.id_hospitalizacion = hospitalizacion.id INNER JOIN historia ON hospitalizacion.id_historia = historia.id INNER JOIN users ON historia.id_paciente = users.id INNER JOIN medico_historia ON historia.id = medico_historia.id_historia WHERE hospitalizacion.id_historia = '$id_historia'");
        $datos_user = mysqli_fetch_assoc($query);
        $enfermero = $_connection->execute("SELECT nombres, apellidos from users where id =" . $datos_user['id_enfermero']);
        $enfermero = mysqli_fetch_assoc($enfermero);
        $enfermero = $enfermero['nombres'] . ' ' . $enfermero['apellidos'];
        $hospitalizacion = 'SI';
        $medico = $_connection->execute("SELECT nombres, apellidos from users where id =" . $datos_user['id_medico']);
        $medico = mysqli_fetch_assoc($medico);
        $medico = $medico['nombres'] . ' ' . $medico['apellidos'];
        if ($datos_user['activa']) {
            $activa = 'El servicio esta activo';
        } else {
            $activa = 'El servicio no se encuentra activo';
        }
    } else {

        $query1 = $_connection->execute("SELECT consulta_paciente.tension,consulta_paciente.temperatura,consulta_paciente.ritmo_cardiaco,consulta_paciente.diagnostico,consulta_paciente.tratamiento,historia.id,historia.id_paciente,historia.fecha,historia.hospitalizacion,users.nombres,users.apellidos,users.documento,users.tipo_documento,users.sexo,users.fecha_nac,medico_historia.id_medico FROM consulta_paciente INNER JOIN historia ON consulta_paciente.id_historia = historia.id INNER JOIN users ON historia.id_paciente = users.id INNER JOIN medico_historia ON historia.id = medico_historia.id_historia WHERE consulta_paciente.id_historia = '$id_historia'");
        $datos_user = mysqli_fetch_assoc($query1);
        $enfermero = 'Ninguno';
        $hospitalizacion = 'NO';
        $medico = $_connection->execute("SELECT nombres, apellidos from users where id =" . $datos_user['id_medico']);
        $medico = mysqli_fetch_assoc($medico);
        $medico = $medico['nombres'] . ' ' . $medico['apellidos'];
        $activa = 'El servicio no se encuentra activo';
    }
    $fechaint =  strtotime($datos_user['fecha_nac']);
    $fecha_nac = date("Y", $fechaint);
    $anio_act = date("Y");
    $edad_paciente = $anio_act - $fecha_nac;
    $f_nacimiento = strftime("%d de %B del %Y", strtotime($datos_user['fecha_nac']));
    $fecha_h =  strtotime($datos_user['fecha']);
    $fecha_historia = date("Y / m / d", $fecha_h);
}


class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('../public/img/logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(40);
    // Título
    $this->Cell(150,10,'Hospital Local UFPS - Reporte Clinico',1,0,'C');
    
    // Salto de línea
    $this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'HOSPITAL UFPS '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->SetTitle('historia-orden');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Line(10,33 ,197,33);
$pdf->Ln(6);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(18,8,utf8_decode('Historia '),0,0);
$pdf->SetFont('Arial','I',12);
$pdf->Cell(20,8,'(Orden)',0,0);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(28,8,'Fecha Visita: ',0,0);
$pdf->SetFont('Arial','I',12);
$pdf->Cell(34,8,$fecha_historia,0,0);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(22,8,'Paciente: ',0,0);
$pdf->SetFont('Arial','I',12);
$pdf->Cell(48,8,$datos_user['nombres'].' '.$datos_user['apellidos'],0,0);

$pdf->Ln(12);
$pdf->Line(10, 46,197,46);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,8,'Documento: ',0,0);
$pdf->SetFont('Arial','I',12);
$pdf->Cell(50,8,$datos_user['documento'],0,0);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(38,8,'Tipo Documento: ',0,0);
$pdf->SetFont('Arial','I',12);
$pdf->Cell(35,8,$datos_user['tipo_documento'],0,0);


$pdf->Ln(12);
$pdf->Line(10, 59,197,59);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,8,'Fecha Nacimiento: ',0,0);
$pdf->SetFont('Arial','I',12);
$pdf->Cell(55,8,$f_nacimiento,0,0);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(17,8,'Edad: ',0,0);
$pdf->SetFont('Arial','I',12);
$pdf->Cell(15,8,$edad_paciente,0,0);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,8,'Sexo: ',0,0);
$pdf->SetFont('Arial','I',12);
$pdf->Cell(20,8,$datos_user['sexo'],0,0);

$pdf->Ln(12);
$pdf->Line(10, 71,197,71);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,8,'Medico: ',0,0);
$pdf->SetFont('Arial','I',12);
$pdf->Cell(70,8,$medico,0,0);


$pdf->SetFont('Arial','B',12);
$pdf->Cell(37,8,'Hospitalizacion: ',0,0);
$pdf->SetFont('Arial','I',12);
$pdf->Cell(30,8,$hospitalizacion,0,0);

$pdf->Ln(17);


$pdf->SetFont('Arial','B');
$pdf->Cell(35,14,'DIAGNOSTICO: ',0,0,'L');

$pdf->Rect(10, 90, 191, 18);

$pdf->SetFont('Arial','');
$pdf->Cell(100,14,$datos_user['diagnostico'],0,0);

$pdf->Ln(26);
$pdf->SetFont('','B');
$pdf->Cell(30,8,'ITEM',1,0,'C');
$pdf->Cell(124,8,'DETALLE DEL SERVICIO',1,0,'C');

$pdf->Cell(37,8,'EN LETRAS',1,0,'C',0);
$pdf->Ln(8);
$pdf->SetFont('Arial','');
$pdf->Cell(30,8,'1',1,0,'C');
$pdf->Cell(124,8,$datos_user['tratamiento'],1,0,'C');
$pdf->Cell(37,8,'UNO',1,0,'C');


$pdf->Line(135, 170,199,170);
$pdf->Line(135, 170,199,170);
$pdf->SetFont('Times','I');
$pdf->Ln(41);
$pdf->Cell(0,8,$medico,0,0,'R');
$pdf->Ln(5);
$pdf->Cell(0,8,utf8_decode('Tarjeta Medica n° 592'),0,0,'R');
$pdf->Ln(5);
$pdf->SetFont('Arial','B');
$pdf->Cell(0,8,'MEDICINA GENERAL',0,0,'R');


$pdf->Output();


?>

