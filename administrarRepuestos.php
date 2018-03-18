<?php require("seguridad.php") ?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body>
	<?php require("css/header.php") ?>

	<!-- Modal Servicios -->
	<form id="formModal">
		<div class="modal fade" id="manageStock" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><!--Dinamico--></h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id" value="0">
						<input type="hidden" name="accion" value="registrar_servicio">
						<div class="form-group">
							<label for="cantidad">Cantidad:</label>
							<input type="text" class="form-control" name="cantidad" placeholder="Cantidad" onkeypress="return isNumber(event)">
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
				<h3 class="text-center">Almac&eacute;n de Repuestos Extinmar C.A</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-primary">
					<div class="panel-heading">Repuestos</div>
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
								<th>C&oacute;digo</th>
								<th>Nombre</th>
								<th>Precio</th>
								<th>Cantidad</th>
								<th>Ubicaci&oacute;n</th>
								<th>Acci&oacute;n</th>
							</thead>
							<tbody>
							<?php
								$ser_categoria = new MiClase();
								if($ser_categoria->obtener_servicios('repuesto')){
									while($row=$ser_categoria->array->fetch_assoc()){
										echo "<tr>";
										echo "<td>".$row['id']."</td>";
										echo "<td>".$row['nombre']."</td>";
										echo "<td>Bs.F ".number_format($row['precio'], 2, ',', '.')."</td>";
										echo "<td>".$row['cantidad']."</td>";
										echo "<td>".$row['departamento']." - ".$row['pasillo']."</td>";
										echo "<td>";
										echo "<button class='btn btn-xs btn-warning' data-toggle='modal' data-target='#manageStock' data-accion='sumar' data-id='".$row['id']."'><span class='glyphicon glyphicon-plus'></span></button>";
										echo " <button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#manageStock' data-accion='restar' data-id='".$row['id']."'><span class='glyphicon glyphicon-minus'></span></button>";
										echo "</td>";
										echo "</tr>";
									}
								}else{
									echo "<tr><td colspan='5'><em>No hay qu&iacute;micos registrados.</em></td></tr>";
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php require("libs/jsLibs.php") ?>
</body>
</html>