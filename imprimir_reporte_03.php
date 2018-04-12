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
					<div class="panel-heading"><?php echo "Notas de servicio por estado por rango de fecha desde: ".$_POST['from']." hasta: ".$_POST['to'] ?></div>
					<div class="panel-content">
						<div clasx="table-responsive">
							<table class="table table-condensed " style="font-size:13px">
								<thead>
									<th>N&uacute;mero</th>
									<th>Cliente</th>
									<th>Extintores</th>
									<th>Fecha</th>
									<th>Estado</th>
								</thead>
								<tbody id="recargar_tabla">
								<?php
								$notas = new Notas();
								if( empty($_POST['id_nota']) ){
									if($notas->obtener_notas_por_estado($_POST['estado'], $_POST['from'], $_POST['to']))
									{
										$nota = new Notas();
										while($row=$notas->array->fetch_assoc())
										{
											echo "<tr data-toggle='tooltip' data-placement='top' title='".$row['observacion']."'>";
											echo "<td>".$row['id']."</td>";
											echo "<td>".$row['cliente']."</td>";
											echo "<td>".$nota->obtener_num_extintores($row['id'])."</td>";
											echo "<td>".date("d-m-Y", strtotime($row['fecha_registro']))."</td>";
											switch ($row['estado']) {
												case '0': echo "<td><span class='label label-info'>Emitida</span></td>"; break;
												case '1': echo "<td><span class='label label-primary'>En Taller</span></td>"; break;
												case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
												case '3': echo "<td><span class='label label-success'>Despachado</span></td>"; break;
												case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
											}
											echo "</tr>";
										}
									}else{
										echo "<tr><td colspan='5'><em>No hay notas para la fecha seleccionada</em></td></tr>";
									}
								}else{
									if($notas->obtener_nota_por_id($_POST['id_nota']))
									{
										echo "<tr data-toggle='tooltip' data-placement='top' title='".$notas->observacion."'>";
										echo "<td>".$notas->id."</td>";
										echo "<td>".$notas->cliente."</td>";
										echo "<td>".$notas->obtener_num_extintores($notas->id)."</td>";
										if($notas->fecha_registro==''){
												echo "<td></td>";
											}else{
												echo "<td>".date("d-m-Y", strtotime($row['fecha_entrega']))."</td>";
											}
										switch ($notas->estado) {
											case '0': echo "<td><span class='label label-info'>Emitida</span></td>"; break;
											case '1': echo "<td><span class='label label-primary'>En Taller</span></td>"; break;
											case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
											case '3': echo "<td><span class='label label-success'>Despachado</span></td>"; break;
											case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
										}
										echo "</tr>";
									}else{
										echo "<tr><td colspan='5'><em>El n&uacute;mero de nota de servicio no se encuentra.</em></td></tr>";
									}
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