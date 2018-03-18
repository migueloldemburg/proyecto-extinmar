<?php require("seguridad.php") ?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body>
	<?php require("css/header.php") ?>

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
			<div class="col-sm-5">
				<h4>Buscar servicios de extintores</h4>
				<!-- PANEL DE BUSQUEDA -->
				<div class="panel panel-info">
					<div class="panel-heading">Buscar Nota</div>
					<div class="panel-content">
						<div class="well">
							<form id="buscar_notas_01" class="form-inline">
								<input type="hidden" name="accion" value="buscar_extintores_with_servicios_fecha">
							    <input type="text" class="form-control from" name="from" placeholder="Desde" value="<?php echo date("d-m-Y") ?>">
							    <input type="text" class="form-control to" name="to" placeholder="Hasta" value="<?php echo date("d-m-Y") ?>">
							    <button class="btn btn-info">Buscar</button>
							</form>
						</div>
					</div>
				</div>

			</div>
			<div class="col-sm-12">
				<!-- PANEL DE DETALLE -->
				<div class="panel panel-info ">
					<div class="panel-heading">Detalle de Nota</div>
					<div class="panel-content">
						<div class="table-responsive">
							<table class="table table-condensed" style="font-size:13px">
								<thead>
									<th>N#</th>
									<th>Categoria</th>
									<th>Extintor</th>
									<th>Servicio</th>
									<th>Estado</th>
									<th>Ver</th>
								</thead>
								<tbody id="recargar_notas">
									<!-- Dinamico -->
									<tr>
										<td colspan="6"><em>Seleccionar nota</em></td>
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
	<script>
		$(function(){
			$("#buscar_notas_01").trigger("submit");
		})
	</script>
</body>
</html>
