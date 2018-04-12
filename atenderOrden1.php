<?php require("seguridad.php") ?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body>
	<?php require("css/header.php") ?>

	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<h3>Ordenes por atender</h3>
				<!-- PANEL DE BUSQUEDA -->
				<div class="panel panel-warning">
					<div class="panel-heading">Buscar Nota</div>
					<div class="panel-content">
						<div class="well">
							<form class="form-inline" id="buscar_notas_02">
								<input type="hidden" name="accion" value="buscar_notas_02">
								<input type="hidden" name="estado" value="0">
								<input type="text" class="form-control" name="id_nota" placeholder="C&oacute;digo" style="width:100px">
								<!-- <select class="form-control" name="estado">
							    	<option value="0">Emitidas</option>
							    	<option value="1">En Taller</option>
							    	<option value="2">Listas</option>
							    	<option value="3">Retiradas</option>
							    	<option value="4">Canceladas</option>
							    </select> -->
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
									<th>N&uacute;mero</th>
									<th>Cliente</th>
									<th>Extintores</th>
									<th>Fecha</th>
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
			$("#buscar_notas_02").trigger("submit");
		})
	</script>
</body>
</html>
