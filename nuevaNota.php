<?php require("seguridad.php") ?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body class="changeBG">
	<?php require("css/header.php") ?>

	<div class="container">
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<h3 class="text-center" style="color:#000">Nueva nota de servicio</h3>

				<!-- PANEL CLIENTE -->
				<div class="panel panel-primary ">
					<div class="panel-heading">Datos del Cliente</div>
					<div class="panel-content">
						<div class="container-fluid">
							<div class="row" style="padding:8px 0px">
								<div class="col-sm-12">
									<div class="well">
										<form class="form-inline" id="buscarCliente">
											<div class="form-group">
												<select class="form-control" name="predocumento">
													<option>V</option>
													<option>J</option>
													<option>E</option>
												</select>
												<input type="text" class="form-control" name="documento" placeholder="Buscar cliente" onkeypress="return isNumber(event)" autofocus="">
											</div>
											<button class="btn btn-default" type="submit">Buscar</button>
										</form>
									</div>
									<h4>Informaci&oacute;n del cliente</h4>
								</div>
							</div>
							<div class="row">
								<form id="cliente_quick_form">
									<input type="hidden" name="id">
									<input type="hidden" name="accion" value="registrar_cliente_quick">
									<div class="col-sm-6">
										<div class="form-group">
											<label style="display:block">C&eacute;dula / Rif *</label>
											<select class="form-control" style="display:inline-block; width:auto" name="predocumento" required="" id="predocumento">
												<option value="V">V</option>
												<option value="J">J</option>
												<option value="E">E</option>
											</select>
											<input class="form-control" style="display:inline-block; width:auto" type="text" name="documento" maxlength="8" placeholder="C&eacute;dula / Rif" required="" onkeypress="return isNumber(event)" id="documento">
										</div>
										<div class="form-group">
											<label>Nombre o Raz&oacute;n social *</label>
											<input type="text" class="form-control" name="cliente" required="" placeholder="Nombre o Raz&oacute;n social" maxlength="50">
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
										<div class="form-group">
											<button class="btn btn-block btn-primary" type="submit">Guardar</button>
										</div>
										<p class="text-danger">* Campo obligatorio</p>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<!-- PANEL EXTINTOR -->
				<div class="panel panel-info">
					<div class="panel-heading">Informaci&oacute;n de Servicio</div>
					<div class="panel-content">
						<div class="container-fluid">
							<form id="guardarNotaForm">
								<table class="table table-condensed" id="table_ext">
									<thead>
										<th>Categoria</th>
										<th>Extintor</th>
										<th>Servicio</th>
										<th>Cantidad</th>
										<th></th>
									</thead>
									<tbody>
										<tr>
											<td>
												<select class="form-control" name="id_ext_categoria" required="" onchange="cargar_extintores_by_categoria(this)">
												<?php
													$Categorias = new MiClase();
													if($Categorias->obtener_categorias()){
														while($row=$Categorias->array->fetch_assoc()){
															echo "<option value='".$row['id']."'>".$row['nombre']."</option>";
														}
													}
												?>
												</select>
											</td>
											<td>
												<select class="form-control" name="id_extintor" required="">
													<!-- dinamico -->
												</select>
											</td>
											<td>
												<select class="form-control" name="id_ser_categoria" required="">
												<?php
													$ser_categoria = new MiClase();
													if($ser_categoria->obtener_ser_categoria()){
														while($row=$ser_categoria->array->fetch_assoc()){
															echo "<option value='".$row['id']."'>".$row['nombre']."</option>";
														}
													}
												?>
												</select>
											</td>
											<td>
												<select class="form-control" name="cantidad" required="">
												<?php 
													for($i=1; $i<21;$i++){
														echo "<option value='".$i."'>".$i."</option>";
													}
												?>
												</select>
											</td>
											<td>
												<button class="btn btn-sm btn-danger delete_this_tr" type="button"><span class='glyphicon glyphicon-remove'></span></button>
											</td>
										</tr>
									</tbody>
									<tfoot>
										<th>
											<button class="btn btn-default" type="button" onclick="agregar_extintor_table()">Agregar otro</button>
										</th>
									</tfoot>
								</table>
								<div class="form-group">
									<button class="btn btn-block btn-primary" type="submit">Guardar nota</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php require("css/footer.php") ?>

	<?php require("libs/jsLibs.php") ?>
	<script type="text/javascript">
		$("table#table_ext tbody tr").each(function(){
			_select = $(this).find("select[name=id_ext_categoria]")
			cargar_extintores_by_categoria(_select);
		})
		$("select#predocumento").change(function(){
				valor = $(this).val();
				if(valor == "V" || valor == "E"){
					$("input#documento").attr("maxlength", "8");
					$("input#documento").val( $("input#documento").val().substring(0, 8) );
				}else if(valor == "J" ){
					$("input#documento").attr("maxlength", "9");
				}
			});
	</script>
</body>
</html>