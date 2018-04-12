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
			<div class="col-sm-8">
				<h3 class="text-center">Cantidades de Qu&iacute;micos seg&uacute;n Categoria</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<div class="panel panel-danger">
					<div class="panel-heading">Qu&iacute;micos</div>
					<div class="panel-content">
						<br>
						<form class="form-inline" id="buscar_quimico_categoria">
						<input type="hidden" name="accion" value="buscar_quimico_categoria">
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
						    <button class="btn btn-warning" onclick="imprimir_reporte_04()">Imprimir</button>
						    <button class="btn btn-primary" onclick="imprimir_reporte_04(true)">PDF</button>
						</form>
						<br>
						<table class="table table-condensed table-hover">
							<thead>
								<th>C&oacute;digo</th>
								<th>Categor&iacute;a</th>
								<th>Nombre</th>
								<th>Cantidad</th>
								<th>Ubicacion</th>
							</thead>
							<tbody id="recargar_cantidad">
							
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