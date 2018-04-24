<?php
	session_start();
	date_default_timezone_set('America/Caracas');
	function __autoload($classname) {
	    $filename = "class/". $classname .".php";
	    include_once($filename);
	}

?>
	<?php require("libs/cssLibs.php") ?>
	<style type="text/css" media="print">
		body{ padding: 20px; font-size: 13px;}
	</style>
<body style="background: none">

	<div class="container">

		<div class="row">
			<div class="col-sm-12">
				<img class="imgReporte" src="images/bg3.jpg">
				<h5 class="text-center headerReporte"><strong>EXTINMAR, C.A - Seguridad Industrial</strong></h5>
				<h5>VENTA DE EQUIPOS CONTRA INCENDIO - SISTEMAS CONTRA ROBO - ALARMAS CONTRA INCENDIO - LAMPARAS DE EMERGENCIA - RECARGA Y MANTENIMIENTO DE EXTINTORES.</h5>
				<h6>Permiso de SENCAMER No. 0866 - 02 / Permiso de Bomberos No. 00189-01</h6>
				<h6>RIF. J-30503969-0 / Permiso Fomento No. 626-90</h6>
				<h6><?php echo "Generado el: ".date("d-m-Y h:i:s A", time()) ?></h6>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-12 text-center">
				<?php
					switch ( (isset($_POST["type"]) ? $_POST["type"]:'') ) {
						case 'grafico1':
							echo '<img src="grafico_01.php">';
						break;
						case 'grafico2':
							echo '<img src="grafico_02.php">';
						break;
						case 'grafico3':
							echo '<img src="grafico_03.php">';
						break;						
						default:
							echo '<h3>No se reconoce.</h3>';
						break;
					}
				?>
			</div>
		</div>
		<hr>
		<div class="row" style="bottom:0px;position:absolute;right:0;left:0">
			<div class="col-sm-12 text-center">
				<div class="divBotton">Extinmar C.A. *Informe impreso por <?php echo $_SESSION['nombre_'] ?></div>
			</div>
		</div>
	</div>

	<?php require("libs/jsLibs.php") ?>
	<script type="text/javascript">
		$(function(){
			setTimeout(function(){
				window.print();
				window.close();
			}, '1000')
		})
	</script>
</body>
</html>