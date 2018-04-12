<?php require("seguridad.php") ?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body>
	<?php require("css/header.php") ?>

	<!-- Modal servicios -->
	<form id="formModal">
		<div class="modal fade" id="asociaServicio" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><!--Dinamico--></h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="accion" value="asociar_servicio">
						<input type="hidden" name="id_ser_categoria" value="0">
						<div class="form-group">
							<label for="nombre">Servicio a asociar:</label>
							<select class="form-control" name="id_servicio">
							<?php
								$ser_categoria = new MiClase();
								if($ser_categoria->obtener_servicios('servicio')){
									while($row=$ser_categoria->array->fetch_assoc()){
										echo "<option value='".$row['id']."'>".$row['nombre']." - ".number_format($row['precio'], 2, ',', '.')."</option>";
									}
								}
							?>
							</select>
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
				<h3 class="text-center">Detalles de Servicio</h3>
			</div>
		</div>
		<div class="row">
		<?php
			$ser_categoria = new MiClase();
			if($ser_categoria->obtener_ser_categoria_not_repuestos()){
				while($row=$ser_categoria->array->fetch_assoc())
				{
				?>
				<div class="col-md-3">
					<div class="panel panel-primary">
						<div class="panel-heading"><?php echo $row['nombre'] ?>
							<button class="btn btn-xs btn-default pull-right" data-toggle="modal" data-target="#asociaServicio" data-accion="agregar" data-idsercategoria="<?php echo $row['id'] ?>"><span class="glyphicon glyphicon-plus"></span> Agregar</button></div>
						<div class="panel-content">
							<table class="table table-condensed" style="font-size:12px">
								<thead>
									<th>Nombre</th>
									<th>Precio</th>
								</thead>
								<tbody>
								<?php
									$servicios = new MiClase();
									if($servicios->obtener_servicios_categoria($row['id'])){
										while($row2=$servicios->array->fetch_assoc()){
											echo "<tr>";
											echo "<td>".$row2['nombre']."</td>";
											echo "<td>Bs.F.".number_format($row2['precio'], 2, ',', '.')."</td>";
											echo "<td>";
												// echo "<button class='btn btn-xs btn-warning' data-toggle='modal' data-target='#' data-accion='editar' data-id='".$row2['id']."'><span class='glyphicon glyphicon-pencil'></span></button> ";
												echo "<button class='btn btn-xs btn-danger delete_from' id='".$row2['id']."' de='ser_categoria_por_defecto'><span class='glyphicon glyphicon-remove'></span></button>";
											echo "</td>";
											echo "</tr>";
										}
									}else{
										echo "<tr><td colspan='5'>No hay detalles registrados.</td></tr>";
									}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php
				}
			}else{
				echo "<tr><td colspan='5'><em>No hay servicios registrados.</em></td></tr>";
			}
		?>
		</div>
	</div>
	<br><br><br><br><br><br><br>
	<?php require("css/footer.php") ?>
	<?php require("libs/jsLibs.php") ?>
</body>
</html>