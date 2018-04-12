<?php 
	require("seguridad.php");

	$nota = new Notas();
	$nota->obtener_nota_por_id($_GET['id_nota']);

	if($nota->estado==0){
		$nota->cambiar_estado_nota($_GET['id_nota'], 1);
	}
	
	$cliente = new Clientes();
	$cliente->obtener_cliente_by_id($nota->id_cliente);
?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body>

	<!-- Modal Servicos de Extintores -->
	<form id="formModal">
		<div class="modal fade" id="confServiciosExtintorEnTaller" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h5 class="modal-title">Agregar servicio a extintor</h5>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id_nota_extintor" value="0">
						<input type="hidden" name="accion" value="agregar_servicio_a_extintor_en_taller">
						<div class="form-group">
							<label for="tipo">Tipo:</label>
							<select class="form-control" onchange="cargar_servicio_por_tipoTaller(this.value)" name="tipo">
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
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<button class="btn btn-lg btn-primary pull-right" onclick="completar_servicio(<?php echo $nota->id ?>)">Servicio completado</button>
				<h3 class="text-center">Nota de Servicio # <?php echo $nota->id ?></h3>
				<!-- PANEL CLIENTE -->
				<div class="panel panel-info ">
					<div class="panel-heading">Datos del Cliente</div>
					<div class="panel-content">
						<div class="container-fluid">
							<div class="row">
								<form>
									<div class="col-sm-6">
										<div class="form-group">
											<label style="display:block">C&eacute;dula / Rif</label>
											<select class="form-control" style="display:inline-block; width:auto" disabled="">
												<option value="v" <?php if($cliente->predocumento == 'v') echo 'selected;' ?>>V</option>
												<option value="j" <?php if($cliente->predocumento == 'v') echo 'selected;' ?>>J</option>
												<option value="e" <?php if($cliente->predocumento == 'e') echo 'selected;' ?>>E</option>
											</select>
											<input class="form-control" style="display:inline-block; width:auto" type="text" name="documento" placeholder="C&eacute;dula / Rif" onkeypress="return isNumber(event)" value="<?php echo filter_var($cliente->documento, FILTER_SANITIZE_NUMBER_INT) ?>" disabled="">
										</div>
										<div class="form-group">
											<label>Nombre o Raz&oacute;n social</label>
											<input type="text" class="form-control" name="nombre" placeholder="Nombre o Raz&oacute;n social" value="<?php echo $cliente->cliente ?>" disabled="">
										</div>
										<div class="form-group">
											<label>Email</label>
											<input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $cliente->email ?>" disabled="">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Tel&eacute;fono 1</label>
											<input type="text" class="form-control phone" name="telefono1" placeholder="(9999) 999-9999" value="<?php echo $cliente->telefono1 ?>" disabled="">
										</div>
										<div class="form-group">
											<label>Tel&eacute;fono 2</label>
											<input type="text" class="form-control phone" name="telefono2" placeholder="(9999) 999-9999" value="<?php echo $cliente->telefono2 ?>" disabled="">
										</div>
										<div class="form-group">
											<label>Direcci&oacute;n</label>
											<textarea class="form-control" name="direccion" placeholder="Direcci&oacute;n" disabled=""><?php echo $cliente->direccion ?></textarea>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<button class="btn btn-warning" onclick="chequear_productos_almacen(<?php echo $nota->id ?>)">Chequear servicos en almac&eacute;n</button>
				<br><br>
			</div>
		</div>
		<div class="row">
		<?php
			$extintores = new Notas();
			if($extintores->obtener_extintores_nota($nota->id))
			{
				$nota = new Notas();
				while($row=$extintores->array->fetch_assoc())
				{
				?>
					<div class="col-sm-4">
						<!-- PANEL EXTINTOR -->
						<div class="panel panel-primary">
							<div class="panel-heading"><?php echo $row['categoria']." ".$row['capacidad']."lbs ".$row['servicio_general'] ?>
								<select class="form-control est_01 ubi_01" name="estado" id="<?php echo $row['id'] ?>" style="width:auto">
									<?php
									$departamentos = new MiClase();
									if($departamentos->obtener_departamentos()){
										echo "<option value='0'>Sin asignar</option>";
										while($dep=$departamentos->array->fetch_assoc()){
											if($row['id_ubicacion'] == $dep['id']){
												echo "<option value='".$dep['id']."' selected>".$dep['departamento']."-".$dep['pasillo']."</option>";
											}else{
												echo "<option value='".$dep['id']."'>".$dep['departamento']."-".$dep['pasillo']."</option>";
											}
										}
									}
									?>
								</select>
								<button class="btn btn-danger btn-xs pull-right" data-toggle="modal" data-target="#confServiciosExtintorEnTaller" data-idnotaextintor="<?php echo $row['id'] ?>">Agregar</button>
							</div>
							<div class="panel-content">
								<div class="container-fluid">
									<table class="table table-condensed">
										<thead>
											<th>Servicio</th>
											<th>Estado</th>
										</thead>
										<tbody>
											<?php
											$servicios = new Notas();	
											if($servicios->obtener_servicios_nota($row['id']))
											{
												$nota = new Notas();
												while($row2=$servicios->array->fetch_assoc())
												{
											?>
												<tr>
													<td><?php echo $row2['nombre'] ?></td>
													<td>
													 <select class="form-control est_01 cambiar_estado_select" name="estado" id="<?php echo $row2['id'] ?>" de='servicio_extintor'>
												    	<option value="1" <?php if($row2['estado']==1) echo 'selected' ?>>En Taller</option>
												    	<option value="2" <?php if($row2['estado']==2) echo 'selected' ?>>Listo</option>
												    	<option value="4" <?php if($row2['estado']==4) echo 'selected' ?>>Cancelado</option>
													   </select>
													</td>
												</tr>
											<?php
												}
											}else{
												echo "<tr><td colspan='2'><em>Parece que no hay servicios agregados.</em></td></tr>";
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				<?php
				}
			}else{
				echo "<tr><td colspan='5'><em>Parece que no hay extintores agregados.</em></td></tr>";
			}
		?>
		</div>
	</div>
	<?php require("css/footer.php") ?>

	<?php require("libs/jsLibs.php") ?>
	<script>
		$(function(){
			cargar_servicio_por_tipoTaller('quimico')
		})
	</script>
</body>
</html>