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
</head>
<body>

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-6 login-side left">
				<p class="title-01">EXTINMAR C.A.</p>
				<img src="images/bg3.jpg">
			</div>
			<div class="col-xs-offset-6 col-xs-6 login-side right">
				<h2>Inicio de sesi&oacute;n</h2>
				<form action="" method="post">
					<div class="form-group">
						<input type="text" name="usuario" class="form-control" required="" placeholder="Nombre de usuario" autofocus="" value="<?php echo $usuario ?>">
					</div>
					<div class="form-group">
						<input type="password" name="clave" class="form-control" required="" placeholder="Contrase&ntilde;a">
						<a href="recuperarClave.php" class="pull-right">Olvid&eacute; contrase&ntilde;a</a>
					</div>
					<br>
					<br>
			        <?php
			        	if($tieneError){
			        		echo $alert;
			        	}
			        ?>
					<button class="btn btn-block btn-primary" type="submit" name="entrar">Entrar al sistema</button>
				</form>
			</div>
		</div>
	</div>

	<?php require("libs/jsLibs.php") ?>
</body>
</html>