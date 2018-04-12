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
		<div class="modal fade" id="confSerCategoria" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><!--Dinamico--></h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id" value="0">
						<input type="hidden" name="accion" value="registrar_ser_categoria">
						<div class="form-group">
							<label for="nombre">Nombre:</label>
							<input type="text" class="form-control" name="nombre" placeholder="Nombre">
						</div>
						<div class="form-group">
							<label for="nombre">Precio(Bs.F.):</label>
							<input type="text" class="form-control monto" name="precio" placeholder="Precio">
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
				<h3 class="text-center">Configuraci&oacute;n de Servicios Generales</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<div class="panel panel-success">
					<div class="panel-heading">Servicios
						<button class="btn btn-sm btn-default pull-right" data-toggle="modal" data-target="#confSerCategoria" data-accion="agregar"><span class="glyphicon glyphicon-plus"></span> Agregar</button></div>
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
								<th>Nombre</th>
								<th>Precio</th>
								<th></th>
							</thead>
							<tbody>
							<?php
								$ser_categoria = new MiClase();
								if($ser_categoria->obtener_ser_categoria()){
									while($row=$ser_categoria->array->fetch_assoc()){
										echo "<tr>";
										echo "<td>".$row['nombre']."</td>";
										echo "<td>Bs.F ".number_format($row['precio'], 2, ',', '.')."</td>";
										echo "<td>";
										echo "<button class='btn btn-xs btn-warning' data-toggle='modal' data-target='#confSerCategoria' data-accion='editar' data-id='".$row['id']."'><span class='glyphicon glyphicon-pencil'></span></button>";
										echo " <button class='btn btn-xs btn-danger cambiar_estado' id='".$row['id']."' de='ser_categoria' estado='2'><span class='glyphicon glyphicon-remove'></span></button>";
										echo "</td>";
										echo "</tr>";
									}
								}else{
									echo "<tr><td colspan='5'><em>No hay servicios registrados.</em></td></tr>";
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