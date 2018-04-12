<?php require("seguridad.php") ?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body>

	<!-- Modal Servicos de Extintores -->
	<form id="formModal">
		<div class="modal fade" id="confServiciosExtintor" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h5 class="modal-title">Agregar servicio a extintor</h5>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id_extintor" value="0">
						<input type="hidden" name="accion" value="agregar_servicio_a_extintor">
						<input type="hidden" name="index" value="0">
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

	<?php require("css/header.php") ?>

	<div class="container">
		<?php       
		if(isset($_SESSION['nota'])){ 
		?>
			<div class="row">
				<div class="col-sm-12">
					<button class="btn btn-default btn-lg pull-right" id="confirmar_orden_boton">Confirmar Orden</button>
				</div>
			</div>
		<?php       
		}
		?>
		<div class="row">
			<h3>Servicios agregados por extintor</h3>
<?php       if(isset($_SESSION['nota'])){
				foreach ($_SESSION['nota'] as $key => $value)
				{
					$extintor = new MiClase();
					$extintor->obtener_extintor_by_id($_SESSION['nota'][$key]['id_extintor']);

					$ser_categoria = new MiClase();
					$ser_categoria->obtener_ser_categoria_by_id($_SESSION['nota'][$key]['id_ser_categoria'])
?>
				<div class="col-sm-4">
					<!-- PANEL EXTINTOR -->
					<div class="panel panel-primary">
						<div class="panel-heading">
							<?php echo $extintor->nombre_categoria." ".$extintor->capacidad."lbs ".$ser_categoria->nombre ?>
							<button class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#confServiciosExtintor" data-index="<?php echo $key ?>">Agregar</button>
						</div>
						<div class="panel-content">
							<div class="container-fluid">
								<table class="table table-condensed">
									<thead>
										<th>Servicio agregado</th>
										<th>Cantidad</th>
										<th></th>
									</thead>
									<tbody>
									<?php
										foreach($_SESSION['nota'][$key]['servicios'] as $position => $servicios)
										{
											$servicio = new MiClase();
											if($servicio->obtener_servicio_by_id($servicios['id_servicio']))
											{
												echo "<tr>";
												echo "<td>".$servicio->nombre."</td>";
												if($servicio->tipo=='quimico'){
													$unidad = preg_replace('/[^A-Za]+/', '', $servicio->cantidad);
													echo "<td>".$servicios['cantidad'].$unidad."</td>";
												}else{
													echo "<td>".$servicios['cantidad']."</td>";
												}
												echo "<td><button class='btn btn-xs btn-danger remover_ser_extintor' position='".$position."' index='".$key."'><span class='glyphicon glyphicon-remove'></span></button></td>";
												echo "</tr>";
											}else{

											}
										}
									?>
									</tbody>
								</table>
								</form>
							</div>
						</div>
					</div>
				</div>
<?php
				}
			}else{
				echo "<h3>No hay notas cargadas.</h3>";
				echo "<a href='nuevaNota.php' class='btn btn-default'>Tomar nueva nota</a>";
			}
?>
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