<?php // Funcinalidad de la fecha actual
date_default_timezone_set('America/Mexico_City'); // Zona horaria
function fechaC(){ // Definir el formato
	$mes = array("","Enero",
					"Febrero", 
					"Marzo", 
					"Abril", 
					"Mayo", 
					"Junio", 
					"Julio", 
					"Agosto", 
					"Septiembre", 
					"Octubre", 
					"Noviembre", 
					"Diciembre");
					return date('d')." de ". $mes[date('n')] . " de " . date('Y');
}
?>
<?php
session_start(); // Se inicia la sesion
if(!isset($_SESSION['usuario'])){ // Verifica que el usuario no esta vacio
	header("Location:/SITA/index.php"); // Redirecciona al login
}else{
	if($_SESSION['active']==true){ // Valida que la sesion este activa
		$iduser=$_SESSION['cve_usuario']; // Almacena la clave del usuario
		$s_tipo=$_SESSION["tipo"]; // Almacena el tipo de usuario
		$s_nombre=$_SESSION["nombre"]; // Almacena el id del usuario
		$s_apellido1=$_SESSION["apellido1"]; // Almacena el nombre de la foto del usuario
        $s_apellido2=$_SESSION['apellido2']; // Almacena el status del usuario
		$s_usuario=$_SESSION["usuario"]; // Almacena el id del usuario
		$s_foto=$_SESSION["foto"]; // Almacena el nombre de la foto del usuario
		$s_correo=$_SESSION["correo"]; // Almacena el tipo de usuario
        $s_activo=$_SESSION['activo']; // Almacena el status del usuario
	}
}
include "../config/conexion.php"; // Inicia la conexion con la bd
if(empty($_GET['id_d'])) // Valida si la clave del usuario no esta vacia
{
    header('location: verDocente.php'); // Redirecciona a la lista de usuarios
    mysqli_close($conexion); // Cierra la conexion con la bd
}
$idDoc = $_GET['id_d']; // Almacena la clave del docente
// Consulta todos los datos de la clave del docente
$sql_docente = mysqli_query($conexion,"SELECT d.cve_docente,
                                                d.nombre,
                                                d.apellido1,
                                                d.apellido2,
                                                d.foto,
                                                d.institucion,
                                                d.tipo_contratacion,
                                                d.fecha_ingreso,
                                                d.num_empleado,
                                                d.cuenta,
                                                d.fecha_add,
                                                d.user_cve,
                                                d.activo,
                                                (d.puesto) AS idpuesto,
                                                (p.puesto) AS puesto
                                                FROM docente d INNER JOIN puesto p ON d.puesto = p.cve_puesto WHERE cve_docente = $idDoc");
$result_sql_docente = mysqli_num_rows($sql_docente); // Almacena la cantidad todal de registros
while ($data_docente = mysqli_fetch_array($sql_docente))
{
    $idDoc = $data_docente['cve_docente']; // Guarda la clave del docente
    $puesto = $data_docente['puesto']; // Guarda el puesto del docente
    $idpuesto = $data_docente['idpuesto']; // Guarda la clave del puesto
    if($idpuesto == 1){ // Si la clave del puesto de usuario es 1 entonces es Profesor
        $option = '<option value="'.$idpuesto.'"select>'.$puesto.'</option>';
    }else if($idpuesto == 2){ // Si la clave del puesto de usuario es 2 entonces es Administrativo
        $option = '<option value="'.$idpuesto.'"select>'.$puesto.'</option>';
    }else if($idpuesto == 3){ // Si la clave del puesto de usuario es 3 entonces es Cordinador
        $option = '<option value="'.$idpuesto.'"select>'.$puesto.'</option>';
    }
    $nombre_DO = $data_docente['nombre']; // Guarda el nombre del docente
    $apellido1_DO = $data_docente['apellido1']; // Guarda el primer apellido del docente
    $apellido2_DO = $data_docente['apellido2']; // Guarda el segundo apellido del docente
    $foto_DO = $data_docente['foto']; // Guarda el nombre de la fotografia del docente
    $institucion_DO = $data_docente['institucion']; // Guarda el nombre de la institucion
    $tipo_contratacion_DO = $data_docente['tipo_contratacion']; // Guarda el tipo de contratacion
    $fecha_ingreso_DO = $data_docente['fecha_ingreso']; // Guarda la fecha de ingreso a la institucion
    $num_empleado_DO = $data_docente['num_empleado']; // Guarda el numero de empleado del docente
    $cuenta_DO = $data_docente['cuenta']; // Guarda la cuenta asociada
    $fecha_add_DO = $data_docente['fecha_add']; // Guarda la fecha de ingreso al sistema
    $user_cve_DO = $data_docente['user_cve']; // Guarda la clave del usuario que lo agrego
    $activo_DO = $data_docente['activo']; // Guarda el estatus del registro
}
if($s_tipo == 4) //Valida si es un usuario nivel administrador
{
    if($iduser != $cuenta_DO) //Valida si es un usuario nivel administrador
    {
        header("location: /SITA/sistema/index.php"); //Si no, regresa a la pagina principal
    }
}
// Consulta todos los datos de la tabla informacion
$sql_informacion = mysqli_query($conexion,"SELECT * FROM informacion WHERE cve_docente = $idDoc");
while ($data_informacion = mysqli_fetch_array($sql_informacion))
{
    $cve_info = $data_informacion['cve_info']; // Guarda la clave de informacion
    $fecha_nac_IN = $data_informacion['fecha_nac']; // Guarda la fecha de nacimiento del docente
    $doc_nac_IN = $data_informacion['doc_nac']; // Guarda el nombre del archivo del acta de nacimiento
    $genero_IN = $data_informacion['genero']; // Guarda el genero del docente
    $estado_civil_IN = $data_informacion['estado_civil']; // Guarda el estado civil del docente
    $nacionalidad_IN = $data_informacion['nacionalidad']; // Guarda la nacionalidad del docente
    $curp_IN = $data_informacion['curp']; // Guarda el CURP del docente
    $doc_curp_IN = $data_informacion['doc_curp']; // Guarda el nombre del archivo CURP del docente
    $rfc_IN = $data_informacion['rfc']; // Guarda el RFC del docente
    $doc_rfc_IN = $data_informacion['doc_rfc']; // Guarda el archivo RFC del docente
    $nss_IN = $data_informacion['nss']; // Guarda el numero de seguridad social del docente
}
// Consulta todos los datos de la tabla contacto
$sql_contacto = mysqli_query($conexion,"SELECT * FROM contacto WHERE cve_docente = $idDoc");
while ($data_contacto = mysqli_fetch_array($sql_contacto))
{
    $cve_contacto = $data_contacto['cve_contacto']; // Guarda la clave de contacto
    $correo_ins_CO = $data_contacto['correo_ins']; // Guarda el correo institucional del docente
    $correo_per_CO = $data_contacto['correo_per']; // Guarda el correo personal del docente
    $telefono_CO = $data_contacto['telefono']; // Guarda el numero de telefono del docente
}
// Consulta todos los datos de la tabla domicilio
$sql_domicilio = mysqli_query($conexion,"SELECT * FROM domicilio WHERE cve_docente = $idDoc");
while ($data_domicilio = mysqli_fetch_array($sql_domicilio))
{
    $cve_domicilio = $data_domicilio['cve_domicilio']; // Guarda la clave de domicilio
    $calle_DO = $data_domicilio['calle']; // Guarda el nombre de la calle
    $num_ext_DO = $data_domicilio['num_ext']; // Guarda el numero exterior
    $num_int_DO = $data_domicilio['num_int']; // Guarda el numero interior
    $codigo_postal_DO = $data_domicilio['codigo_postal']; // Guarda el codigo postal
    $colonia_DO = $data_domicilio['colonia']; // Guarda el nombre de la colonia
    $municipio_DO = $data_domicilio['municipio']; // Guarda el nombre del municipio
    $ciudad_DO = $data_domicilio['ciudad']; // Guarda el nombre de la ciudad
    $estado_DO = $data_domicilio['estado']; // Guarda el nombre del estado
    $pais_DO = $data_domicilio['pais']; // Guarda el nombre del pais
    $doc_dom_DO = $data_domicilio['doc_dom']; // Guarda el nombre del comprobante de domicilio
}
// Consulta todos los datos de la tabla viaje
$sql_viaje = mysqli_query($conexion,"SELECT * FROM viaje WHERE cve_docente = $idDoc");
while ($data_viaje = mysqli_fetch_array($sql_viaje))
{
    $cve_viaje = $data_viaje['cve_viaje']; // Guarda la clave de viaje
    $disp_viaje_VI = $data_viaje['disp_viaje']; // Guarda la disponibilidad de viaje
    $num_pasaporte_VI = $data_viaje['num_pasaporte']; // Guarda el numero de pasaporte del docente
    $fecha_ven_pas_VI = $data_viaje['fecha_ven_pas']; // Guarda la fecha de vencimiento del pasaporte
}
?>

<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV del docente</title> <!-- Titulo de la pagina -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="d-flex">
        <div></div>
        <div class="align-self-center"></div>
    </div>
    <div class="col bg-success" align="center">
        <div class = "col">
                <img src="http://<?php echo $_SERVER['HTTP_HOST'];?>/SITA/sistema/files/docente/foto/<?php echo $foto_DO; ?> " style="width: 150px; height:150px;">
            
            <h1><?php echo $nombre_DO;?> <?php echo $apellido1_DO;?> <?php echo $apellido2_DO;?></h1>
        </div>
        <div class = "col">
            <small><b>Información de contacto:</b></small>
            <br>
            <small><b>Correo: </b><span><?php echo $correo_per_CO;?></span></small>
            <small><b>Telefono: </b><span><?php echo $telefono_CO;?></span></small>
        </div>
        <div class = "col">
            <small><b>Direccion:</b></small>
            <br>
            <small><span><?php echo $calle_DO;?> No. <?php echo $num_ext_DO;?> CP. <?php echo $codigo_postal_DO;?> Col. <?php echo $colonia_DO;?></span></small>
            <br>
            <small><span><?php echo $ciudad_DO;?> <?php echo $estado_DO;?>, <?php echo $pais_DO;?>.</span></small>
            <br>
        </div>
    </div>
    <?php
    $sql_formacion = mysqli_query($conexion, "SELECT * FROM formacion WHERE activo = 1 AND cve_docente = $idDoc");
    $result = mysqli_num_rows($sql_formacion); // Calcula el numero de filas de la consulta
    if($result > 0){ // Valida si el numero de consultas es mayor a cero
    ?>
    <div class="col bg-secondary text-white" align="center">
        <div class = "col">
            <b>Educación</b>
            <hr>
            <?php
            while ($data_formacion = mysqli_fetch_array($sql_formacion))
            {
            ?>
                <small><span>[<?php echo $data_formacion['fecha_inicio'];?> - <?php echo $data_formacion['fecha_fin'];?>]</span></small>
                <br>
                <small><span><b><?php echo $data_formacion['nivel_estudio'];?></b> (<?php echo $data_formacion['siglas_estudio'];?>)</span></small>
                <br>
                <small><span><i><?php echo $data_formacion['institucion'];?></i></span></small>
                <br>
                <small><span><?php echo $data_formacion['habilidades'];?></span></small>
                <hr>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    }
    ?>
    <?php
    $sql_experiencia = mysqli_query($conexion, "SELECT * FROM experiencia WHERE activo = 1 AND cve_docente = $idDoc");
    $result = mysqli_num_rows($sql_experiencia); // Calcula el numero de filas de la consulta
    if($result > 0){ // Valida si el numero de consultas es mayor a cero
    ?>
    <div class="col bg-info text-white" align="center">
        <div class = "col">
            <b>Experiencia</b>
            <hr>
            <?php
            while ($data_experiencia = mysqli_fetch_array($sql_experiencia))
            {
            ?>
                <small><span>[<?php echo $data_experiencia['periodo'];?>]</span></small>
                <br>
                <small><span><b><?php echo $data_experiencia['actividad'];?></b></span></small>
                <br>
                <small><span><i><?php echo $data_experiencia['institucion'];?></i></span></small>
                <br>
                <small><span><?php echo $data_experiencia['intereses'];?></span></small>
                <hr>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    }
    ?>
    <?php
    $sql_premios = mysqli_query($conexion, "SELECT * FROM premios WHERE activo = 1 AND cve_docente = $idDoc");
    $result = mysqli_num_rows($sql_premios); // Calcula el numero de filas de la consulta
    if($result > 0){ // Valida si el numero de consultas es mayor a cero
    ?>
    <div class="col bg-warning text-white" align="center">
        <div class = "col">
            <b>Premios</b>
            <hr>
            <?php
            $sql_premios = mysqli_query($conexion, "SELECT * FROM premios WHERE activo = 1 AND cve_docente = $idDoc");
            while ($data_premios = mysqli_fetch_array($sql_premios))
            {
            ?>
                <small><span>[<?php echo $data_premios['fecha'];?>]</span></small>
                <br>
                <small><span><b><?php echo $data_premios['nombre'];?></b></span></small>
                <br>
                <small><span><i><?php echo $data_premios['institucion'];?></i></span></small>
                <br>
                <small><span><?php echo $data_premios['motivo'];?></span></small>
                <br>
                <small><span><?php echo $data_premios['descripcion'];?></span></small>
                <hr>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    }
    ?>
    <?php
    $sql_publicaciones = mysqli_query($conexion, "SELECT * FROM publicaciones WHERE activo = 1 AND cve_docente = $idDoc");
    $result = mysqli_num_rows($sql_publicaciones); // Calcula el numero de filas de la consulta
    if($result > 0){ // Valida si el numero de consultas es mayor a cero
    ?>
    <div class="col bg-dark text-white" align="center">
        <div class = "col">
            <b>Publicaciones</b>
            <hr>
            <?php
            while ($data_publicaciones = mysqli_fetch_array($sql_publicaciones))
            {
            ?>
                <small><span>[<?php echo $data_publicaciones['fecha_publicacion'];?>]</span></small>
                <br>
                <small><span><b><?php echo $data_publicaciones['titulo_articulo'];?></b></span></small>
                <br>
                <small><span><i><?php echo $data_publicaciones['autor'];?></i></span></small>
                <br>
                <small><span><?php echo $data_publicaciones['proposito'];?></span></small>
                <hr>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    }
    ?>
    <footer class="bg-light bg-gradient"> <!-- Mensaje de pie de pagina (Fondo negro) -->
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <br> <!-- Salto de linea -->
                    <b><small>CV del docente <i><?php echo $nombre_DO?> <?php echo $apellido1_DO?> <?php echo $apellido2_DO?></i></small></b><br>
                    <small>Generado el <b><?php echo fechaC(); ?></small></b><br>
                    <small>Por el usuario <b><?php echo $s_usuario; ?></small></b><br>
                    <small>Sistema Integral de Trayectoria Académica (SITA)</small><br>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
<?php
$html=ob_get_clean();
//echo $html;

require_once '../libreria/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('letter');
$dompdf->render();
$fecha= new DateTime(); // Determina la fecha actual
$dompdf->stream("CV".$num_empleado_DO."_".$fecha->getTimestamp().".pdf", array("Attachment" => false));
?>

<!--
--- Generador[generarCV] (Prototipo) ---
Ultima modificacion -- [10/08/2022 (12:57 hrs)]
-->