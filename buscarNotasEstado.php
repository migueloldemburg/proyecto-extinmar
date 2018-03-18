<?php require("seguridad.php") ?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body>
	<?php require("css/header.php") ?>

	<!-- Modal -->
	<div class="modal fade" id="verExtintores" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Extintores</h4>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<table class="table table-condensed" style="font-size:13px">
							<thead>
								<th>Categoria</th>
								<th>Extintor</th>
								<th>Servicio</th>
								<th>Ubicaci&oacute;n</th>
								<th>Estado</th>
								<th>Acci&oacute;n</th>
							</thead>
							<tbody id="ver_extintores_notas">
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

	<!-- Modal -->
	<div class="modal fade" id="verServicios" tabindex="-1" role="dialog">
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
								<th>Acci&oacute;n</th>
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
					<div class="panel-heading">Buscar Nota de Servicio por Estado</div>
					<div class="panel-content">
						<div class="well">
							<form class="form-inline" id="buscar_notas_por_estado">
								<input type="hidden" name="accion" value="buscar_notas_por_estado">
								<input type="text" class="form-control" name="id_nota" placeholder="C&oacute;digo" style="width:140px">
							    <input type="text" class="form-control from" name="from" placeholder="Desde" value="<?php echo date("d-m-Y") ?>">
							    <input type="text" class="form-control to" name="to" placeholder="Hasta" value="<?php echo date("d-m-Y") ?>">
							    <select class="form-control" name="estado">
							    	<option value="0">Emitidas</option>
							    	<option value="1">En Taller</option>
							    	<option value="2">Listas</option>
							    	<option value="3">Retiradas</option>
							    	<option value="4">Canceladas</option>
							    </select>
							    <button class="btn btn-info">Buscar</button>
							     <button class="btn btn-warning" onclick="imprimir_reporte_03()">Imprimir</button>
							</form>
						</div>
						<div clasx="table-responsive">
							<table class="table table-condensed table-striped" style="font-size:13px">
								<thead>
									<th>N&uacute;mero</th>
									<th>Cliente</th>
									<th>Extintores</th>
									<th>Fecha</th>
									<th>Estado</th>
									<th>Acci&oacute;n</th>
								</thead>
								<tbody id="recargar_notas">
									<tr>
										<td colspan="6"><em>Coloque el estado y el rango de fecha.</em></td>
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