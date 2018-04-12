<?php
	session_start();
	date_default_timezone_set('America/Caracas');
	
	if(!isset($_SESSION['id_'])){
		header("Location:login.php");
	}
	function __autoload($classname) {
	    $filename = "class/". $classname .".php";
	    include_once($filename);
	}
?>