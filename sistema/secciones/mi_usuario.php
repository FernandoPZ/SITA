<?php include("../template/cabecera.php"); ?>

<?php include ("../config/conexion.php"); ?>

++++++ Este apartado esta pendiente ++++++

<title>SITA - Mi cuenta</title> <!-- Nombre de la pagina -->

			<div class="jumbotron">
				<h1 class="display-3">Mi cuenta</h1>
				<hr class="my-2">
			</div>
            <div class="container">
                <div class="row">
                    <?php
                    if($iduser != 1) // Valida que no se intente eliminar el master
                    {?>
                    <div class="col-md-7 mx-auto">
                        <br>
                        <div class="card">
                            <div class="card-header text-center">
                                ¿Esta seguro de eliminar este usuario?
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <div><?php echo $alert; ?></div> <!-- Advertencia de auto-eliminacion -->
                                    <p><img src="/SITA/sistema/files/upload/fotos/<?php echo $foto; ?>" style="width: 200px; height:200px;"></p> <!-- Muestra la imagen del usuario -->
                                    <p><strong>Usuario: </strong>[<span><em><?php echo $usuario; ?></em></span>]</p> <!-- Muestra el ID del usuario -->
                                    <p><strong>Tipo: </strong>[<span><em><?php echo $tipo; ?></em></span>]</p> <!-- Muestra el tipo de usuario -->
                                    <form method="post" action="">
                                        <input type="hidden" name="cve_usuario" value="<?php echo $iduser; ?>"> <!-- Verificacion de la clave del usuario -->
                                        <button type="submit" name="decision" value="eliminar" class="btn btn-danger" style="float: left;">Eliminar</button> <!-- Desactiva al usuario -->
                                        <button type="submit" name="decision" value="volver" class="btn btn-primary" style="float: right;">Volver</button> <!-- Regresa a la lista de usuarios -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }else{ ?>
                        <div class="col-md-5 mx-auto">
                        </br>
                            <div class="alert alert-dismissible alert-warning"> <!-- Alerta de que el usuario no se puede eliminar -->
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