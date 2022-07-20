<?php include("../template/cabecera.php"); ?> <!-- Llama a la cabecera -->

<?php
include "../config/conexion.php"; // Realiza la coneccion de la bd
if((empty($_GET['id_d'])) || (empty($_GET['id_f']))) // Valida si la clave del usuario no esta vacia
{
    header('location: verUsuario.php'); // Redirecciona a la lista de usuarios
    mysqli_close($conexion); // Cierra la conexion con la bd
}
$idDoc = $_GET['id_d']; // Almacena la clave del docente
$idFor = $_GET['id_f']; // Almacena la clave del docente
$sql_formacion = mysqli_query($conexion,"SELECT * FROM formacion WHERE cve_formacion = $idFor");
$result = mysqli_num_rows($sql_formacion); // Almacena la cantidad todal de registros
if($result == 0){ // Verifica que la cantidad no este vacia
    header('Location: verUsuario.php'); // Redirecciona a la lista de usuarios
}else{
    while ($data = mysqli_fetch_array($sql_formacion)){
        $cve_formacion = $data['cve_formacion']; // Guarda la clave del usuario
        $nivel_estudio = $data['nivel_estudio']; // Guarda la clave del tipo de usuario
        $siglas_estudio = $data['siglas_estudio']; // Guarda el nombre del tipo de usuario
        $institucion = $data['institucion']; // Guarda el nombre del usuario
        $area = $data['area']; // Guarda el primer apellido del usuario
        $disciplina = $data['disciplina']; // Guarda el segundo apellido del usuario
        $pais = $data['pais']; // Guarda el nombre de la fotografia del usuario
        $fecha_inicio = $data['fecha_inicio']; // Guarda el ID del usuario
        $fecha_fin = $data['fecha_fin']; // Guarda el correo del usuario
        $fecha_titulacion = $data['fecha_titulacion']; // Guarda el correo del usuario
        $habilidades = $data['habilidades']; // Guarda el segundo apellido del usuario
        $cve_docente = $data['cve_docente']; // Guarda el nombre de la fotografia del usuario
        $fecha_add = $data['fecha_add']; // Guarda el ID del usuario
        $user_cve = $data['user_cve']; // Guarda el correo del usuario
        $activo = $data['activo']; // Guarda el correo del usuario
    }
}
if($_GET['id_d'] != $idDoc){
    header("location: /SITA/sistema/index.php"); // Redirecciona a la pagina pricipal
}
$decision=(isset($_POST['decision']))?$_POST['decision']:""; // Boton de decision
?>

<?php
switch($decision){
    case "actualizar": // Actualizar
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
                $sql_update = mysqli_query($conexion,"UPDATE formacion SET nivel_estudio = '$nivel_estudio',
                                                                           siglas_estudio = '$siglas_estudio',
                                                                           institucion = '$institucion',
                                                                           area = '$area',
                                                                           disciplina = '$disciplina',
                                                                           pais = '$pais',
                                                                           fecha_inicio = '$fecha_inicio',
                                                                           fecha_fin = '$fecha_fin',
                                                                           fecha_titulacion = '$fecha_titulacion',
                                                                           habilidades = '$habilidades',
                                                                           cve_docente = '$cve_docente',
                                                                           user_cve = '$user_cve'
                                                                           WHERE cve_docente = '$idDoc'");
                if($sql_update){
                    $alert='
                    <div class="alert alert-dismissible alert-success">
                        <strong>Listo!</strong> La informacion se actualizó correctamente.
                    </div>
                    '; // Alerta de que se guardo correctamente
                }else{
                    $alert='
                        <div class="alert alert-dismissible alert-danger">
                            <strong>Algo salio mal...</strong> La informacion no se pudo actualizar.
                        </div>
                    '; // Alerta de algun problema al actualizar el registro
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

<title>SITA - Registrar formacion</title> <!-- Llama al encabezado -->

            <div class="jumbotron">
                <h1 class="display-3">Registrar formacion</h1>
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
                                        <label class="form-label mt-2">Nivel de estudios</label>
                                        <input type="text" class="form-control" name="nivel_estudio" value="<?php echo $nivel_estudio; ?>" placeholder="Indique el nivel de estudio finalizado">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Siglas del estudio</label>
                                        <input type="text" class="form-control" name="siglas_estudio" value="<?php echo $siglas_estudio; ?>" placeholder="Escriba las siglas del estudio">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Nombre de la institucion</label>
                                        <input type="text" class="form-control" name="institucion" value="<?php echo $institucion; ?>" placeholder="Nombre de la institucion del estudio">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Area aplicable</label>
                                        <input type="text" class="form-control" name="area" value="<?php echo $area; ?>" placeholder="Area aplicable">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Disciplina aplicable</label>
                                        <input type="text" class="form-control" name="disciplina" value="<?php echo $disciplina; ?>" placeholder="Disciplina aplicable">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Pais donde se realizó</label>
                                        <input type="text" class="form-control" name="pais" value="<?php echo $pais; ?>" placeholder="Pais donde se realizo el estudio">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Fecha de inicio del estudio</label>
                                        <input type="date" class="form-control" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Fecha de conclusion del estudio</label>
                                        <input type="date" class="form-control" name="fecha_fin" value="<?php echo $fecha_fin; ?>">
                                    </div>
                                    <div class = "form-group col-md-4">
                                    <label class="form-label mt-2">Fecha cuando se liberó el titulo</label>
                                        <input type="date" class="form-control" name="fecha_titulacion" value="<?php echo $fecha_titulacion; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class = "form-group col-md-10 mx-auto">
                                        <label class="form-label mt-2">Habilidades aprendidas en la formacion</label>
                                        <textarea class="form-control" name="habilidades" id="habilidades" rows="3" placeholder="Hablilidad 1, habilidad 2, habilidad..."><?php echo $habilidades; ?></textarea>
                                    </div>
                                </div>
                            <div class="text-center">
                                <br>
                                <button type="submit" name="decision" value="actualizar" class="btn btn-primary" style="float: left;">actualizar</button> <!-- Guarda el registro -->
                                <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: right;">Volver</button> <!-- Redirecciona al listado de usuarios -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>

<?php include("../template/pie.php"); ?> <!-- Llama al pie de la pagina -->

<!--
--- Pagina[editarFormacion] (Prototipo) ---
Ultima modificacion -- [13/07/2022 (12:10 hrs)]
-->