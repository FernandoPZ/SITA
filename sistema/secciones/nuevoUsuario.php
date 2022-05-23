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
                                <label>Nombre de usuario</label>
                                <input type="text" class="form-control" name="usuario" placeholder="usuario">
                            </div>
                            <div class="form-group">
                                <label>Tipo de usuario</label>
                                </br>
                                <select name="rol" id="rol">
                                    <option value="1">Administrador</option>
                                    <option value="2">Consultor</option>
                                    <option value="3">Academico</option>
                                    <option value="4">Aspirante</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Escriba su contraseña</label>
                                <input type="password" class="form-control" name="contra01" placeholder="*******">
                            </div>
                            <div class="form-group">
                                <label>Escriba de nuevo su contraseña</label>
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