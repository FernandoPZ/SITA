<?php include("../template/cabecera.php"); ?>

<?php

if($_SESSION['tipo'] != 1)
{
    header("location: /SITA/sistema/index.php");
}

include "../config/conexion.php"; //Conexion con la base de datos

$decision=(isset($_POST['decision']))?$_POST['decision']:""; //Boton de decision

switch($decision){

    case "eliminar":
        if(!empty($_POST))
        {
            if($_POST['cve_usuario'] == 1){
                header("location: verUsuario.php");
                mysqli_close($conexion);
                exit;
            }
            $iduser = $_POST['cve_usuario'];
            //$query_delete = mysqli_query($conexion,"DELETE FROM usuario WHERE cve_usuario = $iduser");// Elimina el registro
            $query_delete = mysqli_query($conexion,"UPDATE usuario SET activo = 0 WHERE cve_usuario = $iduser");// Desactiva el registro
            header("location: verUsuario.php");
            mysqli_close($conexion);
        }
    break;

    case "volver":
        header('Location:/SITA/sistema/secciones/verUsuario.php');
        mysqli_close($conexion);
    break;
}

if(empty($_REQUEST['id']))
{
    header("location: verUsuario.php");
    mysqli_close($conexion);
}else{
    $iduser = $_REQUEST['id'];
    $query = mysqli_query($conexion,"SELECT u.usuario, r.tipo FROM usuario u INNER JOIN tipo_usuario r ON u.tipo = r.cve_tipou WHERE u.cve_usuario = $iduser");
    $result = mysqli_num_rows($query);
    if($result > 0){
        while ($data = mysqli_fetch_array($query)){
            $usuario = $data['usuario'];
            $tipo = $data['tipo'];
        }
    }else{
        header("location: verUsuario.php");
        mysqli_close($conexion);
    }
}
?>


<title>SITA - Eliminar usuario</title>

			<div class="jumbotron">
				<h1 class="display-3">Eliminar usuario</h1>
				<hr class="my-2">
			</div>
            <div class="container">
                <div class="row">
                    <?php
                    if($iduser != 1)
                    {?>
                    <div class="col-md-5 mx-auto">
                        <br>
                        <div class="card">
                            <div class="card-header text-center">
                                ¿Esta seguro de eliminar este usuario?
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <p>Usuario: <span><?php echo $usuario; ?></span></p>
                                    <p>Tipo: <span><?php echo $tipo; ?></span></p>
                                    <form method="post" action="">
                                        <input type="hidden" name="cve_usuario" value="<?php echo $iduser; ?>">
                                        <button type="submit" name="decision" value="eliminar" class="btn btn-danger" style="float: left;">Eliminar</button>
                                        <button type="submit" name="decision" value="volver" class="btn btn-primary" style="float: right;">Volver</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }else{ ?>
                        <div class="col-md-5 mx-auto">
                        </br>
                            <div class="alert alert-dismissible alert-warning">
                                <h4 class="alert-heading">Lo sentimos</h4>
                                <p class="mb-0"> Este usuario no se puede eliminar </p>
                            </div>
                        </div>
                        <div class="text-center">
                        <button type="submit" name="decision" value="volver" class="btn btn-primary">Volver</button>
                        </div>
                    <?php } ?>
                </div>
            </div>

<?php include("../template/pie.php"); ?>