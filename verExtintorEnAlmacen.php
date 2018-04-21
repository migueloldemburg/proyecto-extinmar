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
					<div class="panel-heading">Buscar extintores en almac&eacute;n por rango de fecha y ubicaci&oacute;n</div>
					<div class="panel-content">
						<div class="well">
							<form class="form-inline" id="buscar_extintor_fecha">
								<input type="hidden" name="accion" value="buscar_extintor_fecha">
							    <input type="text" class="form-control from" name="from" placeholder="Desde" value="<?php echo date("d-m-Y") ?>">
							    <input type="text" class="form-control to" name="to" placeholder="Hasta" value="<?php echo date("d-m-Y") ?>">
							    <select class="form-control" name="id_ubicacion">
							    <?php
									$departamentos = new MiClase();
									if($departamentos->obtener_departamentos()){
										echo "<option value='0'>Todos</option>";
										while($row=$departamentos->array->fetch_assoc()){
											echo "<option value='".$row['id']."'>".$row['departamento']." ".$row['pasillo']."</option>";
										}
									}else{
										echo "<tr><td colspan='5'>No hay departamentos registrados.</td></tr>";
									}
								?>
							    </select>
							    <button class="btn btn-info">Buscar</button>
							    <button class="btn btn-warning" onclick="imprimir_reporte_01()">Imprimir</button>
							    <button class="btn btn-primary" onclick="imprimir_reporte_01(true)">PDF</button>
							</form>
						</div>
						<div clasx="table-responsive">
							<table class="table table-condensed " style="font-size:13px">
								<thead>
									<th>C&oacute;digo</th>
									<th>Tipo</th>
									<th>Capacidad</th>
									<th>Servicio</th>
									<th>Fecha Registro</th>
									<th>Ubicaci&oacute;n</th>
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
	<?php require("css/footer.php") ?>
	<?php require("libs/jsLibs.php") ?>
</body>
</html>