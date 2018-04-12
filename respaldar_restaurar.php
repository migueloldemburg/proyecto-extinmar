<?php require("seguridad.php") ?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body>
	<?php require("css/header.php") ?>

	<div class="container">
		<div class="row">
			<div class="col-sm-offset-3 col-sm-6" id="container_respaldo">
				<div class="panel panel-primary">
					<div class="panel-heading text-center">
						Respaldo y Restauraci&oacute;n de Base de Datos
					</div>
					<div class="panel-content text-center">
						<form id="form1" name="form1" method="post" action="">
							<br>
							<img src="images/backup.png" style="width:90px; height:auto; margin-left: 25px">
							<div class="form-group">
						    	<button onclick="respaldarr()" type="button" class="btn btn-primary">Respaldar Base de Datos</button>
						    </div>
						    <div class="form-group">
						    	<button onclick="restaurarr()" type="button" class="btn btn-primary">Restaurar Base de Datos</button>
						    </div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php require("css/footer.php") ?>
	<?php require("libs/jsLibs.php") ?>
</body>
</html>