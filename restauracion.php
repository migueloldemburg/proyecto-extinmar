<?php
session_start();
//------------------------------------------------------------------------------------------
//  Definiciones

	require("class/Conexion.php");

    $archivo = trim($_GET['ficheroDeCopia'],'.gz');
	$filename = $archivo;//  Nombre del archivo.

//------------------------------------------------------------------------------------------
//  No tocar
	error_reporting(0);
	define( 'Str_VERS', "1.1.1" );
	//define( 'Str_DATE', "18 de Marzo de 2005" );
	define( 'Str_DATE', "19 de Noviembre de 2012" );
//------------------------------------------------------------------------------------------
?>
<?php 
	// Check to see if $PHP_AUTH_USER already contains info
	if (!isset($_SERVER['PHP_AUTH_USER'])) {
		// If empty, send header causing dialog box to appear
		header('WWW-Authenticate: Basic realm="Acceso al Restore la Base de Datos"');
		header('HTTP/1.0 401 Unauthorized');
    // Defines the charset to be used
    header('Content-Type: text/html; charset=iso-8859-1');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<HTML>
 <HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Acceso Denegado</title>
	<!-- no cache headers -->
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="no-cache">
	<meta http-equiv="Expires" content="-1">
	<meta http-equiv="Cache-Control" content="no-store">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Cache-Control" content="must-revalidate">
	<!-- end no cache headers --> 
 </HEAD>
<BODY 
	bgcolor="#D5D5D5" 
	text="#000000" 
	id="all" 
	leftmargin="25" 
	topmargin="25" 
	marginwidth="25" 
	marginheight="25" 
	link="#000020" 
	vlink="#000020" 
	alink="#000020">
	<!--<center><h1>Restore la Base de Datos</h1></center><br>
	<strong><center><p>Usuario/contraseña equivocado. Acceso denegado.</p></center>-->
<?php
		echo( "</strong><br><br><hr><center><small>" );
		setlocale( LC_TIME,"spanish" );
		echo strftime( "%A %d %B %Y&nbsp;-&nbsp;%H:%M:%S", time() );
		echo( "<br>&copy;2005 <a href=\"mailto:insidephp@gmail.com\">Inside PHP</a><br>" );
		echo( "vers." . Str_VERS . "<br>" );
		echo( "</small></center>" );
		echo( "</BODY>" );
		echo( "</HTML>" );
    exit();
	}
	else {
		if (($_SERVER['PHP_AUTH_USER'] != $auth_user ) || ($_SERVER['PHP_AUTH_PW'] != $auth_password )) {
			header('WWW-Authenticate: Basic realm="Acceso al Restore la Base de Datos"');
			header('HTTP/1.0 401 Unauthorized');
    	// Defines the charset to be used
    	header('Content-Type: text/html; charset=iso-8859-1');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<HTML>
 <HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Acceso Denegado</title>
	<!-- no cache headers -->
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="no-cache">
	<meta http-equiv="Expires" content="-1">
	<meta http-equiv="Cache-Control" content="no-store">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Cache-Control" content="must-revalidate">
	<!-- end no cache headers --> 
 </HEAD>
<BODY 
	bgcolor="#D5D5D5" 
	text="#000000" 
	id="all" 
	leftmargin="25" 
	topmargin="25" 
	marginwidth="25" 
	marginheight="25" 
	link="#000020" 
	vlink="#000020" 
	alink="#000020">
	<!--<center><h1>Restore la Base de Datos</h1></center><br>
	<strong><center><p>Usuario/contraseña equivocado. Acceso denegado.</p></center>-->
<?php
			echo( "</strong><br><br><hr><center><small>" );
			setlocale( LC_TIME,"spanish" );
			echo strftime( "%A %d %B %Y&nbsp;-&nbsp;%H:%M:%S", time() );
			echo( "<br>&copy;2005 <a href=\"mailto:insidephp@gmail.com\">Inside PHP</a><br>" );
			echo( "vers." . Str_VERS . "<br>" );
			echo( "</small></center>" );
			echo( "</BODY>" );
			echo( "</HTML>" );
    	exit();
		}
		else {
///////  El área protegida empieza DESPUÉS de la SIGUIENTE línea  /////
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<HTML>
 <HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Restore de la Base de Datos</title>
	<!-- no cache headers -->
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="no-cache">
	<meta http-equiv="Expires" content="-1">
	<meta http-equiv="Cache-Control" content="no-store">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Cache-Control" content="must-revalidate">
	<!-- end no cache headers --> 
 </HEAD>
<BODY 
	bgcolor="#fff" 
	text="#000000" 
	id="all" 
	leftmargin="25" 
	topmargin="25" 
	marginwidth="25" 
	marginheight="25" 
	link="#000020" 
	vlink="#000020" 
	alink="#000020">
	<!--<center><h1>Restore de la Base de Datos</h1></center><br>-->
	<strong>
<?php
$servername='localhost';//localhost 
$dbusername='root';//root 
$dbpassword='root1234';//tupass 
$dbname='db_extinmar';//tuclave

function connecttodb($servername,$dbname,$dbusername,$dbpassword) 
{ 
	$link=mysql_connect ($servername,$dbusername,$dbpassword); 
	if(!$link) 
	{ 
		die('No puedo Conectarme al Administrador MySQL'.mysql_error()); 
	}
		mysql_select_db($dbname,$link) or die ('No puedo seleccionar la base de datos'.mysql_error()); 
	}
	connecttodb($servername,$dbname,$dbusername,$dbpassword);
	
	$eliminar = mysql_query("DROP DATABASE proyectounimar1");
	if($eliminar)
	{
		/*echo '<script language="javascript">alert("Se ha eliminado la base de Datos");</script>';*/
		$crear = mysql_query("CREATE DATABASE proyectounimar1");
		if($crear)
		{
			/*echo '<script language="javascript">alert("Se ha eliminado la base de Dato y se ha creado una nueva");</script>';*/
		}
		
	}else{
		/*echo '<script language="javascript">alert("No se Elimino la base de datos");</script>';*/
	}




	@set_time_limit( 0 );

	//echo( "* Base de Datos: '$db_name' en '$db_server'.<br>" );
	$error = false;

	if ( !@function_exists( 'gzopen' ) ) {
		$hay_Zlib = false;
		echo( "- Ya que no está disponible Zlib, usaré el BackUp de la Base de Datos: '$filename'<br>" );
	}
	else {
		$hay_Zlib = true;
		$filename = $filename . ".gz";
		//echo( "- Ya que está disponible Zlib, usaré el BackUp de la Base de Datos: '$filename'<br>" );//ojo imp
	}

	if( !$file = @fopen( $filename,"r" ) ) { 
	    echo ("<br>- Lo siento, no encuentro o no puedo abrir: '$filename'.<br>");
	    $error = true;
	}
	else { 
	    if( fseek($file, 0, SEEK_END)==0 )
	        $filesize_comprimido = ftell( $file );
	    else { 
	       echo ("<br>- Lo siento, no puedo obtener las dimensiones de '$filename'.<br>");
	       $error = true;
	    }
	 	  fclose( $file );
	}

	if ( !$error ) {
		if( $hay_Zlib ) {
			if ( !$file = @gzopen( $filename, "rb" ) ) { 
				echo( "<br>- Lo siento, no encuentro o no puedo abrir: '$filename'.<br>" );
				$error = true;
			}
			else {
				gzrewind( $file );
			}
		}
		else {
			if ( !$file = @fopen( $filename, "rb" ) ) { 
				echo( "<br>- Lo siento, no encuentro o no puedo abrir: '$filename'.<br>" );
				$error = true;
			}
			else {
				rewind( $file );
			}
		}
	}

	if (!$error) { 
	    $dbconnection = @mysql_connect( $db_server, $db_username, $db_password ); 
	    if ($dbconnection) 
	        $db = mysql_select_db( $db_name );
	    if ( !$dbconnection || !$db ) { 
	        echo( "<br>" );
	        echo( "- Lo siento, la conexion con la Base de datos ha fallado: ".mysql_error()."<br>" );
	        $error = true;
	    }
	    else {
	        //echo( "<br>" );
	        //echo( "* He establecido conexion con la Base de datos.<br>" );
	    }
	}

	if (!$error) { 
		$sql = "SHOW TABLES FROM ".$db_name;
		$result = mysql_query($sql);
	    //$result = mysql_list_tables( $db_name );
			if (!$result) {
					print "<br>- Error, no puedo obtener la lista de las tablas.<br>";
					print '<br>- MySQL Error: ' . mysql_error(). '<br>';
					$error = true;
			}
			else {
					// $count es el número de tablas en la base de datos
					$count = mysql_num_rows($result);
					if( !$count ) {
							//echo "- No ha sido necesario borrar la estructura de la Base de datos, estaba vacía.<br>";
					}
					else {
							while ($row = mysql_fetch_row($result)) {
									$deleteIt = mysql_query("DROP TABLE $row[0]");
									if( !$deleteIt ) {
	        						echo( "<br>" );
											print "* Lo siento, error al borrar la tabla $row[0].<br>";
											$error = true;
											break;
									}
							}
							//echo "* He borrado la estructura de la Base de Datos.<br>";
					}
					mysql_free_result($result);
			}
	}

	if( !$error ) { 
	    $query = "";
	    $last_query = "";
	    $total_queries = 0;
	    $total_lineas = 0;
	
			$t_start = time();

			while( 1 )
			{
				if( $hay_Zlib )
					$seacabo = gzeof( $file ) OR $error;
				else
					$seacabo = feof( $file ) OR $error;
				if( $seacabo )
					break;
				if( $hay_Zlib )
					$statement = gzgets( $file );
				else

					$statement = fgets( $file );
					
		        $statement = trim( $statement );
		        $total_lineas++;
		        // no se procesan comentarios ni lineas en blanco
		        if ( $statement=="--" || $statement=="" || strpos ($statement, "#") === 0) { 
		            continue;
		        }
		        // pasa a query
		        $query .= $statement;
		        // ejecuta query si esta completo
		        if( preg_match( "/;$/", $statement ) ) { 
		            if ( !mysql_query( $query, $dbconnection) ) { 
		                echo(" <br>" );
		                echo("- Error en statement: $statement<br>" );
		                echo("- Query: $query<br>");
		                echo("- MySQL: ".mysql_error()."<br>" );
		                $error = true;
		                break;
		            }
		            $last_query = $query;
		            $query = "";
		            $total_queries++;
		        }
		    }

			if( $hay_Zlib )
				$file_offset = gztell($file);
	    else
	    	$file_offset = ftell($file);
	
	    //echo( "<pre>" );
	    //echo( "- Líneas procesadas......................... $total_lineas<br>" );
	    //echo( "- Queries procesadas........................ $total_queries<br>" );
	    //echo( "- Último Query procesado.................... '$last_query'<br>" );
			if( $hay_Zlib ) {
	    	//echo( "- Base de Datos comprimida.................. $filesize_comprimido bytes<br>");
	    	//echo( "- Base de Datos descomprimida y procesada... $file_offset bytes<br>" );
	  	}
	  	else {
	    	echo( "- Base de Datos procesada................... $file_offset bytes<br>" );
	  	}
	    echo( "</pre>" );
			$t_now = time();
			$t_delta = $t_now - $t_start;
			if( !$t_delta )
				$t_delta = 1;
			$t_delta = floor(($t_delta-(floor($t_delta/3600)*3600))/60)." minutos y "
			.floor($t_delta-(floor($t_delta/60))*60)." segundos.";
			//echo( "- He completado el Restore de la Base de Datos en $t_delta<br>" );
			
			echo '<script language="javascript">alert("La restauraci\u00F3n est\u00E1 completa");</script>';
			echo '<script type="text/javascript">location.href="principal.php";</script>';
	}

	if ( $dbconnection )
	    mysql_close();
	if ( $file )
		if( $hay_Zlib )
			gzclose($file);
	   else
	    fclose($file);

	/*echo( "</strong><br><br><hr><center><small>" );
	setlocale( LC_TIME,"spanish" );
	echo strftime( "%A %d %B %Y&nbsp;-&nbsp;%H:%M:%S", time() );
	echo( "<br>&copy;2005 <a href=\"mailto:insidephp@gmail.com\">Inside PHP</a><br>" );
	echo( "vers." . Str_VERS . "<br>" );
	echo( "</small></center>" );*/
	echo( "</BODY>" );
	echo( "</HTML>" );
	echo '<script type="text/javascript">location.href="principal.php";</script>';
//------------------------------------------------------------------------------------------
//  END
?>


<?php
///////  El área protegida acaba ANTES de la ANTERIOR línea  /////
		}
	}
?>
<script src="js/funciones.js" ></script>