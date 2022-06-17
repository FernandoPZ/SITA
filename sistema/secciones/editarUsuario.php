<?php include("../template/cabecera.php"); ?>

<?php
if($_SESSION['tipo'] != 1)
{
    header("location: /SITA/sistema/index.php");
}

$decision=(isset($_POST['decision']))?$_POST['decision']:""; //Boton de decision
include "../config/conexion.php"; //Conexion con la base de datos
?>

<?php
if(empty($_GET['id']))
{
    header('location: verUsuario.php');
    mysqli_close($conexion);
}
$iduser = $_GET['id'];

include "../config/conexion.php";
$sql = mysqli_query($conexion,"SELECT u.cve_usuario, u.nombre, u.apellido1, u.apellido2, u.foto, u.usuario, u.pass, u.correo, (u.tipo) as idtipo, (r.tipo) as tipo FROM usuario u INNER JOIN tipo_usuario r ON u.tipo = r.cve_tipo_usu WHERE cve_usuario = $iduser");
//mysqli_close($conexion);
$result_sql = mysqli_num_rows($sql);

if($result_sql == 0){
    header('Location: verUsuario.php');
}else{
    while ($data = mysqli_fetch_array($sql)){
        $iduser = $data['cve_usuario'];
        $idtipo = $data['idtipo'];
        $tipo = $data['tipo'];
        $nombre = $data['nombre'];
        $apellido1 = $data['apellido1'];
        $apellido2 = $data['apellido2'];
        $fotoa = $data['foto'];
        $usuario = $data['usuario'];
        $correo = $data['correo'];

        if($idtipo == 1){
            $option = '<option value="'.$idtipo.'"select>'.$tipo.'</option>';
        }else if($idtipo == 2){
            $option = '<option value="'.$idtipo.'"select>'.$tipo.'</option>';
        }else if($idtipo == 3){
            $option = '<option value="'.$idtipo.'"select>'.$tipo.'</option>';
        }
    }
}
?>

