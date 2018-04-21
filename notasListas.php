<?php require("seguridad.php") ?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body>
	<form id="formModal">
		<div class="modal fade" id="dar_de_baja" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h5 class="modal-title">Procesar esta nota</h5>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id_nota" value="0">
						<input type="hidden" name="accion" value="dar_de_baja">
						<button type="submit" class="btn btn-sm btn-default btn-block">Agregar</button>
					</div>
				</div>
			</div>
		</div>
	</form>	

	<?php require("css/header.php") ?>

	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3>Ordenes listas</h3>
				<!-- PANEL DE BUSQUEDA -->
				<div class="panel panel-success">
					<div class="panel-heading">Buscar Nota</div>
					<div class="panel-content">
						<div class="well">
							<form class="form-inline" id="buscar_notas_03">
								<input type="hidden" name="accion" value="buscar_notas_04">
								<input type="hidden" name="estado" value="2">
								<input type="text" class="form-control" name="id_nota" placeholder="C&oacute;digo" style="width:100px">
								<input type="text" class="form-control from" name="from" value="<?php echo date("d-m-Y") ?>" placeholder="<?php echo date("Y-m-d") ?>">
								<div class="input-group">
							     	<input type="text" class="form-control to" name="to" value="<?php echo date("d-m-Y") ?>" placeholder="<?php echo date("Y-m-d") ?>">
							     	<span class="input-group-btn">
							        	<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
							      	</span>
							    </div>
							</form>
						</div>
						<div clasx="table-responsive">
							<table class="table table-condensed " style="font-size:13px">
								<thead>
									<th>C&oacute;digo</th>
									<th>Cliente</th>
									<th>Extintores</th>
									<th>Fecha de emisi&oacute;n</th>
									<th>Fecha de culminaci&oacute;n</th>
									<th>Fecha de entrega</th>
									<th>Estado</th>
									<th>Acci&oacute;n</th>
								</thead>
								<tbody id="recargar_notas">
									<!-- Dinamico -->
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
	<script>
		$(function(){
			$("#buscar_notas_03").trigger("submit");
		})
	</script>
</body>
</html>
