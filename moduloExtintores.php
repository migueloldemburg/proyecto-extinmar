<?php require("seguridad.php") ?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body>
	<?php require("css/header.php") ?>

	<!-- Modal Categorias -->
	<form id="formModal">
		<div class="modal fade" id="confCategorias" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><!--Dinamico--></h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id" value="0">
						<input type="hidden" name="accion" value="registrar_categoria">
						<div class="form-group">
							<label for="nombre">Nombre:</label>
							<input type="text" class="form-control" name="nombre" placeholder="Nombre de la categor&iacute;a">
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

	<!-- Modal Extintores -->
	<form id="formModal">
		<div class="modal fade" id="confExtintores" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><!--Dinamico--></h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id" value="0">
						<input type="hidden" name="accion" value="registrar_extintor">
						<div class="form-group">
							<label for="nombre">Categor&iacute;a:</label>
							<select class="form-control" name="categoria">
							<?php
								$Categorias = new MiClase();
								if($Categorias->obtener_categorias()){
									while($row=$Categorias->array->fetch_assoc()){
										echo "<option value='".$row['id']."'>".$row['nombre']."</option>";
									}
								}
							?>
							</select>
						</div>
						<div class="form-group">
							<label for="nombre">Capacidad (libras):</label>
							<input type="text" class="form-control" name="capacidad" onkeypress="return isDecimal(event)" placeholder="Capacidad en libras">
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

	<!-- Modal Servicos de Extintores -->
	<form id="formModal">
		<div class="modal fade" id="confServiciosExtintor" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h5 class="modal-title">Colocar por defecto un servicio para el extintor</h5>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id_extintor" value="0">
						<input type="hidden" name="accion" value="asociar_servicio_a_extintor">
						<div class="form-group">
							<label for="tipo">Tipo:</label>
							<select class="form-control" onchange="cargar_servicio_por_tipo(this.value)" name="tipo">
								<option value="quimico">QU&Iacute;MICO</option>
								<option value="servicio">SERVICIO</option>
								<option value="repuesto">REPUESTO</option>
							</select>
						</div>
						<div class="form-group">
							<label for="id_servicio">Servicio:</label>
							<select class="form-control" name="id_servicio">
								<!-- Dinamico -->
							</select>
						</div>
						<div class="form-group">
							<label for="cantidad">Cantidad:</label>
							<input type="text" class="form-control" required="" onkeypress="return isDecimal(event)" name="cantidad">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-sm btn-default">Agregar</button>
					</div>
				</div>
			</div>
		</div>
	</form>	

	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="text-center">Configuraci&oacute;n de Extintores y Categor&iacute;as</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3">
				<div class="panel panel-primary">
					<div class="panel-heading">Categor&iacute;as 
						<button class="btn btn-sm btn-default pull-right" data-toggle="modal" data-target="#confCategorias" data-accion="agregar"><span class="glyphicon glyphicon-plus"></span> Agregar</button></div>
					<div class="panel-content">
						<table class="table table-condensed">
							<thead>
								<th>Nombre de Categor&iacute;a</th>
								<th></th>
							</thead>
							<tbody>
							<?php
								$Categorias = new MiClase();
								if($Categorias->obtener_categorias()){
									while($row=$Categorias->array->fetch_assoc()){
										echo "<tr class='escoger_categoria' id='".$row['id']."'>";
										echo "<td>".$row['nombre']."</td>";
										echo "<td>";
											echo "<button class='btn btn-xs btn-warning' data-toggle='modal' data-target='#confCategorias' data-accion='editar' data-id='".$row['id']."'><span class='glyphicon glyphicon-pencil'></span></button> ";
											echo "<button class='btn btn-xs btn-danger cambiar_estado' id='".$row['id']."' de='ext_categoria' estado=2><span class='glyphicon glyphicon-remove'></span></button>";
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
			<div class="col-sm-4">
				<div class="panel panel-primary">
					<div class="panel-heading">Extintores 
						<button class="btn btn-sm btn-default pull-right" data-toggle="modal" data-target="#confExtintores" data-accion="agregar"><span class="glyphicon glyphicon-plus"></span> Agregar</button></div>
					<div class="panel-content">
						<table class="table table-condensed">
							<thead>
								<th>Categor&iacute;a</th>
								<th>Capacidad</th>
								<th></th>
							</thead>
							<tbody id="cargar_extintores">
								<!-- Dinamico -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-sm-5">
				<div class="panel panel-info">
					<div class="panel-heading">Servicios por Defecto para Extintor 
						<button class="btn btn-sm btn-default pull-right" data-toggle="modal" data-target="#confServiciosExtintor"><span class="glyphicon glyphicon-plus"></span> Agregar</button></div>
					<div class="panel-content">
						<table class="table table-condensed table-hover">
							<thead>
								<th>Capacidad</th>
								<th>Nombre</th>
								<th>Cantidad</th>
								<th></th>
							</thead>
							<tbody id="cargar_serv_defecto">
								<!-- Dinamico -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php require("libs/jsLibs.php") ?>
	<script>
		$(function(){
			cargar_servicio_por_tipo('quimico')
		})
	</script>
</body>
</html>