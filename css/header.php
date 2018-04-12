<nav class="navbar navbar-inverse navbar-fixed-top taqHeader" style="background:none;background-color:#e80000;color:#fff">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header navbar-right">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">EXTINMAR C.A.</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-list-alt"></span> Ordenes <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<?php
						if($_SESSION['nivel_']=='administrador'){
							echo '<li><a class="menuSub" href="nuevaNota.php">Nueva Nota de Servicio</a></li>';
							echo '<li><a class="menuSub" href="buscarNotas.php">Buscar Nota de Servicio</a></li>';
							echo '<li><a class="menuSub" href="notasListas.php">Ordenes Listas</a></li>';
							echo '<li role="separator" class="divider"></li>';
							echo '<li><a class="menuSub" href="atenderOrden1.php">Atender Orden</a></li>';
							echo '<li><a class="menuSub" href="ordenesEnTaller.php">Ordenes en Taller</a></li>';
						}
						if($_SESSION['nivel_']=='secretaria'){
							echo '<li><a class="menuSub" href="nuevaNota.php">Nueva Nota de Servicio</a></li>';
							echo '<li><a class="menuSub" href="buscarNotas.php">Buscar Nota de Servicio</a></li>';
							echo '<li><a class="menuSub" href="notasListas.php">Ordenes Listas</a></li>';
						}
						if($_SESSION['nivel_']=='recargador'){
							echo '<li><a class="menuSub" href="buscarNotas.php">Buscar Nota de Servicio</a></li>';
							echo '<li><a class="menuSub" href="notasListas.php">Ordenes Listas</a></li>';
							echo '<li><a class="menuSub" href="atenderOrden1.php">Atender Orden</a></li>';
							echo '<li><a class="menuSub" href="ordenesEnTaller.php">Ordenes en Taller</a></li>';
						}
						?>
					</ul>
				</li>

				<?php
				if($_SESSION['nivel_']!='recargador'){
				?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-folder-open"></span> Configurar <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<?php
						if($_SESSION['nivel_']=='administrador'){
							echo '<li><a href="moduloUsuarios.php">Usuarios</a></li>';
							echo '<li><a href="moduloClientes.php">Clientes</a></li>';
							echo '<li><a href="moduloExtintores.php">Extintores</a></li>';
							echo '<li><a href="moduloDepartamentos.php">Departamentos</a></li>';
							echo '<li><a href="moduloServiciosGenerales.php">Servicios Generales</a></li>';
						}
						if($_SESSION['nivel_']=='secretaria'){
							echo '<li><a href="moduloClientes.php">Clientes</a></li>';
						}
						if($_SESSION['nivel_']=='recargador'){

						}
						?>
					</ul>
				</li>
				<?php 
				}
				
				if($_SESSION['nivel_']=='administrador'){
				?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-folder-open"></span> Detalles de Servicios <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<?php
						if($_SESSION['nivel_']=='administrador'){
							echo '<li><a href="moduloServicios.php">Servicios Detalles</a></li>';
							echo '<li><a href="asociarServiciosGrupos.php">Asociar Servicios a Grupos</a></li>';
							echo '<li><a href="repuestos.php">Repuestos</a></li>';
							echo '<li><a href="quimicos.php">Qu&iacute;micos</a></li>';
							echo '<li><a href="administrarQuimicos.php">Administrar Qu&iacute;micos en Almac&eacute;n</a></li>';
							echo '<li><a href="administrarRepuestos.php">Administrar Repuestos en Almac&eacute;n</a></li>';
						}
						if($_SESSION['nivel_']=='secretaria'){
							
						}
						if($_SESSION['nivel_']=='recargador'){

						}
						?>
					</ul>
				</li>
				<?php 
				}
				?>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						Ver
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="verExtintorEnAlmacen.php"><span class="glyphicon glyphicon-indent-left"></span> Extintores en Almac&eacute;n por Fecha</a></li>
						<li><a href="extintoresAlmacenTipo.php"><span class="glyphicon glyphicon-indent-left"></span> Extintores en Almac&eacute;n  Categoria</a></li>
						<li><a href="buscarNotasEstado.php"><span class="glyphicon glyphicon-indent-left"></span> Nota por Estado</a></li>
						<li><a href="cantidadQuimicoCategoria.php"><span class="glyphicon glyphicon-indent-left"></span> Cantidad de Qu&iacute;mico por Categoria </a></li>
						<li><a href="estadisticaExtintores.php"><span class="glyphicon glyphicon-indent-left"></span> Estad&iacute;sticas de extintores M/T/A </a></li>
						<li><a href="quimicosBajosAlamacen.php"><span class="glyphicon glyphicon-indent-left"></span> Qu&iacute;micos por debajo de la cantidad m&iacute;nima </a></li>
					</ul>
				</li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<span class="glyphicon glyphicon-user"></span>
						<?php echo $_SESSION['usuario_'] ?>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="salir.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
						
						<?php
						if($_SESSION['nivel_']=='administrador')
						{
							echo "<li><a href='respaldar_restaurar.php'><span class='glyphicon glyphicon-import'></span> Respaldar y Restaurar BD <span class='glyphicon glyphicon-export'></span></a></li>";
						}
						?>
					</ul>
				</li>

				<li>
					<a href="#">
						<?php echo date("d-m-Y") ?> <span id="time0"><?php echo date("h:m:s") ?></span><?php echo " ".ucfirst($_SESSION['nivel_']) ?>
					</a>
				</li>

			</ul>

		</div>
	</div>
</nav>