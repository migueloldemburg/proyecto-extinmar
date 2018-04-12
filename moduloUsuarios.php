<?php require("seguridad.php") ?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body class="adjusted">
	<?php require("css/header.php") ?>

	<!-- Modal -->
	<form id="formModal" class="form-horizontal">
		<div class="modal fade" id="confUsuarios" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><!--dinamico--></h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="accion" value="registrar_usuario">
						<input type="hidden" name="id" value="0">

						<div class="form-group">
							<label class="col-sm-3 control-label" for="nombre">Nombre *</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="nombre" required="" maxlength="50" onkeypress="return isLetter(event)">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="apellido">Apellido *</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="apellido" required="" maxlength="50" onkeypress="return isLetter(event)">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="email">Email *</label>
							<div class="col-sm-8">
								<input type="email" class="form-control" name="email" required="" maxlength="70">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="nivel">Nivel *</label>
							<div class="col-sm-8">
								<select class="form-control" name="nivel" required="">
									<option>Administrador</option>
									<option>Secretaria</option>
									<option>Recargador</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="estado">Estado *</label>
							<div class="col-sm-8">
								<select class="form-control" name="estado" required="">
									<option value="1">Activo</option>
									<option value="0">Desactivado</option>
								</select>
							</div>
						</div>
						<div class="well">
							<div class="form-group">
								<label class="col-sm-3 control-label" for="usuario">Usuario *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="usuario" required="" maxlength="30" onkeypress="return isLetter(event)">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="clave1">Clave *</label>
								<div class="col-sm-8">
									<input type="password" class="form-control" name="clave1" required="" minlength="6" maxlength="15">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="clave2">Repetir Clave *</label>
								<div class="col-sm-8">
									<input type="password" class="form-control" name="clave2" required="" minlength="6" maxlength="15">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
					<p class="text-danger">* Todos los campos son obligatorios.</p>
						<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">cerrar</button>
						<button type="submit" class="btn btn-default">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<div class="container">
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<h3>Usuarios del Sistema <button class="btn btn-md btn-primary pull-right" data-toggle="modal" data-target="#confUsuarios" data-accion="agregar"><span class="glyphicon glyphicon-plus"></span> Agregar Nuevo</button></h3>
				<form class="form-inline">
					<div class="input-group">
						<input type="text" id="searcher_01" class="form-control" placeholder="Buscar">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
						</span>
					</div>
				</form>
				<br>
				<table class="table table-condensed" style="font-size:13px; background-color:white">
					<thead>
						<th>Nombre</th>
						<th>Usuario</th>
						<th>Email</th>
						<th>Estado</th>
						<th>Nivel</th>
						<th></th>
					</thead>
					<tbody>
					<?php
						$usuarios = new Usuarios();
						if($usuarios->obtener_usuarios()){
							while($row=$usuarios->array->fetch_assoc()){
								echo "<tr>";
								echo "<td>".$row['nombre']." ".$row['apellido']."</td>";
								echo "<td>".$row['usuario']."</td>";
								echo "<td>".$row['email']."</td>";
								echo "<td>";
								if($row['estado']==1){
									echo '<span class="label label-success">Activo</span>';
								}else{
									echo '<span class="label label-danger">Desactivado</span>';
								}
								echo "</td>";
								echo "<td>".$row['nivel']."</td>";
								echo "<td>";
								echo "<button class='btn btn-xs btn-warning' data-toggle='modal' data-target='#confUsuarios' data-accion='editar' data-id='".$row['id']."'><span class='glyphicon glyphicon-pencil'></span></button> ";
								echo "<button class='btn btn-xs btn-danger cambiar_estado' id='".$row['id']."' de='usuario' estado=2><span class='glyphicon glyphicon-trash'></span></button>";
								echo "</td>";
								echo "</tr>";
							}
						}else{
							echo "<tr><td colspan='5'>No hay usuarios registrados.</td></tr>";
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php require("css/footer.php") ?>
	<?php require("libs/jsLibs.php") ?>
</body>
</html>