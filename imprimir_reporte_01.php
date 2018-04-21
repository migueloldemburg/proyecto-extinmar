<?php
	session_start();
	function __autoload($classname) {
	    $filename = "class/". $classname .".php";
	    include_once($filename);
	}

?>
	<?php require("libs/cssLibs.php") ?>
	
<body>

	<header>
		<img class="imgReporte" src="images/bg3.jpg">
		<h5 class="text-center headerReporte"><strong>EXTINMAR, C.A - Seguridad Industrial</strong></h5>
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
					<div class="panel-heading"><?php echo "Extintores en almac&eacute;n por rango de fecha desde: ".$_POST['from']." hasta: ".$_POST['to'] ?></div>
					<div class="panel-content">
						<div clasx="table-responsive">
							<table class="table table-condensed " style="font-size:13px">
								<thead>
									<th>C&oacute;digo</th>
									<th>Tipo</th>
									<th>Capacidad</th>
									<th>Servicio</th>
									<th>Fecha Registro</th>
									<th>Estado</th>
								</thead>
								<tbody id="recargar_tabla">
								<?php
								$extintores = new MiClase();
								if($extintores->obtener_extintor_almacen($_POST['from'], $_POST['to'], $_POST['id_ubicacion']))
								{
									while($row=$extintores->array->fetch_assoc())
									{
										echo "<tr data-toggle='tooltip' data-placement='top' title='".$row['observacion']."'>";
											echo "<td>".$row['id']."</td>";
											echo "<td>".$row['categoria']."</td>";
											echo "<td>".$row['capacidad']."lbs</td>";
											echo "<td>".$row['servicio']."</td>";
											echo "<td>".date("d-m-Y", strtotime($row['fecha_registro']))."</td>";
											switch ($row['estadoExtintor']) {
												case '0': echo "<td><span class='label label-info'>En Espera</span></td>"; break;
												case '1': echo "<td><span class='label label-primary'>En Taller</span></td>"; break;
												case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
												case '3': echo "<td><span class='label label-success'>Despachado</span></td>"; break;
												case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
											}
										echo "</tr>";
									}
								}else{
									echo "<tr><td colspan='5'><em>No hay extintores en almacén en fecha seleccionada</em></td></tr>";
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

	<div class="divBotton">Extinmar C.A. *Informe impreso por <?php echo $_SESSION['nombre_'] ?></div>
	<?php
		if($_POST['guardaPdf']== 'false'){
	?>
		<?php require("libs/jsLibs.php") ?>
		
		<script type="text/javascript">
			$(function(){
				window.print();
				window.close();
			})
		</script>
	<?php
		}
	?>
</body>
</html>