<?php
switch($decision){

    case "actualizar":
        if(!empty($_POST))
        {
            $alert='';
            if(empty($_POST['tipo'])
            || empty($_POST['nombre'])
            || empty($_POST['apellido1'])
            || empty($_POST['apellido2'])
            || empty($_POST['usuario'])
            || empty($_POST['correo']))
            {
                $alert='
                <div class="alert alert-dismissible alert-warning">
                    <strong>Se te olvida algo...</strong> debes de llenar los campos necesarios.
                </div>
                ';
            }else{
                $iduser = $_POST['cve_usuario'];
                $tipo = $_POST['tipo'];
                $nombre = $_POST['nombre'];
                $apellido1 = $_POST['apellido1'];
                $apellido2 = $_POST['apellido2'];
                $foto = $_FILES['foto']['name']; //Foto
                $usuario = $_POST['usuario'];
                $pass = $_POST['pass'];
                $correo = $_POST['correo'];

                // Asignacion de nombre unico a la foto
                $fecha= new DateTime();
                $nombreFoto=($foto!="")?$usuario."_".$fecha->getTimestamp()."_".$foto:"$fotoa";

                $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE (usuario = '$usuario' AND cve_usuario != $iduser)");
                $result_usu = mysqli_fetch_array($query);

                $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE (correo = '$correo' AND cve_usuario != $iduser)");
                $result_cor = mysqli_fetch_array($query);

                if($result_usu > 0){
                    $alert='
                    <div class="alert alert-dismissible alert-warning">
                        <strong>Oh vaya...</strong> el nombre de usuario introducido ya esta ocupado, escoge otro.
                    </div>
                    ';
                }else{
                    if($result_cor > 0){
                        $alert='
                        <div class="alert alert-dismissible alert-warning">
                            <strong>Oh vaya...</strong> el correo introducido ya esta registrado, escoge otro.
                        </div>
                        ';
                    }else{
                        if(empty($_POST['contra'])){
                        
                            $sql_update = mysqli_query($conexion, "UPDATE usuario SET tipo = '$tipo',
                                                                                      nombre = '$nombre',
                                                                                      apellido1 = '$apellido1',
                                                                                      apellido2 = '$apellido2',
                                                                                      foto = '$nombreFoto',
                                                                                      usuario = '$usuario',
                                                                                      correo = '$correo'
                                                                                      WHERE cve_usuario = $iduser");
                            if($sql_update){
                                $alert='
                                    <div class="alert alert-dismissible alert-success">
                                        <strong>Listo!</strong> El usuario se actualizó correctamente.
                                    </div>
                                ';
                                $archivoFoto=$_FILES["foto"]["tmp_name"];
                                    if($archivoFoto!=""){
                                        move_uploaded_file($archivoFoto,"../files/upload/fotos/".$nombreFoto);
                                    }
                            }else{
                                $alert='
                                    <div class="alert alert-dismissible alert-danger">
                                        <strong>Algo salio mal...</strong> El usuario no se pudo actualizar.
                                    </div>
                                ';
                            }
                        }else{

                            $sql_update = mysqli_query($conexion, "UPDATE usuario SET tipo = '$tipo',
                                                                                      nombre = '$nombre',
                                                                                      apellido1 = '$apellido1',
                                                                                      apellido2 = '$apellido2',
                                                                                      foto = '$nombreFoto',
                                                                                      usuario = '$usuario',
                                                                                      pass = md5('$contra'),
                                                                                      correo = '$correo'
                                                                                      WHERE cve_usuario = $iduser");
                        
                            if($sql_update){
                                $alert='
                                    <div class="alert alert-dismissible alert-success">
                                        <strong>Listo!</strong> El usuario se actualizó correctamente.
                                    </div>
                                ';
                                $archivoFoto=$_FILES["foto"]["tmp_name"];
                                    if($archivoFoto!=""){
                                        move_uploaded_file($archivoFoto,"../files/upload/fotos/".$nombreFoto);
                                    }
                            }else{
                                $alert='
                                    <div class="alert alert-dismissible alert-danger">
                                        <strong>Algo salio mal...</strong> El usuario no se pudo actualizar.
                                    </div>
                                ';
                            }
                        }
                    }
                }
                mysqli_close($conexion);
            }
        }
    break;

    case "cancelar":
        header('Location:/SITA/sistema/secciones/verUsuario.php');
        mysqli_close($conexion);
    break;
}
?>

<!-- inicio nuevo -->
<title>SITA - Editar usuario</title>

			<div class="jumbotron">
				<h1 class="display-3">Editar informacion del usuario</h1>
                <hr class="my-2">
                <br>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header text-center">
                            Llene el siguiente formulario
                        </div>
                        <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="cve_usuario" value="<?php echo $iduser; ?>">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Nombre</label>
                                        <input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre(s)">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Primer apellido</label>
                                        <input type="text" class="form-control" name="apellido1" value="<?php echo $apellido1; ?>" placeholder="Primer apellido">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Segundo apellido</label>
                                        <input type="text" class="form-control" name="apellido2" value="<?php echo $apellido2; ?>" placeholder="Segundo apellido">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class = "form-group col-md-6 mb-3">
                                        <label class="form-label mt-2">Usuario</label>
                                        <input type="text" class="form-control" name="usuario" value="<?php echo $usuario; ?>" placeholder="usuario">
                                    </div>
                                    <div class = "form-group col-md-6 mb-3">
                                        <label class="form-label mt-2">Tipo de usuario</label>
                                        <?php
                                            include "../config/conexion.php";
                                            $query_tipou = mysqli_query($conexion,"SELECT * FROM tipo_usuario");
                                            mysqli_close($conexion);
                                            $result_tipou = mysqli_num_rows($query_tipou);
                                        ?>
                                        <select class="form-select" name="tipo" id="tipo">
                                            <?php
                                                echo $option;
                                                if($result_tipou > 0)
                                                {
                                                    while ($tipou = mysqli_fetch_array($query_tipou)){
                                                        ?>
                                                        <option value="" hidden>Selecciona una opción</option>
                                                        <option value="<?php echo $tipou["cve_tipo_usu"]; ?>"><?php echo $tipou["tipo"]; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class = "form-group col-md-5">
                                        <label class="form-label mt-2">Fotografia</label>
                                        <input type="file" class="form-control" name="foto" id="foto">
                                        <label class="form-label mt-2">Correo electronico</label>
                                        <input type="text" class="form-control" name="correo" value="<?php echo $correo; ?>" placeholder="ejemplo@correo.com">
                                        <label class="form-label mt-2">Escriba su nueva contraseña</label>
                                        <input type="password" class="form-control" name="pass" placeholder="*******">
                                        <p class="text-primary">Dejar en blanco si no quiere cambiar de contraseña</p>
                                    </div>
                                    <div class = "form-group col-md-2 mx-auto">
                                        <div class="m-0 vh-50 row justify-content-center align-items-center">
                                            <div class="col-auto">
                                                <p>Foto actual: </p>
                                                <output><img src="/SITA/sistema/files/upload/fotos/<?php echo $fotoa; ?>" style="width: 200px; height:200px;"></output>
                                            </div>
                                        </div>
                                    </div>
                                    <div class = "form-group col-md-2 mx-auto">
                                        <div class="m-0 vh-50 row justify-content-center align-items-center">
                                            <div class="col-auto">
                                                <p>Nueva foto: </p>
                                                <output id="previsual"></output>
                                                <script> <?php include("../js/scripts.js"); ?> </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="text-center">
                                <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
                                <button type="submit" name="decision" value="actualizar" class="btn btn-primary" style="float: left;">Actualizar</button>
                                <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: right;">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
<!-- fin nuevo -->

<title>SITA - Editar usuario</title>

			<div class="jumbotron">
				<h1 class="display-3">Editar informacion del usuario</h1>
                <hr class="my-2">
                <br>
                <form action="" method="POST">
                    <div class="card">
                        <div class="card-header text-center">
                            No deje campos vacíos
                        </div>
                        <div class="card-body">
                            <div class = "form-group">
                                <input type="hidden" name="cve_usuario" value="<?php echo $iduser; ?>">
                                <label class="form-label mt-2">Nombre de usuario</label>
                                <input type="text" class="form-control" name="usuario" placeholder="Usuario" value="<?php echo $usuarion; ?>">
                                <label class="form-label mt-2">Tipo de usuario</label>
                                <?php
                                    include "../config/conexion.php";
                                    $query_tipou = mysqli_query($conexion,"SELECT * FROM tipo_usuario");
                                    mysqli_close($conexion);
                                    $result_tipou = mysqli_num_rows($query_tipou);
                                ?>
                                <select class="form-select" name="tipou" id="tipou">
                                    <?php
                                        echo $option;
                                        if($result_tipou > 0)
                                        {
                                            while ($tipou = mysqli_fetch_array($query_tipou)){
                                                ?>
                                                <option value="<?php echo $tipou["cve_tipou"]; ?>"><?php echo $tipou["tipo"]; ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <label class="form-label mt-2">Contraseña nueva</label>
                                <input type="password" class="form-control" name="contra" id="activo" placeholder="*******">
                                <?php
                                    include "../config/conexion.php";
                                    $query_activo = mysqli_query($conexion,"SELECT * FROM usuario");
                                    mysqli_close($conexion);
                                    $result_activo = mysqli_num_rows($query_activo);
                                ?>
                            </div>
                            <div class="text-center">
                                <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
                                <button type="submit" name="decision" value="actualizar" class="btn btn-primary" style="float: left;">Actualizar</button>
                                <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: right;">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

<?php include("../template/pie.php"); ?>