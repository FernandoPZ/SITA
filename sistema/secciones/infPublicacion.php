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
    header("location: /sistema/index.php"); // Redirecciona a la pagina pricipal
}
?>

<title>SITA - Ver publicacion</title> <!-- Llama al encabezado -->

            <div class="jumbotron">
                <h1 class="display-3">Ver publicacion</h1>
                <hr class="my-2">
                <form action="" method="POST" enctype="multipart/form-data"> <!-- "enctype" necesario para poder reconocer los archivos subidos -->
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Información de la publicación</h4>
                        </div>
                        <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <div class = "form-group col-md-3">
                                        <label class="form-label mt-2">Tipo de publicación</label>
                                        <select class="form-select" disabled="">
                                            <option><?php echo $tipo?></option>
                                        </select>
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Autor original</label>
                                        <input type="text" class="form-control" value="<?php echo $autor?>" readonly="">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Titulo del articulo</label>
                                        <input type="text" class="form-control" value="<?php echo $titulo_articulo?>" readonly="">
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Titulo del libro/revista</label>
                                        <input type="text" class="form-control" value="<?php echo $titulo_revista?>" readonly="">
                                    </div>
                                    <div class = "form-group col-md-2">
                                        <label class="form-label mt-2">Página inicial</label>
                                        <input type="text" class="form-control" value="<?php echo $pagina_inicio?>" readonly="">
                                    </div>
                                    <div class = "form-group col-md-2">
                                        <label class="form-label mt-2">Página final</label>
                                        <input type="text" class="form-control" value="<?php echo $pagina_fin?>" readonly="">
                                    </div>
                                    <div class = "form-group col-md-2">
                                        <label class="form-label mt-2">País de origen</label>
                                        <input type="text" class="form-control" value="<?php echo $pais?>" readonly="">
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Editorial</label>
                                        <input type="text" class="form-control" value="<?php echo $editorial?>" readonly="">
                                    </div>
                                    <div class = "form-group col-md-2">
                                        <label class="form-label mt-2">Volumen</label>
                                        <input type="text" class="form-control" value="<?php echo $volumen?>" readonly="">
                                    </div>
                                    <div class = "form-group col-md-2">
                                        <label class="form-label mt-2">Fecha de publicación</label>
                                        <input type="date" class="form-control" readonly="">
                                    </div>
                                    <div class = "form-group col-md-3">
                                        <label class="form-label mt-2">Estado</label>
                                        <select class="form-select" disabled="">
                                            <option hidden=""><?php echo $estado?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class = "form-group col-md-7">
                                        <label class="form-label mt-2">Propósito</label>
                                        <textarea class="form-control" rows="3" readonly=""><?php echo $proposito ?></textarea>
                                    </div>
                                </div>
                            <div class="text-center">
                                <br>
                                <a role="button" class="btn btn-primary" href="editarPublicacion.php?id_d=<?php echo $idDoc; ?>&id_pu=<?php echo $idPub; ?>">Editar</a> <!-- Redirecciona a editar el registro -->
                                <a role="button" class="btn btn-danger" href="infDocente.php">Volver</a> <!-- Redirecciona al listado de usuarios -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>

<?php include("../template/pie.php"); ?> <!-- Llama al pie de la pagina -->

<!--
--- Pagina[editarPublicacion] (Prototipo) ---
Ultima modificacion -- [31/08/2022 (14:43 hrs)]
-->