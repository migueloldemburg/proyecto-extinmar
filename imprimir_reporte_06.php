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
	</style>
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
					<div class="panel-heading"><?php echo "Servicios realizados a extintor #".$_POST['id_ext'] ?></div>
					<div class="panel-content">
						<div clasx="table-responsive">
							<table class="table table-condensed table-striped" style="font-size:13px">
								<thead>
									<th>Servicio</th>
									<th>Estado</th>
								</thead>
								<tbody id="recargar_tabla">
								<?php
								$notas = new Notas();	
								if($notas->obtener_servicios_nota($_POST['id_ext']))
								{
									$nota = new Notas();
									while($row=$notas->array->fetch_assoc())
									{
										echo "<tr>";
											echo "<td>".$row['nombre']."</td>";
											switch ($row['estado']) {
												case '0': echo "<td><span class='label label-info'>En Espera</span></td>"; break;
												case '1': echo "<td><span class='label label-primary'>En proceso</span></td>"; break;
												case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
												case '3': echo "<td><span class='label label-success'>Retirado</span></td>"; break;
												case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
											}
											echo "<td>";
										echo "</tr>";
									}
								}else{
									echo "<tr><td colspan='3'><em>Parece que no hay servicios agregados.</em></td></tr>";
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