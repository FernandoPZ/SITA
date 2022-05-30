<?php
$decision=(isset($_POST['decision']))?$_POST['decision']:""; //Boton de decision
include "../config/conexion.php"; //Conexion con la base de datos
?>

<?php
switch($decision){

    case "actualizar":
        if(!empty($_POST))
        {
            $alert='';
            if(empty($_POST['usuario']) || empty($_POST['tipou']))
            {
                $alert='
                <div class="alert alert-dismissible alert-warning">
                    <strong>Se te olvida algo...</strong> debes de llenar todos los campos.
                </div>
                ';
            }else{
                
                $iduser = $_POST['cve_usuario'];
                $usuario = $_POST['usuario'];
                $tipou = $_POST['tipou'];
                $contra = $_POST['contra'];

                $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE (usuario = '$usuario' AND cve_usuario != $iduser)");
                $result = mysqli_fetch_array($query);

                if($result > 0){
                    $alert='
                    <div class="alert alert-dismissible alert-warning">
                        <strong>Oh vaya...</strong> el nombre de usuario introducido ya esta ocupado, escoge otro.
                    </div>
                    ';
                }else{
                    if(empty($_POST['contra'])){
                        
                        $sql_update = mysqli_query($conexion, "UPDATE usuario SET usuario = '$usuario', tipo = '$tipou' WHERE cve_usuario = $iduser");

                        if($sql_update){
                            $alert='
                                <div class="alert alert-dismissible alert-success">
                                    <strong>Listo!</strong> El usuario se actualizó correctamente.
                                </div>
                            ';
                        }else{
                            $alert='
                                <div class="alert alert-dismissible alert-danger">
                                    <strong>Algo salio mal...</strong> El usuario no se pudo actualizar.
                                </div>
                            ';
                        }

                    }else{

                        $sql_update = mysqli_query($conexion, "UPDATE usuario SET usuario = '$usuario', tipo = '$tipou', pass = '$contra' WHERE cve_usuario = $iduser");
                        
                        if($sql_update){
                            $alert='
                                <div class="alert alert-dismissible alert-success">
                                    <strong>Listo!</strong> El usuario se actualizó correctamente.
                                </div>
                            ';
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
    break;

    case "cancelar":
        header('Location:/SITA/sistema/secciones/verUsuario.php');
        mysqli_close($conexion);
    break;
}
?>

<?php
if(empty($_GET['id']))
{
    header('location: verUsuario.php');
    mysqli_close($conexion);
}
$iduser = $_GET['id'];

include "../config/conexion.php";
$sql = mysqli_query($conexion,"SELECT u.cve_usuario, u.usuario, u.activo, (u.tipo) as idtipo, (r.tipo) as tipo FROM usuario u INNER JOIN tipo_usuario r ON u.tipo = r.cve_tipou WHERE cve_usuario = $iduser");
mysqli_close($conexion);
$result_sql = mysqli_num_rows($sql);

if($result_sql == 0){
    header('Location: verUsuario.php');
}else{
    while ($data = mysqli_fetch_array($sql)){
        $iduser = $data['cve_usuario'];
        $idtipo = $data['idtipo'];
        $tipo = $data['tipo'];
        $usuarion = $data['usuario'];
        $activo = $data['activo'];

        if($idtipo == 1){
            $option = '<option value="'.$idtipo.'"select>'.$tipo.'</option>';
        }else if($idtipo == 2){
            $option = '<option value="'.$idtipo.'"select>'.$tipo.'</option>';
        }else if($idtipo == 3){
            $option = '<option value="'.$idtipo.'"select>'.$tipo.'</option>';
        }else if($idtipo == 4){
            $option = '<option value="'.$idtipo.'"select>'.$tipo.'</option>';
        }
    }
}

?>

<?php include("../template/cabecera.php"); ?>
<title>SITA - Editar usuario</title>

			<div class="jumbotron">
				<h1 class="display-3">Editar informacion de usuario</h1>
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