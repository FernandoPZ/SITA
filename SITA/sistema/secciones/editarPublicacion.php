<?php include("../template/cabecera.php"); ?> <!-- Llama a la cabecera -->

<?php
include "../config/conexion.php"; // Realiza la coneccion de la bd
if((empty($_GET['id_d'])) || (empty($_GET['id_pu']))) // Valida si la clave del usuario no esta vacia
{
    header('location: verUsuario.php'); // Redirecciona a la lista de usuarios
    mysqli_close($conexion); // Cierra la conexion con la bd
}
$idDoc = $_GET['id_d']; // Almacena la clave del docente
$idPub = $_GET['id_pu']; // Almacena la clave del docente
$sql_publicacion = mysqli_query($conexion,"SELECT * FROM publicaciones WHERE cve_publicacion = $idPub");
$result = mysqli_num_rows($sql_publicacion); // Almacena la cantidad todal de registros
if($result == 0){ // Verifica que la cantidad no este vacia
    header('Location: verUsuario.php'); // Redirecciona a la lista de usuarios
}else{
    while ($data = mysqli_fetch_array($sql_publicacion)){
        $cve_publicacion = $data['cve_publicacion']; // Guarda la clave del usuario
        $tipo = $data['tipo']; // Guarda la clave del tipo de usuario
        $autor = $data['autor']; // Guarda el nombre del tipo de usuario
        $titulo_articulo = $data['titulo_articulo']; // Guarda el nombre del usuario
        $titulo_revista = $data['titulo_revista']; // Guarda el primer apellido del usuario
        $pagina_inicio = $data['pagina_inicio']; // Guarda el segundo apellido del usuario
        $pagina_fin = $data['pagina_fin']; // Guarda el nombre de la fotografia del usuario
        $pais = $data['pais']; // Guarda el ID del usuario
        $editorial = $data['editorial']; // Guarda el correo del usuario
        $volumen = $data['volumen']; // Guarda el correo del usuario
        $fecha_publicacion = $data['fecha_publicacion']; // Guarda la clave del usuario
        $proposito = $data['proposito']; // Guarda la clave del tipo de usuario
        $estado = $data['estado']; // Guarda el nombre del tipo de usuario
        $cve_docente = $data['cve_docente']; // Guarda el nombre del usuario
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
            if(empty($_POST['tipo']) // Nivel de estudio
            || empty($_POST['autor']) // Siglas del estudio
            || empty($_POST['titulo_articulo']) // Nombre de la titulo_articulo
            || empty($_POST['titulo_revista']) // titulo_revista correspondiente
            || empty($_POST['pagina_inicio']) // titulo_revista correspondiente
            || empty($_POST['pagina_fin']) // titulo_revista correspondiente
            || empty($_POST['pais']) // titulo_revista correspondiente
            || empty($_POST['editorial']) // titulo_revista correspondiente
            || empty($_POST['volumen']) // titulo_revista correspondiente
            || empty($_POST['fecha_publicacion']) // titulo_revista correspondiente
            || empty($_POST['proposito']) // titulo_revista correspondiente
            || empty($_POST['estado'])) // Habilidades del docente
            {
                $alert=' 
                <div class="alert alert-dismissible alert-warning">
                    <strong>Se te olvida algo...</strong> debes de llenar todos los campos.
                </div>
                '; // Alerta de algun campo vacio
            }else{
                $tipo = $_POST['tipo']; // Nivel de estudio
                $autor = $_POST['autor']; // Siglas del estudio
                $titulo_articulo = $_POST['titulo_articulo']; // Nombre de la titulo_articulo
                $titulo_revista = $_POST['titulo_revista']; // titulo_revista correspondiente
                $pagina_inicio = $_POST['pagina_inicio']; // titulo_revista correspondiente
                $pagina_fin = $_POST['pagina_fin']; // titulo_revista correspondiente
                $pais = $_POST['pais']; // titulo_revista correspondiente
                $editorial = $_POST['editorial']; // titulo_revista correspondiente
                $volumen = $_POST['volumen']; // titulo_revista correspondiente
                $fecha_publicacion = $_POST['fecha_publicacion']; // titulo_revista correspondiente
                $proposito = $_POST['proposito']; // titulo_revista correspondiente
                $estado = $_POST['estado']; // Habilidades del docente
                // Inserta los datos en la tabla 
                $sql_update = mysqli_query($conexion,"UPDATE publicaciones SET tipo = '$tipo',
                                                                               autor = '$autor',
                                                                               titulo_articulo = '$titulo_articulo',
                                                                               titulo_revista = '$titulo_revista',
                                                                               pagina_inicio = '$pagina_inicio',
                                                                               pagina_fin = '$pagina_fin',
                                                                               pais = '$pais',
                                                                               editorial = '$editorial',
                                                                               volumen = '$volumen',
                                                                               fecha_publicacion = '$fecha_publicacion',
                                                                               proposito = '$proposito',
                                                                               estado = '$estado',
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
                            <strong>Algo salio mal...</strong> No se pudo actualizar la informacion.
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

<title>SITA - Registrar publicacion</title> <!-- Llama al encabezado -->

            <div class="jumbotron">
                <h1 class="display-3">Registrar publicacion</h1>
                <hr class="my-2">
                <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div> <!-- Espacio para las alertas -->
                <form action="" method="POST" enctype="multipart/form-data"> <!-- "enctype" necesario para poder reconocer los archivos subidos -->
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Llene el siguiente formulario</h4>
                        </div>
                        <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <div class = "form-group col-md-3">
                                        <label class="form-label mt-2">Tipo de publicacion</label>
                                        <select class="form-select" name="tipo" id="tipo">
                                            <option value="<?php echo $tipo?>" hidden=""><?php echo $tipo?></option>
                                            <option value="Articulo de libro">Articulo de libro</option>
                                            <option value="Articulo de revista">Articulo de revista</option>
                                        </select>
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Autor original</label>
                                        <input type="text" class="form-control" name="autor" value="<?php echo $autor?>" placeholder="Nombre del autor del libro/revista">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Titulo del articulo</label>
                                        <input type="text" class="form-control" name="titulo_articulo" value="<?php echo $titulo_articulo?>" placeholder="Nombre del articulo">
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Titulo del libro/revista</label>
                                        <input type="text" class="form-control" name="titulo_revista" value="<?php echo $titulo_revista?>" placeholder="Nombre del libro/revista">
                                    </div>
                                    <div class = "form-group col-md-2">
                                        <label class="form-label mt-2">Pagina inicial</label>
                                        <input type="text" class="form-control" name="pagina_inicio" value="<?php echo $pagina_inicio?>" placeholder="XXX">
                                    </div>
                                    <div class = "form-group col-md-2">
                                        <label class="form-label mt-2">Pagina final</label>
                                        <input type="text" class="form-control" name="pagina_fin" value="<?php echo $pagina_fin?>" placeholder="XXX">
                                    </div>
                                    <div class = "form-group col-md-2">
                                        <label class="form-label mt-2">Pais de origen</label>
                                        <input type="text" class="form-control" name="pais" value="<?php echo $pais?>" placeholder="Indique el pais de la publicacion">
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Editorial</label>
                                        <input type="text" class="form-control" name="editorial" value="<?php echo $editorial?>" placeholder="Indique el nombre de la editorial">
                                    </div>
                                    <div class = "form-group col-md-2">
                                        <label class="form-label mt-2">Volumen</label>
                                        <input type="text" class="form-control" name="volumen" value="<?php echo $volumen?>" placeholder="Indiquei el volumen de la publicacion">
                                    </div>
                                    <div class = "form-group col-md-2">
                                        <label class="form-label mt-2">Fecha de publicacion</label>
                                        <input type="date" class="form-control" name="fecha_publicacion" value="<?php echo $fecha_publicacion?>">
                                    </div>
                                    <div class = "form-group col-md-3">
                                        <label class="form-label mt-2">Estado</label>
                                        <select class="form-select" name="estado" id="estado">
                                            <option value="" hidden=""><?php echo $estado?></option>
                                            <option value="En borrador">En borrador</option>
                                            <option value="En revision">En revision</option>
                                            <option value="Publicado">Publicado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class = "form-group col-md-7">
                                        <label class="form-label mt-2">Proposito</label>
                                        <textarea class="form-control" name="proposito" id="proposito" rows="3" placeholder="Indique el proposito de la publicacion"><?php echo $proposito ?></textarea>
                                    </div>
                                </div>
                            <div class="text-center">
                                <br>
                                <button type="submit" name="decision" value="actualizar" class="btn btn-primary" style="float: left;">Actualizar</button> <!-- Guarda el registro -->
                                <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: right;">Volver</button> <!-- Redirecciona al listado de usuarios -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>

<?php include("../template/pie.php"); ?> <!-- Llama al pie de la pagina -->

<!--
--- Pagina[editarPublicacion] (Prototipo) ---
Ultima modificacion -- [19/07/2022 (14:50 hrs)]
-->