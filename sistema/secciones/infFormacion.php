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

<title>SITA - Ver formación</title> <!-- Llama al encabezado -->

            <div class="jumbotron">
                <h1 class="display-3">Ver formación</h1>
                <hr class="my-2">
                <form action="" method="POST" enctype="multipart/form-data"> <!-- "enctype" necesario para poder reconocer los archivos subidos -->
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Datos de la formación</h4>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Nivel de estudios</label>
                                        <input type="text" class="form-control" name="nivel_estudio" value="<?php echo $nivel_estudio; ?>" readonly="">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Siglas del estudio</label>
                                        <input type="text" class="form-control" name="siglas_estudio" value="<?php echo $siglas_estudio; ?>" readonly="">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Nombre de la institución</label>
                                        <input type="text" class="form-control" name="institucion" value="<?php echo $institucion; ?>" readonly="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Área aplicable</label>
                                        <input type="text" class="form-control" name="area" value="<?php echo $area; ?>" readonly="">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Disciplina aplicable</label>
                                        <input type="text" class="form-control" name="disciplina" value="<?php echo $disciplina; ?>" readonly="">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">País donde se realizó</label>
                                        <input type="text" class="form-control" name="pais" value="<?php echo $pais; ?>" readonly="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Fecha de inicio del estudio</label>
                                        <input type="date" class="form-control" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>" readonly="">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Fecha de conclusión del estudio</label>
                                        <input type="date" class="form-control" name="fecha_fin" value="<?php echo $fecha_fin; ?>" readonly="">
                                    </div>
                                    <div class = "form-group col-md-4">
                                    <label class="form-label mt-2">Fecha cuando se liberó el titulo</label>
                                        <input type="date" class="form-control" name="fecha_titulacion" value="<?php echo $fecha_titulacion; ?>" readonly="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class = "form-group col-md-10 mx-auto">
                                        <label class="form-label mt-2">Habilidades aprendidas en la formación</label>
                                        <textarea class="form-control" name="habilidades" id="habilidades" rows="3" readonly=""><?php echo $habilidades; ?></textarea>
                                    </div>
                                </div>
                            <div class="text-center">
                                <br>
                                <a role="button" class="btn btn-primary" href="editarFormacion.php?id_d=<?php echo $idDoc; ?>&id_f=<?php echo $idFor; ?>">Editar</a> <!-- Redirecciona a editar el registro -->
                                <a role="button" class="btn btn-danger" href="infDocente.php">Volver</a> <!-- Redirecciona al listado de usuarios -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>

<?php include("../template/pie.php"); ?> <!-- Llama al pie de la pagina -->

<!--
--- Pagina[infFormacion] (Prototipo) ---
Ultima modificacion -- [03/08/2022 (14:13 hrs)]
-->