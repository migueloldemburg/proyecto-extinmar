<?php
	session_start();
	function __autoload($classname) {
	    $filename = "class/". $classname .".php";
	    include_once($filename);
	}

?>
	<?php require("libs/cssLibs.php") ?>
<body style="background: none; background-color: #ffbbbb">

	<div class="container">

		<div class="row">
			<div class="col-sm-offset-3 col-sm-6">
				<h5 class="text-center headerReporte"><strong>EXTINMAR, C.A - Seguridad Industrial</strong></h5>
				<p>
					<a class="btn btn-primary pull-left" href="estadisticaExtintores.php">Volver</a>
					<a class="btn btn-warning pull-right" onclick="print_grafica('<?php echo (isset($_GET["type"]) ? $_GET["type"]:'')  ?>')" href="#">Imprimir</a>
				</p>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-12 text-center">
				<?php
					switch ( (isset($_GET["type"]) ? $_GET["type"]:'') ) {
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

	</div>
	<?php require("css/footer.php") ?>
	<?php require("libs/jsLibs.php") ?>
</body>
</html>