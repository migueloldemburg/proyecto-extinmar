<?php
require("seguridad.php");

	$nota = new Notas();
	$nota->obtener_nota_por_id($_GET['id_nota']);

	$cliente = new Clientes();
	$cliente->obtener_cliente_by_id($nota->id_cliente);

	if($nota->estado != 2 && $nota->estado != 3 && $nota->estado != 4 ){

		// DESCONTAR DE ALMACEN
		$extintores = new Notas();
		if($extintores->obtener_extintores_nota($_GET['id_nota']))
		{
			$servicios = new Notas();
			while($row=$extintores->array->fetch_assoc())
			{
				if($servicios->obtener_servicios_nota($row['id']))
				{
					$servicio = new MiClase();
					while($row2=$servicios->array->fetch_assoc())
					{
						$servicio->restar_de_almacen($row2['id_servicio'], $row2['cantidad']);
					}
				}
			}
		}
	}

	$procesar = $nota->cambiar_estado_nota($_GET['id_nota'], 2);
	$nota->set_fecha_culminacion();
	$sent = $nota->enviar_notificacion_cliente($cliente->cliente, $cliente->email, $nota->id);
?>
<!DOCTYPE html>
<html>
<head>
	<?php require("libs/cssLibs.php") ?>
</head>
<body>
	<?php require("css/header.php") ?>

	<div class="container">
		<div class="row">
			<div class="col-sm-offset-3 col-sm-6">
				<div class="alert alert-success text-center">
					<h3 class="text-center">Nota de Orden # <?php echo $_GET['id_nota'] ?> procesada exitosamente.</h3>
					<?php if($sent){ ?>
						<h4 class="text-center">Notificaci&oacute;n enviada al cliente. <button class="btn btn-xs btn-default" onclick="location.href='enviarNotificacionCliente.php?id_nota=<?php echo $_GET['id_nota'] ?>'">Reenviar notificaci&oacute;n</button> </h4>
					<?php }else{ ?>
						<h4 class="text-center">No fue posible el env&iacute;o de notificaci&oacute;n al cliente. <button class="btn btn-xs btn-default" onclick="location.href='enviarNotificacionCliente.php?id_nota=<?php echo $_GET['id_nota'] ?>'">Reenviar notificaci&oacute;n</button> </h4>
					<?php } ?>
					<a href="ordenesEnTaller.php" class="btn btn-xs btn-success">Volver a notas En Taller</a href="ordenesEnTaller.php"> 
				</div>
			</div>
		</div>
	</div>

	<?php require("libs/jsLibs.php") ?>
</body>
</html>