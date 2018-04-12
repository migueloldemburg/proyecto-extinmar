<?php
session_start();

if(isset($_SESSION['id_'])){
	header('Location:inicio.php');
    exit;
}

$tieneError = false;
if(isset($_POST['usuario'])){
	$usuario = $_POST['usuario'];
}else{
	$usuario = '';
}
if(isset($_POST['entrar'])){
	require("class/Usuarios.php");
	$usuario1 = new Usuarios();
	if($usuario1->autenticar_usuario($_POST['usuario'], $_POST['clave'])){
		echo "entra";
		if($usuario1->estado == 1){
			$_SESSION['id_'] = $usuario1->id;
			$_SESSION['usuario_'] = $usuario1->usuario;
			$_SESSION['nivel_'] = strtolower($usuario1->nivel);
			$_SESSION['nombre_'] = $usuario1->nombre." ".$usuario1->apellido;
			header('Location:inicio.php');
        	exit;
		}elseif($usuario1->estado == 0){
			$tieneError = true;
			$alert = '<div class="alert alert-warning">Usuario suspendido.</div>';
		}elseif($usuario1->estado == 2){
			$tieneError = true;
			$alert = '<div class="alert alert-danger">Clave y/o usuario inv&aacute;lido.</div>';
		}
	}else{
		$tieneError = true;
		$alert = '<div class="alert alert-danger">Clave y/o usuario inv&aacute;lido.</div>';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
	<style type="text/css">
		.alert{
			margin-bottom: 0 !important;
    		padding: 7px !important;
		}
	</style>
</head>
<body style="padding-top:0px; background:none !important">

	<div class="container-fluid">
		<div class="row" style="background-color: #080825">
			<div class="col-xs-12 col-md-offset-4 col-md-4 newDesign">
				<div class="col-xs-12 col-md-offset-1 col-md-10">
					<h2 class="text-center">Inicio de sesi&oacute;n</h2>
					<form action="" method="post">
						<div class="form-group">
							<input type="text" name="usuario" class="form-control" required="" placeholder="Nombre de usuario" autofocus="" value="<?php echo $usuario ?>">
						</div>
						<div class="form-group">
							<input type="password" name="clave" class="form-control" required="" placeholder="Contrase&ntilde;a">
							<a href="recuperarClave.php" class="pull-right">Olvid&eacute; contrase&ntilde;a</a>
						</div>
						<br>
				        <?php
				        	if($tieneError){
				        		echo $alert;
				        	}
				        ?>
				        <div class="form-group">
							<button class="btn btn-block btn-primary" type="submit" name="entrar">Entrar al sistema</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-offset-4 col-md-4">
				<h3 class="text-center">EXTINMAR C.A.</h3>
				<img style="width:100%" src="images/bg3.jpg">
			</div>
		</div>
	</div>

	<?php require("css/footer.php") ?>

	<?php require("libs/jsLibs.php") ?>
</body>
</html>