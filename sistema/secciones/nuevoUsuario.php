<?php include("../template/cabecera.php"); ?>

<?php
if($_SESSION['tipo'] != 1)
{
    header("location: /SITA/sistema/index.php");
}

$decision=(isset($_POST['decision']))?$_POST['decision']:""; //Boton de decision
include "../config/conexion.php";
?>

<?php
switch($decision){

    case "guardar":
        if(!empty($_POST))
        {
            $alert='';
            if(empty($_POST['tipo'])
            || empty($_POST['nombre'])
            || empty($_POST['apellido1'])
            || empty($_POST['apellido2'])
            || empty($_FILES['foto'])
            || empty($_POST['usuario'])
            || empty($_POST['pass1'])
            || empty($_POST['pass2'])
            || empty($_POST['correo']))
            {
                $alert='
                <div class="alert alert-dismissible alert-warning">
                    <strong>Se te olvida algo...</strong> debes de llenar todos los campos.
                </div>
                ';
            }else{
                $tipo = $_POST['tipo'];
                $nombre = $_POST['nombre'];
                $apellido1 = $_POST['apellido1'];
                $apellido2 = $_POST['apellido2'];
                $foto = $_FILES['foto']['name']; //Foto
                $usuario = $_POST['usuario'];
                $pass1 = $_POST['pass1'];
                $pass2 = $_POST['pass2'];
                $correo = $_POST['correo'];

                // Asignacion de nombre unico a la foto
                $fecha= new DateTime();
                $nombreFoto=($foto!="")?$usuario."_".$fecha->getTimestamp()."_".$foto:"default.png";

                $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE usuario = '$usuario'");
                $result_usu = mysqli_fetch_array($query);

                $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE correo = '$correo'");
                $result_cor = mysqli_fetch_array($query);

                if($result_usu > 0){
                    $alert='
                    <div class="alert alert-dismissible alert-warning">
                        <strong>Oh vaya...</strong> el nombre de usuario introducido ya esta registrado, escoge otro.
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
                        if($pass1 != $pass2){
                            $alert='
                            <div class="alert alert-dismissible alert-danger">
                                <strong>Oh vaya...</strong> las contraseñas no coinciden.
                            </div>
                            ';
                        }else{
                            $query_insert = mysqli_query($conexion,"INSERT INTO usuario(tipo,nombre,apellido1,apellido2,foto,usuario,pass,correo)
                                                                                VALUES ('$tipo','$nombre','$apellido1','$apellido2','$nombreFoto','$usuario',md5('$pass1'),'$correo')");
                            if($query_insert){
                                $alert='
                                    <div class="alert alert-dismissible alert-success">
                                        <strong>Listo!</strong> El usuario se guardo correctamente.
                                    </div>
                                ';
                                $archivoFoto=$_FILES["foto"]["tmp_name"];
                                if($archivoFoto!=""){
                                    move_uploaded_file($archivoFoto,"../files/upload/fotos/".$nombreFoto);
                                }
                            }else{
                                $alert='
                                    <div class="alert alert-dismissible alert-danger">
                                        <strong>Algo salio mal...</strong> El usuario no se pudo guardar.
                                    </div>
                                ';
                            }
                        }
                    }
                }
                mysqli_close($conexion);
            }
            break;
        }

    case "cancelar":
        header('Location:/SITA/sistema/secciones/verUsuario.php');
        mysqli_close($conexion);
    break;
}
?>

<title>SITA - Registrar usuario</title>

			<div class="jumbotron">
				<h1 class="display-3">Registrar nuevo usuario</h1>
                <hr class="my-2">
                <br>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header text-center">
                            Llene el siguiente formulario
                        </div>
                        <div class="card-body">
                                <div class="row">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Nombre</label>
                                        <input type="text" class="form-control" name="nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : '';?>" placeholder="Nombre(s)">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Primer apellido</label>
                                        <input type="text" class="form-control" name="apellido1" value="<?php echo isset($_POST['apellido1']) ? $_POST['apellido1'] : '';?>" placeholder="Primer apellido">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Segundo apellido</label>
                                        <input type="text" class="form-control" name="apellido2" value="<?php echo isset($_POST['apellido2']) ? $_POST['apellido2'] : '';?>" placeholder="Segundo apellido">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class = "form-group col-md-6 mb-3">
                                        <label class="form-label mt-2">Usuario</label>
                                        <input type="text" class="form-control" name="usuario" value="<?php echo isset($_POST['usuario']) ? $_POST['usuario'] : '';?>" placeholder="usuario">
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
                                    <div class = "form-group col-md-9">
                                        <label class="form-label mt-2">Fotografia</label>
                                        <input type="file" class="form-control" name="foto" id="foto">
                                        <label class="form-label mt-2">Correo electronico</label>
                                        <input type="text" class="form-control" name="correo" value="<?php echo isset($_POST['correo']) ? $_POST['correo'] : '';?>" placeholder="ejemplo@correo.com">
                                        <label class="form-label mt-2">Escriba su contraseña</label>
                                        <input type="password" class="form-control" name="pass1" placeholder="*******">
                                        <label class="form-label mt-2">Escriba de nuevo su contraseña</label>
                                        <input type="text" class="form-control" name="pass2" placeholder="contraseña">
                                    </div>
                                    <div class = "form-group col-md-3 mx-auto">
                                        <div class="m-0 vh-50 row justify-content-center align-items-center">
                                            <div class="col-auto">
                                                <br>
                                                <output id="previsual"></output>
                                                <script> <?php include("../js/scripts.js"); ?> </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="text-center">
                                <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
                                <button type="submit" name="decision" value="guardar" class="btn btn-primary" style="float: left;">Guardar</button>
                                <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: right;">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

<?php include("../template/pie.php"); ?>