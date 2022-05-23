<?php
if(!empty($_POST))
{
    $alert='';
    if(empty($_POST['usuario']) || empty($_POST['tipou']) || empty($_POST['contra01']) || empty($_POST['contra02']))
    {
        $alert="
        <div class="alert alert-dismissible alert-warning">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Se te olvida algo...</strong> debes de llenar todos los campos.
        </div>
        ";
    }else{
        include "../config/conexion.php";

        $usuario = $_POST['usuario'];
        $tipou = $_POST['tipou'];
        $contra1 = $_POST['contra01'];
        $contra2 = $_POST['contra02'];

        $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE usuario = '$usuario'";)
        $result = mysqli_fetch_array($query);

        if($result > 0){
            $alert="
            <div class="alert alert-dismissible alert-warning">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Oh vaya...</strong> el nombre de usuario introducido ya esta ocupado, escoge otro.
            </div>
            ";
        }else{
            if($contra1 == $contra2){
                $alert="
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Oh vaya...</strong> las contraseñas no coinciden.
                </div>
                ";
            }else{
                $query_insert = mysqli_query($conexion,"INSERT INTO usuario(cve_tipou,usuario,pass,activo) VALUES ()")
            }
        }
    }
}
?>

<?php include("../template/cabecera.php"); ?>
<title>SITA - Registrar usuario</title>

			<div class="jumbotron">
				<h1 class="display-3">Registrar nuevo usuario</h1>
                <hr class="my-2">
                    <br>
                    <div class="card">
                        <div class="card-header text-center">
                            Llene el siguiente formulario
                        </div>
                        <div class="card-body">
                            <div class = "form-group">
                                <label class="form-label mt-2">Nombre de usuario</label>
                                <input type="text" class="form-control" name="usuario" placeholder="usuario">
                                <label class="form-label mt-2">Tipo de usuario</label>
                                <select class="form-select" name="tipou" id="tipou">
                                    <option value="1">Administrador</option>
                                    <option value="2">Consultor</option>
                                    <option value="3">Academico</option>
                                    <option value="4">Aspirante</option>
                                </select>
                                <label class="form-label mt-2">Escriba su contraseña</label>
                                <input type="password" class="form-control" name="contra01" placeholder="*******">
                                <label class="form-label mt-2">Escriba de nuevo su contraseña</label>
                                <input type="text" class="form-control" name="contra02" placeholder="contraseña">
                            </div>
                            <div class="text-center">
                                <button type="submit" name="accion" value="entrar" class="btn btn-save btn-primary">Guardar</button>
                                <button onclick="location.href='/SITA/sistema/secciones/verUsuario.php'" class="btn btn-danger">Cancelar</button>
                            </div>
                        </div>
                    </div>
			</div>

<?php include("../template/pie.php"); ?>