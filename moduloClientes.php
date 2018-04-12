<?php require("seguridad.php") ?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body>
	<?php require("css/header.php") ?>

	<!-- Modal -->
	<form id="formModal">
		<div class="modal fade" id="confClientes" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><!--dinamico--></h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="accion" value="registrar_cliente">
						<input type="hidden" name="id" value="0">
						<div class="container-fluid">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label style="display:block">C&eacute;dula / Rif *</label>
										<select class="form-control" name="predocumento" id="predocumento" style="display:inline-block; width:auto" required="">
											<option>V</option>
											<option>E</option>
											<option>J</option>
										</select>
										<input class="form-control" style="display:inline-block; width:150px" type="text" name="documento" placeholder="C&eacute;dula / Rif" onkeypress="return isNumber(event)" maxlength="8" id="documento" required="">
									</div>
									<div class="form-group">
										<label>Nombre o Raz&oacute;n social *</label>
										<input type="text" class="form-control" name="cliente" placeholder="Nombre o Raz&oacute;n social" maxlength="50" required="">
									</div>
									<div class="form-group">
										<label>Email *</label>
										<input type="email" class="form-control" name="email" placeholder="Email" maxlength="70" required="">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Tel&eacute;fono 1 *</label>
										<input type="text" class="form-control phone" name="telefono1" placeholder="(9999) 999-9999" maxlength="15" required="">
									</div>
									<div class="form-group">
										<label>Tel&eacute;fono 2</label>
										<input type="text" class="form-control phone" name="telefono2" placeholder="(9999) 999-9999" maxlength="15">
									</div>
									<div class="form-group">
										<label>Direcci&oacute;n *</label>
										<textarea class="form-control" name="direccion" placeholder="Direcci&oacute;n" required=""></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
					<p class="text-danger">* Todos los campos son obligatorios.</p>
						<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">cerrar</button>
						<button type="submit" class="btn btn-default">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3>Nuestros clientes <button class="btn btn-md btn-primary pull-right" data-toggle="modal" data-target="#confClientes" data-accion="agregar"><span class="glyphicon glyphicon-plus"></span> Agregar Nuevo</button></h3>
				<form class="form-inline">
					<div class="input-group">
						<input type="text" id="searcher_01" class="form-control" placeholder="Buscar">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
						</span>
					</div>
				</form>
				<br>
				<table class="table table-condensed" style="font-size:13px; background-color:white">
					<thead>
						<th>Cliente</th>
						<th>Documento</th>
						<th>Email</th>
						<th>Tel&eacute;fono</th>
						<th>Direcci&oacute;n</th>
						<th>Fecha de registro</th>
						<th>Opciones</th>
					</thead>
					<tbody>
					<?php
						$cliente = new Clientes();
						if($cliente->obtener_clientes()){
							while($row=$cliente->array->fetch_assoc()){
								echo "<tr>";
								echo "<td>".$row['cliente']."</td>";
								echo "<td>".$row['documento']."</td>";
								echo "<td>".$row['email']."</td>";
								echo "<td>".$row['telefono1']."</td>";
								echo "<td>".$row['direccion']."</td>";
								echo "<td>".date("d-m-Y", strtotime($row['fecha_registro']))."</td>";
								echo "<td>";
									echo "<button class='btn btn-xs btn-warning' data-toggle='modal' data-target='#confClientes' data-accion='editar' data-id='".$row['id']."'><span class='glyphicon glyphicon-pencil'></span></button> ";
									echo "<button class='btn btn-xs btn-danger cambiar_estado' id='".$row['id']."' de='cliente' estado=2><span class='glyphicon glyphicon-trash'></span></button>";
								echo "</td>";
								echo "</tr>";
							}
						}else{
							echo "<tr><td colspan='5'>No hay clientes registrados.</td></tr>";
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php require("css/footer.php") ?>
	<?php require("libs/jsLibs.php") ?>
	<script>
		$(function(){
			$("select#predocumento").change(function(){
				valor = $(this).val();
				if(valor == "V" || valor == "E"){
					$("input#documento").attr("maxlength", "8");
					$("input#documento").val( $("input#documento").val().substring(0, 8) );
				}else if(valor == "J" ){
					$("input#documento").attr("maxlength", "9");
				}
			});

		})
	</script>
</body>
</html>