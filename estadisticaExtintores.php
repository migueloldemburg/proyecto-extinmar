<?php require("seguridad.php"); ?>
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
				<a href="ver_estadistica.php?type=grafico1" class="btn btn-primary btn-lg space">Gr&aacute;ficas mensuales</a>
				<a href="ver_estadistica.php?type=grafico2" class="btn btn-primary btn-lg space">Gr&aacute;ficas trimestrales</a>
				<a href="ver_estadistica.php?type=grafico3" class="btn btn-primary btn-lg space">Gr&aacute;ficas anuales</a>
			</div>
			<div class="col-sm-12">
				<br>
				<h4>Leyenda de gr&aacute;ficos</h4>
				<?php
				$grafica = new MiClase();
				$grafica->obtener_categorias();

				$color0 = "#6c5ce7";
				$color1 = "#bdc3c7";
				$color2 = "#2ecc71";
				$color3 = "#3498db";
				$color4 = "#9b59b6";
				$color5 = "#34495e";
				$color6 = "#16a085";
				$color7 = "#27ae60";
				$color8 = "#2980b9";
				$color9 = "#e67e22";
				$color10 = "#e74c3c";
				$color11 = "#f1c40f";
				$color12 = "#d35400";
				$color13 = "#1abc9c";
				$color14 = "#7f8c8d";
				$i=0;
				while($row=$grafica->array->fetch_array()){
					echo "<div class='ext_categoria' style='background-color:".${"color".$i}."'>".$row['nombre']."</div>";
					$i++;
				}
				?>
			</div>
		</div>
	</div>
<?php require("css/footer.php") ?>
	<?php require("libs/jsLibs.php") ?>
</body>
</html>