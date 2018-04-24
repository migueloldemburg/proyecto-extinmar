<?php
	session_start();
	function __autoload($classname) {
	    $filename = "class/". $classname .".php";
	    include_once($filename);
	}
	
	// $_POST['id'] = 27;
	$nota = new Notas();
	$nota->obtener_nota_por_id($_POST['id']);

	$cliente = new Clientes();
	$cliente->obtener_cliente_by_id($nota->id_cliente);
?>

	<?php require("libs/cssLibs.php") ?>
	<style type="text/css" >
		body{ padding: 0; font-size: 12px;}
		input.form-control{background-color: white; padding: 3px 5px;height: 15px;border:none;}
		select.form-control{background-color: white; padding: 3px 5px;height: 23px;border:none;}
		textarea.form-control{background-color: white; padding: 3px 5px;height: 23px;border:none;}
		table.table td{ font-size: 10px; }
		.panel-heading{padding:5px;}
		h5,h6{padding:3px 10px;margin:3px;}
	</style>
<body>
	<header>
		<img class="imgReporte" src="images/bg3.jpg">
		<h5 class="text-center"><strong>EXTINMAR, C.A - Seguridad Industrial</strong></h5>
		<h5>VENTA DE EQUIPOS CONTRA INCENDIO - SISTEMAS CONTRA ROBO - ALARMAS CONTRA INCENDIO - LAMPARAS DE EMERGENCIA - RECARGA Y MANTENIMIENTO DE EXTINTORES.</h5>
		<h6>Permiso de SENCAMER No. 0866 - 02 / Permiso de Bomberos No. 00189-01</h6>
		<h6>RIF. J-30503969-0 / Permiso Fomento No. 626-90</h6>
		<h6>** Estos precios no incluyen repuestos. Ser&aacute;n facturados adicionalmente. ** La empresa no se hace responsable por equipos pasados 30 d&iacute;as</h6>
		<h6><?php echo "Generado el: ".date("d-m-Y h:m:d") ?></h6>
	</header>

	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h5 class="text-center">Nota de Servicio No. <?php echo $nota->id ?></h5>
				<!-- PANEL CLIENTE -->
				<div class="panel panel-info ">
					<div class="panel-heading">Datos del Cliente</div>
					<div class="panel-content">
						<div class="container-fluid">
							<div class="row">
								<form class="form-horizontal">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="control-label col-xs-4" style="display:block">C&eacute;dula / Rif</label>
											<div class="col-xs-8">
												<select class="form-control" style="display:inline-block; width:auto">
													<option value="v" <?php if($cliente->predocumento == 'v') echo 'selected;' ?>>V</option>
													<option value="j" <?php if($cliente->predocumento == 'v') echo 'selected;' ?>>J</option>
													<option value="e" <?php if($cliente->predocumento == 'e') echo 'selected;' ?>>E</option>
												</select>
												<input class="form-control" style="display:inline-block; width:auto" type="text" name="documento" placeholder="C&eacute;dula / Rif" onkeypress="return isNumber(event)" value="<?php echo filter_var($cliente->documento, FILTER_SANITIZE_NUMBER_INT) ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-xs-4">Nombre o Raz&oacute;n social</label>
											<div class="col-xs-8">
												<input type="text" class="form-control" name="nombre" placeholder="Nombre o Raz&oacute;n social" value="<?php echo $cliente->cliente ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-xs-4">Email</label>
											<div class="col-xs-8">
												<input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $cliente->email ?>">
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="control-label col-xs-4">Tel&eacute;fono 1</label>
											<div class="col-xs-8">
												<input type="text" class="form-control phone" name="telefono1" placeholder="(9999) 999-9999" 	value="<?php echo $cliente->telefono1 ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-xs-4">Direcci&oacute;n</label>
											<div class="col-xs-8">
												<textarea class="form-control" name="direccion" placeholder="Direcci&oacute;n"><?php echo $cliente->direccion ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-xs-4">Fecha</label>
											<div class="col-xs-8">
												<input type="text" class="form-control" name="telefono2" value="<?php echo $nota->fecha_registro ?>">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
		<?php
			$extintores = new Notas();
			if($extintores->obtener_extintores_nota($nota->id))
			{
				$nota = new Notas();
				$total=0;
				while($row=$extintores->array->fetch_assoc())
				{
				?>
					<div class="col-xs-4" style="font-size: 10px !important">
						<!-- PANEL EXTINTOR -->
						<div class="panel panel-default">
							<div class="panel-heading"><?php echo $row['categoria']." ".$row['capacidad']."lbs ".$row['servicio_general'] ?>
							</div>
							<div class="panel-content" style="padding-bottom: 0">
								<div class="container-fluid">
									<table class="table table-condensed" style="font-size: 10px !important">
										<tbody>
											<?php
											$servicios = new Notas();	
											if($servicios->obtener_servicios_nota($row['id']))
											{
												$nota = new Notas();
												while($row2=$servicios->array->fetch_assoc())
												{
													$total +=$row2['precio']; 
											?>
												<tr>
													<td style="padding:2px"><?php echo ucfirst(strtolower($row2['nombre'])) ?></td>
													<td style="padding:2px" class="text-right"><?php echo "Bs.F ".number_format($row2['precio'], 2, ',', '.') ?></td>													
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
		<div class="row">
			<div class='col-md-12'>
				<h4>Total: Bs.F <?php echo number_format($total, 2, ',', '.') ?></h4>
			</div>
		</div>
	</div>
	<div class="divBotton">Extinmar C.A. *Informe impreso por <?php echo $_SESSION['nombre_'] ?></div>
	<?php require("libs/jsLibs.php") ?>
	<script type="text/javascript">
		$(function(){
			window.print();
			window.close();
		})
	</script>
</body>
