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
			<div class="col-md-12" id="container_respaldo">
				<form id="form1" name="form1" method="post" action="">
				    <table width="200" border="0" align="center">
				        <tr>
				            <td>
				            <button onclick="respaldarr()" type="button" class="btn btn-primary">Respaldar Base de Datos</button>
				            </td>
				        </tr>
				        <tr>
				            <td>&nbsp;</td>
				        </tr>
				        <tr>
				            <td><button onclick="restaurarr()" type="button" class="btn btn-primary">Restaurar Base de Datos</button></td>
				        </tr>
				    </table>
				</form>
			</div>
		</div>
	</div>

	<?php require("libs/jsLibs.php") ?>
</body>
</html>