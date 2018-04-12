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
			<div class="col-sm-12">
				<h3 class="text-center">Qu&iacute;micos por debajo de la cantidad m&iacute;nima</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-danger">
					<div class="panel-heading">Qu&iacute;micos</div>
					<div class="panel-content">
						<br>
						<form class="form-inline">
							<div class="input-group" style="padding:5px 10px">
								<input type="text" id="searcher_01" class="form-control" placeholder="Buscar">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
								</span>
							</div>
							<button class="btn btn-warning" type="button" onclick="imprimir_reporte_05()">Imprimir</button>
						</form>
						<br>
						<table class="table table-condensed table-hover">
							<thead>
								<th>C&oacute;digo</th>
								<th>Nombre</th>
								<th>Precio</th>
								<th>Cantidad</th>
								<th>Ubicaci&oacute;n</th>
							</thead>
							<tbody>
							<?php
								$ser_categoria = new MiClase();
								if($ser_categoria->obtener_servicios('quimico')){
									while($row=$ser_categoria->array->fetch_assoc()){
										if(filter_var($row['cantidad'], FILTER_SANITIZE_NUMBER_INT) < 10){
											echo "<tr>";
											echo "<td>".$row['id']."</td>";
											echo "<td>".$row['nombre']."</td>";
											echo "<td>Bs.F ".number_format($row['precio'], 2, ',', '.')."</td>";
											echo "<td style='color:red;font-weight:bold'>".$row['cantidad']."</td>";
											echo "<td>".$row['departamento']." - ".$row['pasillo']."</td>";
											echo "</tr>";
										}
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