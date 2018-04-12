<?php

switch ($_POST['accion']) {
	case 'imprimir_nota':
		include("impresion_nota.php");
	break;
	case 'imprimir_reporte_01':
		include("imprimir_reporte_01.php");
	break;
	case 'imprimir_reporte_02':
		include("imprimir_reporte_02.php");
	break;
	case 'imprimir_reporte_03':
		include("imprimir_reporte_03.php");
	break;
	case 'imprimir_reporte_04':
		include("imprimir_reporte_04.php");
	break;
	case 'imprimir_reporte_05':
		include("imprimir_reporte_05.php");
	break;
	case 'imprimir_reporte_06':
		include("imprimir_reporte_06.php");
	break;
	default:
		# code...
	break;
}

?>