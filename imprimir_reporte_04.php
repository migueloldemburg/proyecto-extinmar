<?php
	session_start();
	function __autoload($classname) {
	    $filename = "class/". $classname .".php";
	    include_once($filename);
	}

?>
	<?php require("libs/cssLibs.php") ?>
	<style type="text/css" media="print">
		body{ padding: 20px; font-size: 13px;}
		@page{ margin: 12px; }
	</style>
<body>

	<header>
		<img class="imgReporte" src="images/bg3.jpg">
		<h5 class="text-center"><strong>EXTINMAR, C.A - Seguridad Industrial</strong></h5>
		<h5>VENTA DE EQUIPOS CONTRA INCENDIO - SISTEMAS CONTRA ROBO - ALARMAS CONTRA INCENDIO - LAMPARAS DE EMERGENCIA - RECARGA Y MANTENIMIENTO DE EXTINTORES.</h5>
		<h6>Permiso de SENCAMER No. 0866 - 02 / Permiso de Bomberos No. 00189-01</h6>
		<h6>RIF. J-30503969-0 / Permiso Fomento No. 626-90</h6>
		<h6><?php echo "Generado el: ".date("d-m-Y h:m:d") ?></h6>
	</header>

	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<!-- PANEL DE BUSQUEDA -->
				<div class="panel panel-primary">
					<div class="panel-heading"><?php echo "Cantidad de qu&iacute;micos en alamac&eacute;n por categoria" ?></div>
					<div class="panel-content">
						<div clasx="table-responsive">
							<table class="table table-condensed table-striped" style="font-size:13px">
								<thead>
									<th>C&oacute;digo</th>
									<th>Categor&iacute;a</th>
									<th>Nombre</th>
									<th>Cantidad</th>
									<th>Ubicacion</th>
								</thead>
								<tbody id="recargar_tabla">
								<?php
								$ser_categoria = new MiClase();
								if($ser_categoria->obtener_quimicos_por_categoria($_POST['id_ext_categoria'])){
									while($row=$ser_categoria->array->fetch_assoc()){
										echo "<tr>";
										echo "<td>".$row['id']."</td>";
										echo "<td>".$row['ext_categoria']."</td>";
										echo "<td>".$row['nombre']."</td>";
										echo "<td>".$row['cantidad']."</td>";
										echo "<td>".$row['departamento']." ".$row['pasillo']."</td>";
										echo "</tr>";
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
	</div>

	<?php require("libs/jsLibs.php") ?>
	<div class="divBotton">Extinmar C.A. *Informe impreso por <?php echo $_SESSION['nombre_'] ?></div>
</body>
</html>