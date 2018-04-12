<?php 
require("seguridad.php"); 
?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body>

	<?php require("css/header.php") ?>

	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="text-center">Estadisticas gr&aacute;ficas de la cantidad de extintores.</h3>
				<br>
				<a href="grafico_01.php" class="btn btn-primary btn-lg space">Gr&aacute;ficas mensuales</a>
				<a href="grafico_02.php" class="btn btn-primary btn-lg space">Gr&aacute;ficas trimestrales</a>
				<a href="grafico_03.php" class="btn btn-primary btn-lg space">Gr&aacute;ficas anuales</a>
			</div>
			<div class="col-sm-12">
				<br>
				<h4>Leyenda de gr&aacute;ficos</h4>
				<?php
				$grafica = new MiClase();
				$grafica->get_ext_categoria_cantidad();

				$i=0;
				while($row=$grafica->array->fetch_array()){
					echo "<div class='ext_categoria tipo".$i."'>".$row['tipo']."</div>";
					$i++;
				}
				?>
			</div>
		</div>
	</div>

	<?php require("libs/jsLibs.php") ?>
</body>
</html>