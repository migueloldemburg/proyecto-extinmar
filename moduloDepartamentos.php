<?php require("seguridad.php") ?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body>
	<?php require("css/header.php") ?>

	<!-- Modal Departamentos -->
	<form id="formModal">
		<div class="modal fade" id="confDepartamentos" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><!--Dinamico--></h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id" value="0">
						<input type="hidden" name="accion" value="registrar_departamento">
						<div class="form-group">
							<label for="nombre">Dep&oacute;sito:</label>
							<input type="text" class="form-control" name="departamento" placeholder="Nombre de dep&oacute;sito" required>
						</div>
						<div class="form-group">
							<label for="nombre">Pasillo:</label>
							<input type="text" class="form-control" name="pasillo" placeholder="Nombre de pasillo" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-sm btn-default">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="text-center">Configuraci&oacute;n de Dep&oacute;sitos y Pasillos</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<div class="panel panel-success">
					<div class="panel-heading">Dep&oacute;sitos y Pasillos 
						<button class="btn btn-sm btn-default pull-right" data-toggle="modal" data-target="#confDepartamentos" data-accion="agregar"><span class="glyphicon glyphicon-plus"></span> Agregar</button></div>
					<div class="panel-content">
						<br>
						<form class="form-inline">
							<div class="input-group" style="padding:5px 10px">
								<input type="text" id="searcher_01" class="form-control" placeholder="Buscar">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
								</span>
							</div>
						</form>
						<br>
						<table class="table table-condensed table-hover">
							<thead>
								<th>Dep&oacute;sito</th>
								<th>Pasillo</th>
								<th></th>
							</thead>
							<tbody>
							<?php
								$departamentos = new MiClase();
								if($departamentos->obtener_departamentos()){
									while($row=$departamentos->array->fetch_assoc()){
										echo "<tr>";
										echo "<td>".$row['departamento']."</td>";
										echo "<td>".$row['pasillo']."</td>";
										echo "<td>";
										echo "<button class='btn btn-xs btn-warning' data-toggle='modal' data-target='#confDepartamentos' data-accion='editar' data-id='".$row['id']."'><span class='glyphicon glyphicon-pencil'></span></button>";
										echo " <button class='btn btn-xs btn-danger cambiar_estado' id='".$row['id']."' de='ubicacion' estado='2'><span class='glyphicon glyphicon-remove'></span></button>";
										echo "</td>";
										echo "</tr>";
									}
								}else{
									echo "<tr><td colspan='5'>No hay departamentos registrados.</td></tr>";
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php require("css/footer.php") ?>
	<?php require("libs/jsLibs.php") ?>
</body>
</html>