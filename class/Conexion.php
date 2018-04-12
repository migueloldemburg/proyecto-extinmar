<?php
	$db_server			= "localhost"; 
	$db_username		= "root"; 
	$db_password		= "";
	$db_name			= "db_extinmar"; 

	//  Acceso al script para restaurar y respaldar BD
	$auth_user		= "root";
	$auth_password 	= "";

	// Credenciales de envio de correo
	$username = "marianamarval24@gmail.com";
    $password = "mariangel19";

	$conexion = new mysqli($db_server, $db_username, $db_password, $db_name);

	$conexion->set_charset("utf8");
	date_default_timezone_set('America/Caracas');
	if($conexion->connect_error) {
	   die("Connection failed: ".$conexion->connect_error);
	}else{
	    //echo "<script>alertify.success('conectado')</script>";
	} 
?>