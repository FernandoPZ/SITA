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
if($_SESSION['tipo'] != 1) //Valida si es un usuario nivel administrador
{
    header("location: /SITA/sistema/index.php"); //Si no, regresa a la pagina principal
}
?>

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
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITA - Reporte Docentes</title> <!-- Titulo de la pagina -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <h1 class="display-5">Lista de Docentes</h1>
    <table class="table table-hover">
        <thead>
            <tr class="text-center"> <!-- Nombre de los campos a mostrar -->
                <th scope="col">Clave</th>
                <th scope="col">Foto</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido 1</th>
                <th scope="col">Apellido 2</th>
                <th scope="col">Puesto</th>
                <th scope="col">Numero</th>
            </tr>
        </thead>
        <?php
            // Realiza la consulta de los datos a mostrar en la lista
            $query = mysqli_query($conexion, "SELECT d.cve_docente,
                                                        p.puesto,
                                                        d.nombre,
                                                        d.apellido1,
                                                        d.apellido2,
                                                        d.foto,
                                                        d.num_empleado
                                                        FROM docente d INNER JOIN puesto p ON d.puesto = p.cve_puesto
                                                        WHERE d.activo = 1
                                                        ORDER BY cve_docente");
            mysqli_close($conexion); // Cierra la conexion con la bd
            $result = mysqli_num_rows($query); // Calcula el numero de filas de la consulta
            if($result > 0){ // Valida si el numero de consultas es mayor a cero
                while ($data = mysqli_fetch_array($query)){ // Crea un bucle para mostrar los resultados
                    ?>
                    <tbody class="text-center">
                        <tr class="table-active"> <!-- Campos a llenar -->
                        <th scope="row"><?php echo $data ['cve_docente']; ?></th> <!-- Clave del docente -->
                        <td><img class="" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/SITA/sistema/files/docente/foto/<?php echo $data ['foto']; ?> " width="50" alt="" srcset=""></td> <!-- Fotografia del docente -->
                        <td><?php echo $data ['nombre']; ?></td> <!-- Nombre del docente -->
                        <td><?php echo $data ['apellido1']; ?></td> <!-- Primer apellido del docente -->
                        <td><?php echo $data ['apellido2']; ?></td> <!-- Segundo apellido del docente -->
                        <td><?php echo $data ['puesto']; ?></td> <!-- Puesto asignado -->
                        <td><?php echo $data ['num_empleado']; ?></td> <!-- Numero de empleado -->
                        </tr>
                    </tbody>
                    <?php
                }
            }
        ?>
    </table>
    <?php if($result == 0){ ?> <!-- Valida si no hay registros para mostrar -->
        <div class="alert alert-dismissible alert-light mx-auto"> <!-- Muestra un mensaje de aviso si no hay docentes registrados -->
            <h4 class="alert-heading text-center">No hay docentes registrados</h4>
        </div>
    <?php } ?>
    <footer class="bg-light bg-gradient"> <!-- Mensaje de pie de pagina (Fondo negro) -->
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <br> <!-- Salto de linea -->
                    <p class="text-center"><b>Reporte de docentes en el sistema</b></p>
                    <p class="text-center">Generado el <b><?php echo fechaC(); ?></b></p>
                    <p class="text-center">Por el usuario <b><?php echo $s_usuario; ?></b><br></p>
                    <p class="text-center">Sistema Integral de Trayectoria Académica (SITA)</p>
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
$dompdf->stream("reporteDocente_".$fecha->getTimestamp().".pdf", array("Attachment" => false));
?>

<!--
--- Generador[reporteDocente] (Prototipo) ---
Ultima modificacion -- [10/08/2022 (14:10 hrs)]
-->