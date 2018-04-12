<?php require("seguridad.php") ?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body>
	<?php require("css/header.php") ?>

	<!-- Modal -->
	<div class="modal fade" id="verServicios2" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Servicios</h4>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<table class="table table-condensed" style="font-size:13px">
							<thead>
								<th>Servicio</th>
								<th>Estado</th>
							</thead>
							<tbody id="recargar_servicios">
								<!-- Dinamico -->
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">

				<!-- PANEL DE BUSQUEDA -->
				<div class="panel panel-primary">
					<div class="panel-heading">Buscar Extintores En Almac&eacute;n por Categoria</div>
					<div class="panel-content">
						<div class="well">
							<form class="form-inline" id="buscar_extintor_fecha">
								<input type="hidden" name="accion" value="buscar_extintor_categoria">
								<label>Categoria: </label>								
							    <select class="form-control" name="id_ext_categoria">
							    <?php									
									$Categorias = new MiClase();
									if($Categorias->obtener_categorias()){
										echo "<option value='0'>Todas</option>";
										while($row=$Categorias->array->fetch_assoc()){
											echo "<option value='".$row['id']."'>".$row['nombre']."</option>";
										}
									}
							
								?>
							    </select>
							    <button class="btn btn-info">Buscar</button>
							    <button class="btn btn-warning" onclick="imprimir_reporte_02()">Imprimir</button>
							</form>
						</div>
						<div clasx="table-responsive">
							<table class="table table-condensed table-striped" style="font-size:13px">
								<thead>
									<th>Id</th>
									<th>Tipo</th>
									<th>Capacidad</th>
									<th>Servicio</th>
									<th>Fecha Registro</th>
									<th>Fecha Entrega</th>
									<th>Estado</th>
									<th>Acci&oacute;n</th>
								</thead>
								<tbody id="recargar_tabla">
									<tr>
										<td colspan="8"><em>Coloque el estado y el rango de fecha.</em></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php require("libs/jsLibs.php") ?>
</body>
</html>