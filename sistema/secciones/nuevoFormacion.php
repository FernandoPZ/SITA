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
        header("location: /sistema/index.php"); // Redirecciona a la pagina pricipal
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
            if(empty($_POST['nivel_estudio']) // Nivel de estudio
            || empty($_POST['siglas_estudio']) // Siglas del estudio
            || empty($_POST['institucion']) // Nombre de la institucion
            || empty($_POST['area']) // area correspondiente
            || empty($_POST['disciplina']) // Disiplina del curso
            || empty($_POST['pais']) // Pais donde cursó el curso
            || empty($_POST['fecha_inicio']) // Fecha de inicio de curso
            || empty($_POST['fecha_fin']) // Fecha de fin de curso
            || empty($_POST['fecha_titulacion']) // Fecha de la titulacion
            || empty($_POST['habilidades'])) // Habilidades del docente
            {
                $alert=' 
                <div class="alert alert-dismissible alert-warning">
                    <strong>Se te olvida algo...</strong> debes de llenar todos los campos.
                </div>
                '; // Alerta de algun campo vacio
            }else{
                $nivel_estudio = $_POST['nivel_estudio']; // Guarda el tipo de usuario
                $siglas_estudio = $_POST['siglas_estudio']; // Guarda el nombre del usuario
                $institucion = $_POST['institucion']; // Guarda el primer apellido del usuario
                $area = $_POST['area']; // Guarda el segundo apellido del usuario
                $disciplina = $_POST['disciplina']; // Guarda la foto del usuario
                $pais = $_POST['pais']; // Guarda el ID del usuario
                $fecha_inicio = $_POST['fecha_inicio']; // Guarda la contraseña del usuario
                $fecha_fin = $_POST['fecha_fin']; // Guarda la verificacion de contraseña del usuario
                $fecha_titulacion = $_POST['fecha_titulacion']; // Guarda el correo del usuario
                $habilidades = $_POST['habilidades']; // Guarda el correo del usuario
                // Inserta los datos en la tabla 
                $query_insert = mysqli_query($conexion,"INSERT INTO formacion(nivel_estudio, siglas_estudio, institucion, area, disciplina, pais, fecha_inicio, fecha_fin, fecha_titulacion, habilidades, cve_docente, user_cve)
                                                                      VALUES ('$nivel_estudio','$siglas_estudio','$institucion','$area','$disciplina','$pais','$fecha_inicio','$fecha_fin','$fecha_titulacion','$habilidades','$idDoc','$user')");
                if($query_insert){
                    $alert='
                    <div class="alert alert-dismissible alert-success">
                        <strong>Listo!</strong> El usuario se guardó correctamente.
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
        header('Location:/sistema/secciones/infDocente.php'); // Redirecciona a la lista de los usuarios
        mysqli_close($conexion); // Cierra conexion con la bd
    break;
}
?>

<title>SITA - Registrar formación</title> <!-- Llama al encabezado -->

            <div class="jumbotron">
                <h1 class="display-3">Registrar formación</h1>
                <hr class="my-2">
                <a><?php echo isset($alert) ? $alert : ''; ?></a> <!-- Espacio para las alertas -->
                <form action="" method="POST" enctype="multipart/form-data"> <!-- "enctype" necesario para poder reconocer los archivos subidos -->
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Llene el siguiente formulario</h4>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Nivel de estudios</label>
                                        <input type="text" class="form-control" name="nivel_estudio" value="<?php echo isset($_POST['nivel_estudio']) ? $_POST['nivel_estudio'] : '';?>" placeholder="Indique el nivel de estudio finalizado">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Siglas del estudio</label>
                                        <input type="text" class="form-control" name="siglas_estudio" value="<?php echo isset($_POST['siglas_estudio']) ? $_POST['siglas_estudio'] : '';?>" placeholder="Escriba las siglas del estudio">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Nombre de la institución</label>
                                        <input type="text" class="form-control" name="institucion" value="<?php echo isset($_POST['institucion']) ? $_POST['institucion'] : '';?>" placeholder="Nombre de la institución del estudio">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Área aplicable</label>
                                        <input type="text" class="form-control" name="area" value="<?php echo isset($_POST['area']) ? $_POST['area'] : '';?>" placeholder="Área aplicable">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Disciplina aplicable</label>
                                        <input type="text" class="form-control" name="disciplina" value="<?php echo isset($_POST['disciplina']) ? $_POST['disciplina'] : '';?>" placeholder="Disciplina aplicable">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">País donde se realizó</label>
                                        <input type="text" class="form-control" name="pais" value="<?php echo isset($_POST['pais']) ? $_POST['pais'] : '';?>" placeholder="Pais donde se realizó el estudio">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Fecha de inicio del estudio</label>
                                        <input type="date" class="form-control" name="fecha_inicio" value="<?php echo isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';?>">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Fecha de conclusión del estudio</label>
                                        <input type="date" class="form-control" name="fecha_fin" value="<?php echo isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';?>">
                                    </div>
                                    <div class = "form-group col-md-4">
                                    <label class="form-label mt-2">Fecha cuando se liberó el titulo</label>
                                        <input type="date" class="form-control" name="fecha_titulacion" value="<?php echo isset($_POST['fecha_titulacion']) ? $_POST['fecha_titulacion'] : '';?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class = "form-group col-md-10 mx-auto">
                                        <label class="form-label mt-2">Habilidades aprendidas en la formación</label>
                                        <textarea class="form-control" name="habilidades" id="habilidades" rows="3" placeholder="Hablilidad 1, habilidad 2, habilidad..."><?php echo isset($_POST['habilidades']) ? $_POST['habilidades'] : '';?></textarea>
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
--- Pagina[nuevoFormacion] (Prototipo) ---
Ultima modificacion -- [31/08/2022 (14:44 hrs)]
-->