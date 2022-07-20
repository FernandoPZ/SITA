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
            if(empty($_POST['tipo']) // Nivel de estudio
            || empty($_POST['autor']) // Siglas del estudio
            || empty($_POST['titulo_articulo']) // Nombre de la institucion
            || empty($_POST['titulo_revista']) // motivo correspondiente
            || empty($_POST['pagina_inicio']) // motivo correspondiente
            || empty($_POST['pagina_fin']) // motivo correspondiente
            || empty($_POST['pais']) // motivo correspondiente
            || empty($_POST['editorial']) // motivo correspondiente
            || empty($_POST['volumen']) // motivo correspondiente
            || empty($_POST['fecha_publicacion']) // motivo correspondiente
            || empty($_POST['proposito']) // motivo correspondiente
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
                $titulo_articulo = $_POST['titulo_articulo']; // Nombre de la institucion
                $titulo_revista = $_POST['titulo_revista']; // motivo correspondiente
                $pagina_inicio = $_POST['pagina_inicio']; // motivo correspondiente
                $pagina_fin = $_POST['pagina_fin']; // motivo correspondiente
                $pais = $_POST['pais']; // motivo correspondiente
                $editorial = $_POST['editorial']; // motivo correspondiente
                $volumen = $_POST['volumen']; // motivo correspondiente
                $fecha_publicacion = $_POST['fecha_publicacion']; // motivo correspondiente
                $proposito = $_POST['proposito']; // motivo correspondiente
                $estado = $_POST['estado']; // Habilidades del docente
                // Inserta los datos en la tabla 
                $query_insert = mysqli_query($conexion,"INSERT INTO publicaciones(tipo, autor, titulo_articulo, titulo_revista, pagina_inicio, pagina_fin, pais, editorial, volumen, fecha_publicacion, proposito, estado, cve_docente, user_cve)
                                                                          VALUES ('$tipo','$autor','$titulo_articulo','$titulo_revista','$pagina_inicio','$pagina_fin','$pais','$editorial','$volumen','$fecha_publicacion','$proposito','$estado','$idDoc','$user')");
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
                                            <option value="" hidden=""><?php echo isset($_POST['tipo']) ? $_POST['tipo'] : 'Selecciona una opcion';?></option>
                                            <option value="Articulo de libro">Articulo de libro</option>
                                            <option value="Articulo de revista">Articulo de revista</option>
                                        </select>
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Autor original</label>
                                        <input type="text" class="form-control" name="autor" value="<?php echo isset($_POST['autor']) ? $_POST['autor'] : '';?>" placeholder="Nombre del autor del libro/revista">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Titulo del articulo</label>
                                        <input type="text" class="form-control" name="titulo_articulo" value="<?php echo isset($_POST['titulo_articulo']) ? $_POST['titulo_articulo'] : '';?>" placeholder="Nombre del articulo">
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Titulo del libro/revista</label>
                                        <input type="text" class="form-control" name="titulo_revista" value="<?php echo isset($_POST['titulo_revista']) ? $_POST['titulo_revista'] : '';?>" placeholder="Nombre del libro/revista">
                                    </div>
                                    <div class = "form-group col-md-2">
                                        <label class="form-label mt-2">Pagina inicial</label>
                                        <input type="text" class="form-control" name="pagina_inicio" value="<?php echo isset($_POST['pagina_inicio']) ? $_POST['pagina_inicio'] : '';?>" placeholder="XXX">
                                    </div>
                                    <div class = "form-group col-md-2">
                                        <label class="form-label mt-2">Pagina final</label>
                                        <input type="text" class="form-control" name="pagina_fin" value="<?php echo isset($_POST['pagina_fin']) ? $_POST['pagina_fin'] : '';?>" placeholder="XXX">
                                    </div>
                                    <div class = "form-group col-md-2">
                                        <label class="form-label mt-2">Pais de origen</label>
                                        <input type="text" class="form-control" name="pais" value="<?php echo isset($_POST['pais']) ? $_POST['pais'] : '';?>" placeholder="Indique el pais de la publicacion">
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Editorial</label>
                                        <input type="text" class="form-control" name="editorial" value="<?php echo isset($_POST['editorial']) ? $_POST['editorial'] : '';?>" placeholder="Indique el nombre de la editorial">
                                    </div>
                                    <div class = "form-group col-md-2">
                                        <label class="form-label mt-2">Volumen</label>
                                        <input type="text" class="form-control" name="volumen" value="<?php echo isset($_POST['volumen']) ? $_POST['volumen'] : '';?>" placeholder="Indiquei el volumen de la publicacion">
                                    </div>
                                    <div class = "form-group col-md-2">
                                        <label class="form-label mt-2">Fecha de publicacion</label>
                                        <input type="date" class="form-control" name="fecha_publicacion" value="<?php echo isset($_POST['fecha_publicacion']) ? $_POST['fecha_publicacion'] : '';?>">
                                    </div>
                                    <div class = "form-group col-md-3">
                                        <label class="form-label mt-2">Estado</label>
                                        <select class="form-select" name="estado" id="estado">
                                            <option value="" hidden=""><?php echo isset($_POST['estado']) ? $_POST['estado'] : 'Selecciona una opcion';?></option>
                                            <option value="En borrador">En borrador</option>
                                            <option value="En revision">En revision</option>
                                            <option value="Publicado">Publicado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class = "form-group col-md-7">
                                        <label class="form-label mt-2">Proposito</label>
                                        <textarea class="form-control" name="proposito" id="proposito" rows="3" placeholder="Indique el proposito de la publicacion"><?php echo isset($_POST['proposito']) ? $_POST['proposito'] : '';?></textarea>
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
--- Pagina[nuevoPublicacion] (Prototipo) ---
Ultima modificacion -- [29/06/2022 (14:45 hrs)]
-->