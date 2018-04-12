<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body>

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-6 login-side left">
				<p class="title-01">EXTINMAR C.A.</p>
				<img src="images/bg3.jpg">
			</div>
			<div class="col-xs-offset-6 col-xs-6 login-side right">
				<h5 class="text-center">Indique su correo electr&oacute;nico registrado en nuestra plataforma para el env&iacute;o de sus datos de usuario:</h5>
				<form id="restaurarClave" class="form-inline">
					<input type="hidden" name="accion" value="recuperar_clave">
					<div class="form-group">
						<input type="email" class="form-control" placeholder="Email" name="email" required>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-default">Enviar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php require("libs/jsLibs.php") ?>
</body>
</html>