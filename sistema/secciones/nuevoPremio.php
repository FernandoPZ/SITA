<?php include("../template/cabecera.php"); ?> <!-- Llama a la cabecera -->

<?php
include "../config/conexion.php"; // Realiza la coneccion de la bd
if(empty($_GET['id_d'])) // Valida si la clave del usuario no esta vacia
{
    header('location: verUsuario.php'); // Redirecciona a la lista de usuarios
    mysqli_close($conexion); // Cierra la conexion con la bd
}
$idDoc = $_GET['id_d']; // Almacena la clave del docente
$sql_docente = mysqli_query($conexion,"SELECT * FROM docente WHERE cve_docente = $idDoc");
while ($data_docente = mysqli_fetch_array($sql_docente)){
    $cuenta = $data_docente['cuenta']; // Guarda la cuenta asociada
}
if($_SESSION['tipo'] != 1) // Valida si el usuario es nivel administrador
{
    if($_SESSION['cve_usuario'] != $cuenta){
        header("location: /SITA/sistema/index.php"); // Redirecciona a la pagina pricipal
    }
}
$decision=(isset($_POST['decision']))?$_POST['decision']:""; // Boton de decision
$user = $_SESSION['cve_usuario']; // Guarda la clave de usuario con la que entra
?>

<?php
switch($decision){
    case "guardar": // Guargar
        if(!empty($_POST)) // Valida si los campos no esten vacios
        {
            $alert='';
            if(empty($_POST['nombre']) // Nivel de estudio
            || empty($_POST['fecha']) // Siglas del estudio
            || empty($_POST['institucion']) // Nombre de la institucion
            || empty($_POST['motivo']) // motivo correspondiente
            || empty($_POST['descripcion'])) // Habilidades del docente
            {
                $alert=' 
                <div class="alert alert-dismissible alert-warning">
                    <strong>Se te olvida algo...</strong> debes de llenar todos los campos.
                </div>
                '; // Alerta de algun campo vacio
            }else{
                $nombre = $_POST['nombre']; // Guarda el tipo de usuario
                $fecha = $_POST['fecha']; // Guarda el nombre del usuario
                $institucion = $_POST['institucion']; // Guarda el primer apellido del usuario
                $motivo = $_POST['motivo']; // Guarda el segundo apellido del usuario
                $descripcion = $_POST['descripcion']; // Guarda la foto del usuario
                // Inserta los datos en la tabla 
                $query_insert = mysqli_query($conexion,"INSERT INTO premios(nombre, fecha, institucion, motivo, descripcion, cve_docente, user_cve)
                                                                      VALUES ('$nombre','$fecha','$institucion','$motivo','$descripcion','$idDoc','$user')");
                if($query_insert){
                    $alert='
                    <div class="alert alert-dismissible alert-success">
                        <strong>Listo!</strong> El usuario se guardo correctamente.
                    </div>
                    '; // Alerta de que se guardo correctamente
                }else{
                    $alert='
                        <div class="alert alert-dismissible alert-danger">
                            <strong>Algo salio mal...</strong> El usuario no se pudo guardar.
                        </div>
                    '; // Alerta de algun problema al guardar el registro
                }
                mysqli_close($conexion); // Cierra conexion con la bd
            }
            break;
        }

    case "volver": // volver
        header('Location:/SITA/sistema/secciones/infDocente.php'); // Redirecciona a la lista de los usuarios
        mysqli_close($conexion); // Cierra conexion con la bd
    break;
}
?>

<title>SITA - Registrar premio</title> <!-- Llama al encabezado -->

            <div class="jumbotron">
                <h1 class="display-3">Registrar premio</h1>
                <hr class="my-2">
                <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div> <!-- Espacio para las alertas -->
                <form action="" method="POST" enctype="multipart/form-data"> <!-- "enctype" necesario para poder reconocer los archivos subidos -->
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Llene el siguiente formulario</h4>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Nombre del premio</label>
                                        <input type="text" class="form-control" name="nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : '';?>" placeholder="Indique el nivel de estudio finalizado">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Fecha de optencion</label>
                                        <input type="date" class="form-control" name="fecha" value="<?php echo isset($_POST['fecha']) ? $_POST['fecha'] : '';?>">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Nombre de la institucion</label>
                                        <input type="text" class="form-control" name="institucion" value="<?php echo isset($_POST['institucion']) ? $_POST['institucion'] : '';?>" placeholder="Nombre de la institucion del estudio">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class = "form-group col-md-6">
                                        <label class="form-label mt-2">Motivo del premio</label>
                                        <textarea class="form-control" name="motivo" id="motivo" rows="3" placeholder="Motivo aplicable"><?php echo isset($_POST['motivo']) ? $_POST['motivo'] : '';?></textarea>
                                    </div>
                                    <div class = "form-group col-md-6">
                                        <label class="form-label mt-2">Descripcion del premio</label>
                                        <textarea class="form-control" name="descripcion" id="descripcion" rows="3" placeholder="Descripcion del premio"><?php echo isset($_POST['descripcion']) ? $_POST['descripcion'] : '';?></textarea>
                                    </div>
                                </div>
                            <div class="text-center">
                                <br>
                                <button type="submit" name="decision" value="guardar" class="btn btn-primary" style="float: left;">Guardar</button> <!-- Guarda el registro -->
                                <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: right;">Volver</button> <!-- Redirecciona al listado de usuarios -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>

<?php include("../template/pie.php"); ?> <!-- Llama al pie de la pagina -->

<!--
--- Pagina[nuevoPremio] (Prototipo) ---
Ultima modificacion -- [29/06/2022 (14:45 hrs)]
-->