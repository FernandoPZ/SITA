<?php
$decision=(isset($_POST['decision']))?$_POST['decision']:""; //Boton de decision
include "../config/conexion.php";
?>

<?php
switch($decision){

    case "guardar":
        if(!empty($_POST))
        {
            $alert='';
            if(empty($_POST['usuario']) || empty($_POST['tipou']) || empty($_POST['contra01']) || empty($_POST['contra02']))
            {
                $alert='
                <div class="alert alert-dismissible alert-warning">
                    <strong>Se te olvida algo...</strong> debes de llenar todos los campos.
                </div>
                ';
            }else{
                $usuario = $_POST['usuario'];
                $tipou = $_POST['tipou'];
                $contra1 = $_POST['contra01'];
                $contra2 = $_POST['contra02'];

                $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE usuario = '$usuario'");
                $result = mysqli_fetch_array($query);

                if($result > 0){
                    $alert='
                    <div class="alert alert-dismissible alert-warning">
                        <strong>Oh vaya...</strong> el nombre de usuario introducido ya esta ocupado, escoge otro.
                    </div>
                    ';
                }else{
                    if($contra1 != $contra2){
                        $alert='
                        <div class="alert alert-dismissible alert-danger">
                            <strong>Oh vaya...</strong> las contraseñas no coinciden.
                        </div>
                        ';
                    }else{
                        $query_insert = mysqli_query($conexion,"INSERT INTO usuario(tipo,usuario,pass,activo) VALUES ('$tipou','$usuario',md5('$contra1'),'Si')");
                        if($query_insert){
                            $alert='
                                <div class="alert alert-dismissible alert-success">
                                    <strong>Listo!</strong> El usuario se guardo correctamente.
                                </div>
                            ';
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
        }
    break;

    case "cancelar":
        header('Location:/SITA/sistema/secciones/verUsuario.php');
    break;
}
?>

<?php include("../template/cabecera.php"); ?>
<title>SITA - Registrar usuario</title>

			<div class="jumbotron">
				<h1 class="display-3">Registrar nuevo usuario</h1>
                <hr class="my-2">
                <br>
                <form action="" method="POST">
                    <div class="card">
                        <div class="card-header text-center">
                            Llene el siguiente formulario
                        </div>
                        <div class="card-body">
                            <div class = "form-group">
                                <label class="form-label mt-2">Nombre de usuario</label>
                                <input type="text" class="form-control" name="usuario" placeholder="usuario">
                                <label class="form-label mt-2">Tipo de usuario</label>
                                <?php
                                    $query_tipou = mysqli_query($conexion,"SELECT * FROM tipo_usuario");
                                    $result_tipou = mysqli_num_rows($query_tipou);
                                ?>
                                <select class="form-select" name="tipou" id="tipou">
                                    <?php
                                        if($result_tipou > 0)
                                        {
                                            while ($tipou = mysqli_fetch_array($query_tipou)){
                                                ?>
                                                <option value="" hidden>Selecciona una opción</option>
                                                <option value="<?php echo $tipou["cve_tipou"]; ?>"><?php echo $tipou["tipo"]; ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <label class="form-label mt-2">Escriba su contraseña</label>
                                <input type="password" class="form-control" name="contra01" placeholder="*******">
                                <label class="form-label mt-2">Escriba de nuevo su contraseña</label>
                                <input type="text" class="form-control" name="contra02" placeholder="contraseña">
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