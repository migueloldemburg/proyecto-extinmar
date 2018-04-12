<?php
session_start();
date_default_timezone_set('America/Caracas');
// if(!isset($_SESSION['id_'])){
// 	header("Location:login.php");
// }
function __autoload($classname) {
    $filename = "class/". $classname .".php";
    include_once($filename);
}

switch ($_POST['accion']) {
	case 'registrar_usuario':
		$usuario = new Usuarios();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;
		$datos['exitoso'] = true;

		$_POST['usuario'] =strtolower($_POST['usuario']);
		$_POST['nombre'] =strtolower($_POST['nombre']);
		$_POST['apellido'] =strtolower($_POST['apellido']);

		if($_POST['usuario'] == $_POST['apellido'] || $_POST['usuario'] == $_POST['nombre']){
			$datos['exitoso'] = false;
			$datos['error'] = "Su nombre de usuario deber ser diferente del apellido y/o nombre";
		}

		if($datos['exitoso']){
			if( $usuario->registrar_usuario($_POST['usuario'], $_POST['clave1'], $_POST['clave2'], $_POST['nombre'], $_POST['apellido'], $_POST['nivel'], $_POST['email'], $_POST['estado']) ){
			}else{
				$datos['exitoso'] = false;
				$datos['error'] = $usuario->error;
			}
		}

		echo json_encode($datos);
	break;
	case 'editar_usuario':
		$usuario = new Usuarios();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;
		if($usuario->editar_usuario($_POST['id'], $_POST['usuario'], $_POST['clave1'], $_POST['clave2'], $_POST['nombre'], $_POST['apellido'], $_POST['nivel'], $_POST['email'], $_POST['estado'])){
			$datos['exitoso'] = true;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $usuario->error;
		}

		echo json_encode($datos);
	break;
	case 'obtener_usuario_by_id':
		$usuario = new Usuarios();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;

		if($usuario->obtener_usuario_by_id($_POST['id'])){
			$datos['exitoso'] = true;
			$datos['id'] = 		intval($usuario->id);
            $datos['usuario'] = $usuario->usuario;
            $datos['nombre'] = 	$usuario->nombre;
            $datos['apellido']= $usuario->apellido;
            $datos['nivel'] = 	$usuario->nivel;
            $datos['clave'] = 	$usuario->clave;
            $datos['email'] = 	$usuario->email;
            $datos['estado'] = 	intval($usuario->estado);
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $usuario->error;
		}

		echo json_encode($datos);
	break;
	case 'obtener_ser_categoria_by_id':
		$ser_categoria = new MiClase();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;

		if($ser_categoria->obtener_ser_categoria_by_id($_POST['id'])){
			$datos['exitoso'] = true;
			$datos['id'] = 		intval($ser_categoria->id);
            $datos['precio'] = $ser_categoria->precio;
            $datos['nombre'] = 	$ser_categoria->nombre;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $ser_categoria->error;
		}

		echo json_encode($datos);
	break;
	case 'obtener_cliente_by_id':
		$cliente = new Clientes();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;

		if($cliente->obtener_cliente_by_id($_POST['id'])){
			$datos['exitoso'] = true;
			$datos['id'] = 		intval($cliente->id);
            $datos['cliente'] = $cliente->cliente;
	        $datos['predocumento'] = substr($cliente->documento,0 ,1);
	        $datos['documento'] = filter_var($cliente->documento, FILTER_SANITIZE_NUMBER_INT);
	        $datos['email'] = $cliente->email;
	        $datos['telefono1'] = $cliente->telefono1;
	        $datos['telefono2'] = $cliente->telefono2;
	        $datos['direccion'] = $cliente->direccion;
	        $datos['fecha_registro'] = date("d-m-Y", strtotime($cliente->fecha_registro));
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $cliente->error;
		}

		echo json_encode($datos);
	break;
	case 'obtener_cliente_by_documento':
		$cliente = new Clientes();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;

		if($cliente->obtener_cliente_by_documento($_POST['documento'])){
			$datos['exitoso'] = true;
			$datos['id'] = 		intval($cliente->id);
            $datos['cliente'] = $cliente->cliente;
	        $datos['predocumento'] = substr($cliente->documento,0 ,1);
	        $datos['documento'] = filter_var($cliente->documento, FILTER_SANITIZE_NUMBER_INT);
	        $datos['email'] = $cliente->email;
	        $datos['telefono1'] = $cliente->telefono1;
	        $datos['telefono2'] = $cliente->telefono2;
	        $datos['direccion'] = $cliente->direccion;
	        $datos['fecha_registro'] = $cliente->fecha_registro;
		}else{
			$datos['exitoso'] = false;
		}

		echo json_encode($datos);
	break;
	case 'cambiar_estado':
		$obj = new MiClase();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;
		
		if($_POST["de"]=='usuario' AND $_SESSION["id_"]==$_POST["id"]){
			$datos["exitoso"] = false;
			$datos["error"] = "No puede eliminar el mismo usuario";
			echo json_encode($datos);
			exit();
		}

		if($obj->cambiar_estado($_POST['id'], $_POST['de'], $_POST['estado'])){
			$datos['exitoso'] = true;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $obj->error;
		}

		echo json_encode($datos);
	break;
	case 'delete_from':
		$obj = new MiClase();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;

		if( $obj->eliminar_elemento($_POST['id'], $_POST['de']) ){
			$datos['exitoso'] = true;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $obj->error;
		}

		echo json_encode($datos);
	break;
	case 'eliminar_elemento':
		$obj = new MiClase();
		$datos = array();
		$datos['ejecutar'] = 'cargar_serv_defecto';
		$datos['refrescar'] = false;
		$datos['exitoso'] = true;

		if($obj->eliminar_elemento($_POST['id'], $_POST['de'])){
			$datos['exitoso'] = true;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $obj->error;
		}

		echo json_encode($datos);
	break;
	case 'registrar_cliente':
		$cliente = new Clientes();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;
		$_POST['fecha_registro'] = date("Y-m-d");
		$datos['exitoso'] = true;


		if(strtolower($_POST['predocumento'])=="v"){
			if($_POST['documento'] > 80000000){
				$datos['exitoso'] = false;
				$datos['error'] = "Disculpe, la cédula debe ser menor a 80000000";
			}
		}

		if(strtolower($_POST['predocumento'])=="e"){
			if($_POST['documento'] < 80000000){
				$datos['exitoso'] = false;
				$datos['error'] = "Disculpe, la cédula debe ser mayor a 80000000";
			}
		}

		if($datos['exitoso']){
			if( $cliente->registrar_cliente($_POST['cliente'], $_POST['predocumento'], $_POST['documento'], $_POST['email'], $_POST['telefono1'], $_POST['telefono2'], $_POST['direccion'], $_POST['fecha_registro'])){
				$datos['exitoso'] = true;
			}else{
				$datos['exitoso'] = false;
				$datos['error'] = $cliente->error;
			}
		}

		echo json_encode($datos);
	break;
	case 'registrar_cliente_quick':
		$cliente = new Clientes();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = false;
		$datos['exitoso'] = true;
		$_POST['fecha_registro'] = date("Y-m-d");

		if(strtolower($_POST['predocumento'])=="v"){
			if($_POST['documento'] > 80000000){
				$datos['exitoso'] = false;
				$datos['error'] = "Disculpe, la cédula debe ser menor a 80000000";
			}
		}

		if(strtolower($_POST['predocumento'])=="e"){
			if($_POST['documento'] < 80000000){
				$datos['exitoso'] = false;
				$datos['error'] = "Disculpe, la cédula debe ser mayor a 80000000";
			}
		}

		if($datos['exitoso']){
			if( $cliente->registrar_cliente($_POST['cliente'], $_POST['predocumento'], $_POST['documento'], $_POST['email'], $_POST['telefono1'], $_POST['telefono2'], $_POST['direccion'], $_POST['fecha_registro'])){
				$datos['exitoso'] = true;
				$datos['predocumento'] = $_POST['predocumento'];
				$datos['documento'] = $_POST['documento'];
			}else{
				$datos['exitoso'] = false;
				$datos['error'] = $cliente->error;
			}
		}

		echo json_encode($datos);
	break;
	case 'editar_cliente':
		$cliente = new Clientes();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;
		if($cliente->editar_cliente($_POST['id'], $_POST['cliente'], $_POST['predocumento'], $_POST['documento'], $_POST['email'], $_POST['telefono1'], $_POST['telefono2'], $_POST['direccion'])){
			$datos['exitoso'] = true;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $cliente->error;
		}

		echo json_encode($datos);
	break;
	case 'registrar_categoria':
		$categoria = new MiClase();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;
		$datos['exitoso'] = true;

		if(!$categoria->validar_nombre($_POST['nombre'])){
			$datos['exitoso'] = false;
			$datos['error'] = "Ya existe una categoria con el mismo nombre.";
		}

		if($datos['exitoso']){
			if($categoria->registrar_categoria($_POST['nombre'], 1)){
				$datos['exitoso'] = true;
			}else{
				$datos['exitoso'] = false;
				$datos['error'] = $categoria->error;
			}
		}

		echo json_encode($datos);
	break;
	case 'obtener_categoria_by_id':
		$categoria = new MiClase();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = false;

		if($categoria->obtener_categoria_by_id($_POST['id'])){
			$datos['exitoso'] = true;
			$datos['id'] = intval($categoria->id);
            $datos['nombre'] = $categoria->nombre;
            $datos['estado'] = $categoria->estado;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $categoria->error;
		}

		echo json_encode($datos);
	break;
	case 'editar_categoria':
		$categoria = new MiClase();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;
		if($categoria->editar_categoria($_POST['id'], $_POST['nombre'])){
			$datos['exitoso'] = true;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $categoria->error;
		}

		echo json_encode($datos);
	break;
	case 'cargar_extintores':
		$categorias = new MiClase();
		if($categorias->obtener_extintores_by_categoria($_POST['id'])){
			while($row=$categorias->array->fetch_assoc()){
				echo "<tr class='recargar_serv_defecto' id='".$row['id']."'>";
				echo "<td>".$row['nombre']."</td>";
				echo "<td>".$row['capacidad']."</td>";
				echo "<td>";
					echo "<button class='btn btn-xs btn-warning' data-toggle='modal' data-target='#confExtintores' data-accion='editar' data-id='".$row['id']."'><span class='glyphicon glyphicon-pencil'></span></button> ";
					echo "<button class='btn btn-xs btn-danger cambiar_estado' id='".$row['id']."' de='extintor' estado='2' ><span class='glyphicon glyphicon-remove'></span></button>";
				echo "</td>";
				echo "</tr>";
			}
		}else{
			echo "<tr><td colspan='3'><em>Sin registro de extintores.</em></td></tr>";
		}
	break;
	case 'recargar_serv_defecto':
		$categorias = new MiClase();
		if($categorias->obtener_servicio_extintor($_POST['id'])){
			while($row=$categorias->array->fetch_assoc()){
				echo "<tr>";
				echo "<td>".$row['capacidad']."Lbs</td>";
				echo "<td>".$row['nombre']."</td>";
				echo "<td>".$row['cantidad'].preg_replace('/[^A-Za]+/', '', $row['cantidadStock'])."</td>";
				echo "<td>";
					echo "<button class='btn btn-xs btn-danger eliminar_elemento' id='".$row['id']."' de='servicios_por_defecto'><span class='glyphicon glyphicon-remove'></span></button>";
				echo "</td>";
				echo "</tr>";
			}
		}else{
			echo "<tr><td colspan='3'><em>Sin registro de servicios.</em></td></tr>";
		}
	break;
	case 'recargar_ext_by_categoria_select':
		$categorias = new MiClase();
		if($categorias->obtener_extintores_by_categoria($_POST['id_ext_categoria'])){
			while($row=$categorias->array->fetch_assoc()){
				echo "<option value='".$row['id']."'>".$row['capacidad']." Lbs</option>";
			}
		}else{
			echo "<option value=''>- -</option>";
		}
	break;
	case 'recargar_serv_defecto_tipo':
		$ser_categoria = new MiClase();
		if($ser_categoria->obtener_servicios($_POST['tipo'])){
			if(strtolower($_POST['tipo']) == 'quimico'){
				while($row=$ser_categoria->array->fetch_assoc()){
					echo "<option value='".$row['id']."'>".$row['nombre']." (".$row['cantidad'].")</option>";
				}
			}else{
				while($row=$ser_categoria->array->fetch_assoc()){
					echo "<option value='".$row['id']."'>".$row['nombre']."</option>";
				}
			}	
		}
	break;
	case 'registrar_extintor':
		$extintor = new MiClase();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = false;
		$datos['ejecutar'] = 'recargar_extintores';
		$datos['id_ext_categoria'] = intval($_POST['categoria']);

		if($extintor->registrar_extintor($_POST['categoria'], $_POST['capacidad'], 1)){
			$datos['exitoso'] = true;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $extintor->error;
		}

		echo json_encode($datos);
	break;
	case 'obtener_extintor_by_id':
		$extintor = new MiClase();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = false;

		if($extintor->obtener_extintor_by_id($_POST['id'])){
			$datos['exitoso'] = true;
			$datos['id'] = intval($extintor->id);
            $datos['id_ext_categoria'] = intval($extintor->id_ext_categoria);
            $datos['capacidad'] = intval($extintor->capacidad);
            $datos['estado'] = intval($extintor->estado);
            $datos['nombre_categoria'] = $extintor->nombre_categoria;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $extintor->error;
		}

		echo json_encode($datos);
	break;
	case 'editar_extintor':
		$extintor = new MiClase();
		$datos = array();
		$datos['refrescar'] = false;

		if($extintor->editar_extintor($_POST['id'], $_POST['capacidad'])){
			$datos['exitoso'] = true;
			$datos['ejecutar'] = 'recargar_extintores';
			$extintor->obtener_extintor_by_id($_POST['id']);
			$datos['id_ext_categoria'] = intval($extintor->id_ext_categoria);
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $extintor->error;
			$datos['ejecutar'] = '';
		}

		echo json_encode($datos);
	break;
	case 'registrar_departamento':
		$ubicacion = new MiClase();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;

		if($ubicacion->registrar_ubicacion($_POST['departamento'], $_POST['pasillo'], 1)){
			$datos['exitoso'] = true;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $ubicacion->error;
		}

		echo json_encode($datos);
	break;
	case 'obtener_ubicacion_by_id':
		$ubicacion = new MiClase();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = false;

		if($ubicacion->obtener_ubicacion_by_id($_POST['id'])){
			$datos['exitoso'] = true;
			$datos['id'] = intval($ubicacion->id);
            $datos['departamento'] = $ubicacion->departamento;
            $datos['pasillo'] = $ubicacion->pasillo;
            $datos['estado'] = intval($ubicacion->estado);
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $ubicacion->error;
		}

		echo json_encode($datos);
	break;
	case 'editar_departamento':
		$extintor = new MiClase();
		$datos = array();
		$datos['refrescar'] = true;
		$datos['ejecutar'] = '';

		if($extintor->editar_departamento($_POST['id'], $_POST['departamento'], $_POST['pasillo'])){
			$datos['exitoso'] = true;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $extintor->error;
		}

		echo json_encode($datos);
	break;
	case 'registrar_ser_categoria':
		$ser_categoria = new MiClase();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;

		$_POST['precio'] = str_replace(",", ".", str_replace(".", "", $_POST['precio']));

		if($ser_categoria->registrar_ser_categoria($_POST['nombre'], $_POST['precio'], 1)){
			$datos['exitoso'] = true;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $ser_categoria->error;
		}

		echo json_encode($datos);
	break;
	case 'editar_ser_categoria':
		$ser_categoria = new MiClase();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;

		$_POST['precio'] = str_replace(",", ".", str_replace(".", "", $_POST['precio']));

		if($ser_categoria->editar_ser_categoria($_POST['id'], $_POST['nombre'], $_POST['precio'])){
			$datos['exitoso'] = true;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $ser_categoria->error;
		}

		echo json_encode($datos);
	break;
	case 'registrar_servicio':
		$servicio = new MiClase();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;

		if( strtolower($_POST['tipo']) == 'quimico' ){
			$_POST['cantidad'] = $_POST['cantidad'].$_POST['postCantidad'];
		}

		$_POST['precio'] = str_replace(",", ".", str_replace(".", "", $_POST['precio']));

		if($servicio->registrar_servicio($_POST['nombre'], $_POST['precio'], $_POST['tipo'], $_POST['id_ubicacion'], 1, $_POST['cantidad'])){
			$datos['exitoso'] = true;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $servicio->error;
		}

		echo json_encode($datos);
	break;
	case 'obtener_servicio_by_id':
		$servicio = new MiClase();
		$datos = array();

		if($servicio->obtener_servicio_by_id($_POST['id'])){
			$datos['exitoso'] = true;
			$datos['id'] = intval($servicio->id);
			$datos['id_ubicacion'] = $servicio->id_ubicacion;
            $datos['nombre'] = $servicio->nombre;
            $datos['precio'] = $servicio->precio;
            $datos['cantidad'] = filter_var($servicio->cantidad, FILTER_SANITIZE_NUMBER_INT);
            $datos['estado'] = intval($servicio->estado);
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $servicio->error;
		}

		echo json_encode($datos);
	break;
	case 'editar_servicio':
		$servicio = new MiClase();
		$datos = array();
		$datos['refrescar'] = true;
		$datos['ejecutar'] = '';

		if(!isset($_POST['cantidad'])){
			$_POST['cantidad'] = 0;
		}

		if( strtolower($_POST['tipo']) == 'quimico' ){
			$_POST['cantidad'] = $_POST['cantidad'].$_POST['postCantidad'];
		}

		$_POST['precio'] = str_replace(",", ".", str_replace(".", "", $_POST['precio']));
		
		if($servicio->editar_servicio($_POST['id'], $_POST['nombre'], $_POST['precio'], $_POST['id_ubicacion'], $_POST['cantidad'])){
			$datos['exitoso'] = true;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $servicio->error;
		}

		echo json_encode($datos);
	break;
	case 'asociar_servicio':
		$servicio = new MiClase();
		$datos = array();
		$datos['refrescar'] = true;
		$datos['ejecutar'] = '';

		if($servicio->asociar_servicio_a_categoria($_POST['id_servicio'], $_POST['id_ser_categoria'])){
			$datos['exitoso'] = true;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $servicio->error;
		}

		echo json_encode($datos);
	break;
	case 'asociar_servicio_a_extintor':
		$servicio = new MiClase();
		$datos = array();
		$datos['refrescar'] = false;
		$datos['ejecutar'] = 'cargar_serv_defecto';

		if($_POST['id_extintor']!=0){
			if($servicio->asociar_servicio_a_extintor($_POST['id_servicio'], $_POST['id_extintor'], $_POST['cantidad'])){
				$datos['exitoso'] = true;
			}else{
				$datos['exitoso'] = false;
				$datos['error'] = $servicio->error;
			}
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = "Debe seleccionar un extintor.";
		}

		echo json_encode($datos);
	break;
	case 'agregar_extintor_table':
		?>
		<tr>
			<td>
				<select class="form-control" name="id_ext_categoria" onchange="cargar_extintores_by_categoria(this)">
				<?php
					$Categorias = new MiClase();
					if($Categorias->obtener_categorias()){
						while($row=$Categorias->array->fetch_assoc()){

							echo "<option value='".$row['id']."'>".$row['nombre']."</option>";
						}
					}
				?>
				</select>
			</td>
			<td>
				<select class="form-control" name="id_extintor">
					<!-- dinamico -->
				</select>
			</td>
			<td>
				<select class="form-control" name="id_ser_categoria">
				<?php
					$ser_categoria = new MiClase();
					if($ser_categoria->obtener_ser_categoria()){
						while($row=$ser_categoria->array->fetch_assoc()){
							echo "<option value='".$row['id']."'>".$row['nombre']."</option>";
						}
					}
				?>
				</select>
			</td>
			<td>
				<select class="form-control" name="cantidad">
				<?php 
					for($i=1; $i<21;$i++){
						echo "<option value='".$i."'>".$i."</option>";
					}
				?>
				</select>
			</td>
			<td>
				<button class="btn btn-sm btn-danger delete_this_tr"  type="button"><span class='glyphicon glyphicon-remove'></span></button>
			</td>
		</tr>
		<script>
			cargar_extintores_by_categoria( $("select[name=id_ext_categoria]") )
		</script>
		<?php
	break;
	case 'guardar_nota_servicio':
		$datos = array();
		$datos['exitoso'] = true;
		$datos['error'] = true;

		if(!isset($_POST['id_cliente'])){
			$datos['exitoso'] = false;
			$datos['error'] = "Disculpe, cliente inválido.";
		}else{
			if($_POST['id_cliente']==0){
				$datos['exitoso'] = false;
				$datos['error'] = "Disculpe, cliente inválido.";
			}
		}

		if(!isset($_POST['nota'])){
			$datos['exitoso'] = false;
			$datos['error'] = "Disculpe, ha ocurrido un problema. Intente recargar la página.";
		}


		if($datos['exitoso']){
			$servicios = new MiClase();
			unset($_SESSION['nota']);
			$_SESSION['nota'] = array();
			foreach ($_POST['nota'] as $key => $extintor){
				$id_servicios = array();
				$i = 0;
				if($servicios->obtener_servicios_categoria($extintor['id_ser_categoria'])){
					while($row = $servicios->array->fetch_assoc()){
						$id_servicios[$row['id_servicio']]['id_servicio'] = $row['id_servicio'];
						$id_servicios[$row['id_servicio']]['cantidad'] = 1;
						$id_servicios[$row['id_servicio']]['precio'] = $row['precio'];
					}
				}

				$categorias = new MiClase();
				if($categorias->obtener_servicio_extintor($extintor['id_extintor'])){
					while($row=$categorias->array->fetch_assoc()){
						$id_servicios[$row['id_servicio']]['id_servicio'] = $row['id_servicio'];
						$id_servicios[$row['id_servicio']]['cantidad'] = $row['cantidad'];
						$id_servicios[$row['id_servicio']]['precio'] = $row['precio'];
					}
				}

				for($i=0; $i<$extintor['cantidad']; $i++){
					$_SESSION['nota'][] = array(
						'id_cliente'=> $_POST['id_cliente'],
						'id_extintor'=> $extintor['id_extintor'],
						'id_ser_categoria'=> $extintor['id_ser_categoria'],
						'servicios' => $id_servicios 
					);
				}
			}
		}
		
		echo json_encode($datos);
	break;
	case 'recuperar_clave':
	    $usuario = new Usuarios();
	    if($usuario->enviarDatosRecuperacion($_POST['email'])){
	        echo $usuario->msj;
	    }else{
	        echo $usuario->error;
	    }
	break;
	case 'remover_ser_extintor':
		unset($_SESSION['nota'][$_POST['index']]['servicios'][$_POST['position']]);
		if( count($_SESSION['nota'][$_POST['index']]['servicios']) == 0){
			unset($_SESSION['nota'][$_POST['index']]);
		}
	break;
	case 'agregar_servicio_a_extintor':
		$datos = array();
		$datos['refrescar'] = true;
		$datos['ejecutar'] = '';
		$datos['exitoso'] = true;

		if($_POST['tipo'] != 'servicio'){
			if($_POST['cantidad'] == 0){
				$datos['exitoso'] = false;
				$datos['error'] = "La cantidad debe ser mayor a 0.";
			}
		}
		
		if($datos['exitoso']){
			$servicio = new MiClase();
			$servicio->obtener_servicio_by_id($_POST['id_servicio']);
			$_SESSION['nota'][$_POST['index']]['servicios'][$_POST['id_servicio']]['id_servicio'] = $_POST['id_servicio'];
			$_SESSION['nota'][$_POST['index']]['servicios'][$_POST['id_servicio']]['cantidad'] = $_POST['cantidad'];
			$_SESSION['nota'][$_POST['index']]['servicios'][$_POST['id_servicio']]['precio'] = $servicio->precio;
		}

		echo json_encode($datos);
	break;
	case 'agregar_servicio_a_extintor_en_taller':
		$datos = array();
		$datos['refrescar'] = true;
		$datos['ejecutar'] = '';
		$datos['exitoso'] = true;

		if($_POST['tipo'] != 'servicio'){
			if($_POST['cantidad'] == 0){
				$datos['exitoso'] = false;
				$datos['error'] = "La cantidad debe ser mayor a 0.";
			}
		}
		
		if($datos['exitoso']){
			$servicio =  new MiClase();
			$servicio->obtener_servicio_by_id($_POST['id_servicio']);

			$nota =  new Notas();
			$nota->agregar_servicio_a_extintor($_POST['id_nota_extintor'], $_POST['id_servicio'], $servicio->precio, $_POST['cantidad']);
		}

		echo json_encode($datos);
	break;
	case 'procesar_orden':
		sleep(1);
		
		if(!isset($errors)){
			$id_cliente = $_SESSION['nota'][0]['id_cliente'];
			$id_usuario = $_SESSION['id_'];

			$nota = new Notas();
			if($nota->registrar_nota($id_usuario, $id_cliente)){
				foreach ($_SESSION['nota'] as $key1 => $notaArray){
					$ser_categoria = new MiClase();
					$ser_categoria->obtener_ser_categoria_by_id($notaArray['id_ser_categoria']);
					// Guardo cada extintor con su servicio general (Mantenimiento, Recarga, etc)
					if($nota->agregar_extintor_a_nota($nota->id_nota, $notaArray['id_extintor'], $ser_categoria->id, $ser_categoria->precio)){
						// Guardo cada servicio para cada extintor
						foreach ($notaArray['servicios'] as $key2 => $servicios) {
							$nota->agregar_servicio_a_extintor($nota->id_nota_extintor, $servicios['id_servicio'], $servicios['precio'], $servicios['cantidad']);
						}
						unset($_SESSION['nota']);
					}
				}
			}else{
				echo $nota->error;
			}
		}else{
			foreach ($erros as $error) {
				echo $error."<br>";
			}
		}
	break;
	case 'buscar_notas_01':
		$notas = new Notas();

		if( empty($_POST['id_nota']) ){
			if($notas->obtener_notas_por_fecha($_POST['fecha']))
			{
				$nota = new Notas();
				while($row=$notas->array->fetch_assoc())
				{
					echo "<tr data-toggle='tooltip' data-placement='top' title='".$row['observacion']."'>";
					echo "<td>".$row['id']."</td>";
					echo "<td>".$row['cliente']."</td>";
					echo "<td>".$nota->obtener_num_extintores($row['id'])."</td>";
					echo "<td>".date("d-m-Y", strtotime($row['fecha_registro']))."</td>";
					switch ($row['estado']) {
						case '0': echo "<td><span class='label label-info'>Emitida</span></td>"; break;
						case '1': echo "<td><span class='label label-primary'>En Taller</span></td>"; break;
						case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
						case '3': echo "<td><span class='label label-success'>Despachado</span></td>"; break;
						case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
					}
					echo "<td>";
					echo "<button class='btn btn-xs cancelar_nota' id='".$row['id']."'><span class='glyphicon glyphicon-remove'></span></button>";
					echo " <button class='btn btn-xs' onclick='ver_extintores_nota(".$row['id'].")'><span class='glyphicon glyphicon-eye-open'></span></button>";
					echo " <button class='btn btn-xs' onclick='imprimir_nota(".$row['id'].")'><span class='glyphicon glyphicon-print'></span></button>";
					echo "</td>";
					echo "</tr>";
				}
			}else{
				echo "<tr><td colspan='5'><em>No hay notas para la fecha seleccionada</em></td></tr>";
			}
		}else{
			if($notas->obtener_nota_por_id($_POST['id_nota']))
			{
				echo "<tr data-toggle='tooltip' data-placement='top' title='".$notas->observacion."'>";
				echo "<td>".$notas->id."</td>";
				echo "<td>".$notas->cliente."</td>";
				echo "<td>".$notas->obtener_num_extintores($notas->id)."</td>";
				echo "<td>".$notas->fecha_registro."</td>";
				switch ($notas->estado) {
					case '0': echo "<td><span class='label label-info'>Emitida</span></td>"; break;
					case '1': echo "<td><span class='label label-primary'>En Taller</span></td>"; break;
					case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
					case '3': echo "<td><span class='label label-success'>Retirado</span></td>"; break;
					case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
				}
				echo "<td>";
				echo "<button class='btn btn-xs cancelar_nota' id='".$notas->id."'><span class='glyphicon glyphicon-remove'></span></button>";
				echo " <button class='btn btn-xs' onclick='ver_extintores_nota(".$notas->id.")'><span class='glyphicon glyphicon-eye-open'></span></button>";
				echo "</td>";
				echo "</tr>";
			}else{
				echo "<tr><td colspan='5'><em>El n&uacute;mero de nota de servicio no se encuentra.</em></td></tr>";
			}
		}
	break;
	case 'ver_extintores_nota':
		$notas = new Notas();	
		if($notas->obtener_extintores_nota($_POST['id_nota']))
		{
			$nota = new Notas();
			while($row=$notas->array->fetch_assoc())
			{
				echo "<tr>";
					echo "<td>".$row['categoria']."</td>";
					echo "<td>".$row['capacidad']."lbs</td>";
					echo "<td>".$row['servicio_general']."</td>";
					echo "<td><select class='form-control ubi_01' id='".$row['id']."'>";
					$departamentos = new MiClase();
					if($departamentos->obtener_departamentos()){
						echo "<option value='0'>Sin asignar</option>";
						while($dep=$departamentos->array->fetch_assoc()){
							if($row['id_ubicacion'] == $dep['id']){
								echo "<option value='".$dep['id']."' selected>".$dep['departamento']."-".$dep['pasillo']."</option>";
							}else{
								echo "<option value='".$dep['id']."'>".$dep['departamento']."-".$dep['pasillo']."</option>";
							}
						}
					}
					echo "</select></td>";
					switch ($row['estado']) {
						case '0': echo "<td><span class='label label-info'>En Espera</span></td>"; break;
						case '1': echo "<td><span class='label label-primary'>En taller</span></td>"; break;
						case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
						case '3': echo "<td><span class='label label-success'>Retirado</span></td>"; break;
						case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
					}
					echo "<td>";
					echo " <button class='btn btn-xs' data-toggle='modal' data-target='#verServicios' data-id='".$row['id']."'><span class='glyphicon glyphicon-eye-open'></span></button>";
					echo "</td>";
				echo "</tr>";
			}
		}else{
			echo "<tr><td colspan='5'><em>Parece que no hay extintores agregados.</em></td></tr>";
		}
	break;
	case 'verServicios_de_extintores':
		$notas = new Notas();	
		if($notas->obtener_servicios_nota($_POST['id_nota_extintor']))
		{
			$nota = new Notas();
			while($row=$notas->array->fetch_assoc())
			{
				echo "<tr>";
					echo "<td>".$row['nombre']."</td>";
					switch ($row['estado']) {
						case '0': echo "<td><span class='label label-info'>En Espera</span></td>"; break;
						case '1': echo "<td><span class='label label-primary'>En proceso</span></td>"; break;
						case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
						case '3': echo "<td><span class='label label-success'>Retirado</span></td>"; break;
						case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
					}
					echo "<td>";
					echo " <button class='btn btn-xs eliminar_de_tabla' id='".$row['id']."' de='servicio_extintor' id_nota_extintor='".$_POST['id_nota_extintor']."'><span class='glyphicon glyphicon-trash'></span></button>";
					echo "</td>";
				echo "</tr>";
			}
		}else{
			echo "<tr><td colspan='3'><em>Parece que no hay servicios agregados.</em></td></tr>";
		}
	break;
	case 'verServicios_de_extintores2':
		$notas = new Notas();	
		if($notas->obtener_servicios_nota($_POST['id_nota_extintor']))
		{
			$nota = new Notas();
			while($row=$notas->array->fetch_assoc())
			{
				echo "<tr>";
					echo "<td>".$row['nombre']."</td>";
					switch ($row['estado']) {
						case '0': echo "<td><span class='label label-info'>En Espera</span></td>"; break;
						case '1': echo "<td><span class='label label-primary'>En proceso</span></td>"; break;
						case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
						case '3': echo "<td><span class='label label-success'>Retirado</span></td>"; break;
						case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
					}
				echo "</tr>";
			}
		}else{
			echo "<tr><td colspan='3'><em>Parece que no hay servicios agregados.</em></td></tr>";
		}
	break;
	case 'eliminar_de_tabla':
		$obj = new MiClase();
		$datos = array();

		if($obj->eliminar_elemento($_POST['id'], $_POST['de'])){
			$datos['exitoso'] = true;
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $obj->error;
		}

		echo json_encode($datos);
	break;
	case 'cancelar_nota':
		$nota = new Notas();
		if(!$nota->cancelar_nota($_POST['id'], $_POST['observacion'])){
			echo $nota->error;
		}
	break;
	case 'cambiar_ubicacion_nota_extintor':
		$nota = new Notas();
		if(!$nota->cambiar_ubicacion_nota_extintor($_POST['id_nota_extintor'], $_POST['id_ubicacion'])){
			echo $nota->error;
		}
	break;
	case 'buscar_notas_por_estado':
		$notas = new Notas();

		if( empty($_POST['id_nota']) ){
			if($notas->obtener_notas_por_estado($_POST['estado'], $_POST['from'], $_POST['to']))
			{
				$nota = new Notas();
				while($row=$notas->array->fetch_assoc())
				{
					echo "<tr data-toggle='tooltip' data-placement='top' title='".$row['observacion']."'>";
					echo "<td>".$row['id']."</td>";
					echo "<td>".$row['cliente']."</td>";
					echo "<td>".$nota->obtener_num_extintores($row['id'])."</td>";
					echo "<td>".date("d-m-Y", strtotime($row['fecha_registro']))."</td>";

					if($row['fecha_entrega'] != null){
						echo "<td>".date("d-m-Y", strtotime($row['fecha_entrega']))."</td>";
					}else{
						echo "<td>-Sin entregar-</td>";
					}
					switch ($row['estado']) {
						case '0': echo "<td><span class='label label-info'>Emitida</span></td>"; break;
						case '1': echo "<td><span class='label label-primary'>En Taller</span></td>"; break;
						case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
						case '3': echo "<td><span class='label label-success'>Despachado</span></td>"; break;
						case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
					}
					echo "<td>";
					echo "<button class='btn btn-xs cancelar_nota' id='".$row['id']."'><span class='glyphicon glyphicon-remove'></span></button>";
					echo " <button class='btn btn-xs' data-id='".$row['id']."' data-toggle='modal' data-target='#verExtintores'><span class='glyphicon glyphicon-eye-open'></span></button>";
					echo "</td>";
					echo "</tr>";
				}
			}else{
				echo "<tr><td colspan='5'><em>No hay notas para la fecha seleccionada</em></td></tr>";
			}
		}else{
			if($notas->obtener_nota_por_id($_POST['id_nota']))
			{
				echo "<tr data-toggle='tooltip' data-placement='top' title='".$notas->observacion."'>";
				echo "<td>".$notas->id."</td>";
				echo "<td>".$notas->cliente."</td>";
				echo "<td>".$notas->obtener_num_extintores($notas->id)."</td>";
				echo "<td>".$notas->fecha_registro."</td>";
				switch ($notas->estado) {
					case '0': echo "<td><span class='label label-info'>Emitida</span></td>"; break;
					case '1': echo "<td><span class='label label-primary'>En Taller</span></td>"; break;
					case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
					case '3': echo "<td><span class='label label-success'>Despachado</span></td>"; break;
					case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
				}
				echo "<td>";
				echo "<button class='btn btn-xs cancelar_nota' id='".$notas->id."'><span class='glyphicon glyphicon-remove'></span></button>";
				echo " <button class='btn btn-xs' data-id='".$notas->id."' data-toggle='modal' data-target='#verExtintores'><span class='glyphicon glyphicon-eye-open'></span></button>";
				echo "</td>";
				echo "</tr>";
			}else{
				echo "<tr><td colspan='5'><em>El n&uacute;mero de nota de servicio no se encuentra.</em></td></tr>";
			}
		}	
	break;
	case 'buscar_notas_02':
		$notas = new Notas();

		if( empty($_POST['id_nota']) ){
			if($notas->obtener_notas_por_estado($_POST['estado'], $_POST['from'], $_POST['to']))
			{
				$nota = new Notas();
				while($row=$notas->array->fetch_assoc())
				{
					echo "<tr data-toggle='tooltip' data-placement='top' title='".$row['observacion']."'>";
					echo "<td>".$row['id']."</td>";
					echo "<td>".$row['cliente']."</td>";
					echo "<td>".$nota->obtener_num_extintores($row['id'])."</td>";
					echo "<td>".date("d-m-Y", strtotime($row['fecha_registro']))."</td>";
					switch ($row['estado']) {
						case '0': echo "<td><span class='label label-info'>Emitida</span></td>"; break;
						case '1': echo "<td><span class='label label-primary'>En Taller</span></td>"; break;
						case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
						case '3': echo "<td><span class='label label-success'>Despachado</span></td>"; break;
						case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
					}
					echo "<td>";
					echo "<button class='btn btn-sm btn-warning' onclick=\"location.href='atenderOrden2.php?id_nota=".$row['id']."'\">Atender</button>";
					echo "</td>";
					echo "</tr>";
				}
			}else{
				echo "<tr><td colspan='5'><em>No hay notas para la fecha seleccionada</em></td></tr>";
			}
		}else{
			if($notas->obtener_nota_por_id($_POST['id_nota']))
			{
				echo "<tr data-toggle='tooltip' data-placement='top' title='".$notas->observacion."'>";
				echo "<td>".$notas->id."</td>";
				echo "<td>".$notas->cliente."</td>";
				echo "<td>".$notas->obtener_num_extintores($notas->id)."</td>";
				echo "<td>".$notas->fecha_registro."</td>";
				switch ($notas->estado) {
					case '0': echo "<td><span class='label label-info'>Emitida</span></td>"; break;
					case '1': echo "<td><span class='label label-primary'>En Taller</span></td>"; break;
					case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
					case '3': echo "<td><span class='label label-success'>Despachado</span></td>"; break;
					case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
				}
				echo "<td>";
				echo "<button class='btn btn-sm btn-warning' onclick=\"location.href='atenderOrden2.php?id_nota=".$notas->id."'\">Atender</button>";
				echo "</td>";
				echo "</tr>";
			}else{
				echo "<tr><td colspan='5'><em>El n&uacute;mero de nota de servicio no se encuentra.</em></td></tr>";
			}
		}	
	break;
	case 'buscar_notas_03':
		$notas = new Notas();

		if( empty($_POST['id_nota']) ){
			if($notas->obtener_notas_por_estado($_POST['estado'], $_POST['from'], $_POST['to']))
			{
				$nota = new Notas();
				while($row=$notas->array->fetch_assoc())
				{
					echo "<tr data-toggle='tooltip' data-placement='top' title='".$row['observacion']."'>";
					echo "<td>".$row['id']."</td>";
					echo "<td>".$row['cliente']."</td>";
					echo "<td>".$nota->obtener_num_extintores($row['id'])."</td>";
					echo "<td>".date("d-m-Y", strtotime($row['fecha_registro']))."</td>";
					switch ($row['estado']) {
						case '0': echo "<td><span class='label label-info'>Emitida</span></td>"; break;
						case '1': echo "<td><span class='label label-primary'>En Taller</span></td>"; break;
						case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
						case '3': echo "<td><span class='label label-success'>Despachado</span></td>"; break;
						case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
					}
					echo "<td>";
					echo "<button class='btn btn-sm btn-primary' onclick=\"location.href='atenderOrden2.php?fromTaller=1&id_nota=".$row['id']."'\">Ir a taller</button>";
					echo "</td>";
					echo "</tr>";
				}
			}else{
				echo "<tr><td colspan='5'><em>No hay notas para la fecha seleccionada</em></td></tr>";
			}
		}else{
			if($notas->obtener_nota_por_id($_POST['id_nota']))
			{
				echo "<tr data-toggle='tooltip' data-placement='top' title='".$notas->observacion."'>";
				echo "<td>".$notas->id."</td>";
				echo "<td>".$notas->cliente."</td>";
				echo "<td>".$notas->obtener_num_extintores($notas->id)."</td>";
				echo "<td>".$notas->fecha_registro."</td>";
				switch ($notas->estado) {
					case '0': echo "<td><span class='label label-info'>Emitida</span></td>"; break;
					case '1': echo "<td><span class='label label-primary'>En Taller</span></td>"; break;
					case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
					case '3': echo "<td><span class='label label-success'>Despachado</span></td>"; break;
					case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
				}
				echo "<td>";
				echo "<button class='btn btn-sm btn-primary' onclick=\"location.href='atenderOrden2.php?fromTaller=1&id_nota=".$notas->id."'\">Ir a taller</button>";
				echo "</td>";
				echo "</tr>";
			}else{
				echo "<tr><td colspan='5'><em>El n&uacute;mero de nota de servicio no se encuentra.</em></td></tr>";
			}
		}	
	break;
	case 'buscar_notas_04':
		$notas = new Notas();

		if( empty($_POST['id_nota']) ){
			if($notas->obtener_notas_por_estado02($_POST['estado'], $_POST['from'], $_POST['to']))
			{
				$nota = new Notas();
				while($row=$notas->array->fetch_assoc())
				{
					echo "<tr data-toggle='tooltip' data-placement='top' title='".$row['observacion']."'>";
					echo "<td>".$row['id']."</td>";
					echo "<td>".$row['cliente']."</td>";
					echo "<td>".$nota->obtener_num_extintores($row['id'])."</td>";
					echo "<td>".$row['fecha_registro']."</td>";
					echo "<td>".$row['fecha_culminacion']."</td>";
					echo "<td>".date("d-m-Y", strtotime($row['fecha_entrega']))."</td>";
					switch ($row['estado']) {
						case '0': echo "<td><span class='label label-info'>Emitida</span></td>"; break;
						case '1': echo "<td><span class='label label-primary'>En Taller</span></td>"; break;
						case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
						case '3': echo "<td><span class='label label-success'>Despachado</span></td>"; break;
						case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
					}
					echo "<td>";
					if($row['estado']==2){
						echo "<button class='btn btn-sm btn-primary' data-target='#dar_de_baja' data-toggle='modal' data-id='".$row['id']."'>Procesar nota</button>";
					}else{
						echo "Retirada";
					}
					echo "</td>";
					echo "</tr>";
				}
			}else{
				echo "<tr><td colspan='5'><em>No hay notas para la fecha seleccionada</em></td></tr>";
			}
		}else{
			if($notas->obtener_nota_por_id($_POST['id_nota']))
			{
				echo "<tr data-toggle='tooltip' data-placement='top' title='".$notas->observacion."'>";
				echo "<td>".$notas->id."</td>";
				echo "<td>".$notas->cliente."</td>";
				echo "<td>".$notas->obtener_num_extintores($notas->id)."</td>";
				echo "<td>".date("d-m-Y", strtotime($notas->fecha_registro))."</td>";
				echo "<td>".date("d-m-Y", strtotime($notas->fecha_culminacion))."</td>";
				echo "<td>".date("d-m-Y", strtotime($notas->fecha_entrega))."</td>";
				switch ($notas->estado) {
					case '0': echo "<td><span class='label label-info'>Emitida</span></td>"; break;
					case '1': echo "<td><span class='label label-primary'>En Taller</span></td>"; break;
					case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
					case '3': echo "<td><span class='label label-success'>Despachado</span></td>"; break;
					case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
				}
				echo "<td>";
				echo "<button class='btn btn-sm btn-primary' data-target='#dar_de_baja' data-modal='toggle' data-id='".$notas->id."'>Procesar nota</button>";
				echo "</td>";
				echo "</tr>";
			}else{
				echo "<tr><td colspan='5'><em>El n&uacute;mero de nota de servicio no se encuentra.</em></td></tr>";
			}
		}	
	break;
	case 'cambiar_estado_servicio':
		$nota = new Notas();
		if(!$nota->cambiar_estado_servicio($_POST['id'], $_POST['estado'])){
			echo $nota->error;
		}
	break;
	case 'dar_de_baja':
		$nota = new Notas();
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;

		$nota->obtener_nota_por_id($_POST['id_nota']);

		if($nota->cambiar_estado_nota($nota->id, 3)){
			$datos['exitoso'] = true;
			$nota->set_fecha_entrega();
		}else{
			$datos['exitoso'] = false;
			$datos['error'] = $nota->error;
		}
		echo json_encode($datos);
	break;
	case 'chequear_productos_almacen':
		$nota = new Notas();
		$nota->obtener_nota_por_id($_POST['id_nota']);

		$extintores = new Notas();
		if($extintores->obtener_extintores_nota($nota->id))
		{
			$nota = new Notas();
			while($row=$extintores->array->fetch_assoc())
			{
				$servicios = new Notas();	
				if($servicios->obtener_servicios_nota($row['id']))
				{
					$nota = new Notas();
					while($row2=$servicios->array->fetch_assoc())
					{
						$row2['cantidadStock'] = preg_replace('/[^0-9]+/', '', $row2['cantidadStock']);
						if($row2['tipo']!='servicio'){
							// $row2['cantidad']: cantidad que se requiere en el servicio
							if($row2['cantidad'] > $row2['cantidadStock']){
								$errors[] = "Tipo: ".$row2['tipo']." / ".$row2['nombre']." / En existencia: <strong>".$row2['cantidadStock']."</strong> Requerida: <strong>".$row2['cantidad']."</strong>";
							}
						}
					}
				}
			}
		}

		if(isset($errors)){
			echo "No hay suficiente de estos productos en almacén<br>\n";
			foreach ($errors as $error) {
				echo $error."<br>\n";
			}
		}
	break;
	case 'sumar_a_stuck':
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;
		
		$servicio = new MiClase();
		if($_POST['cantidad'] <= 0){
			$datos['exitoso'] = false;
			$datos['error'] = "Disculpe, la cantidad no puede ser menor o igual a cero.";
		}else{
			if($servicio->sumar_a_almacen($_POST['id'], $_POST['cantidad'])){
				$datos['exitoso'] = true;
			}else{
				$datos['exitoso'] = false;
				$datos['error'] = $servicio->error;
			}
		}
		echo json_encode($datos);
	break;
	case 'restar_a_stuck':
		$datos = array();
		$datos['ejecutar'] = '';
		$datos['refrescar'] = true;
		
		$servicio = new MiClase();
		if($_POST['cantidad'] <= 0){
			$datos['exitoso'] = false;
			$datos['error'] = "Disculpe, la cantidad no puede ser menor o igual a cero.";
		}else{
			if($servicio->restar_de_almacen($_POST['id'], $_POST['cantidad'])){
				$datos['exitoso'] = true;
			}else{
				$datos['exitoso'] = false;
				$datos['error'] = $servicio->error;
			}
		}
		echo json_encode($datos);
	break;
	case 'buscar_extintor_fecha':
		$extintores = new MiClase();
		if($extintores->obtener_extintor_almacen($_POST['from'], $_POST['to'], $_POST['id_ubicacion']))
		{
			while($row=$extintores->array->fetch_assoc())
			{
				echo "<tr data-toggle='tooltip' data-placement='top' title='".$row['observacion']."'>";
					echo "<td>".$row['id']."</td>";
					echo "<td>".$row['categoria']."</td>";
					echo "<td>".$row['capacidad']."lbs</td>";
					echo "<td>".$row['servicio']."</td>";
					echo "<td>".date("d-m-Y", strtotime($row['fecha_registro']))."</td>";
					echo "<td>".$row["departamento"]." ".$row["pasillo"]."</td>";
					switch ($row['estadoExtintor']) {
						case '0': echo "<td><span class='label label-info'>En Espera</span></td>"; break;
						case '1': echo "<td><span class='label label-primary'>En Taller</span></td>"; break;
						case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
						case '3': echo "<td><span class='label label-success'>Despachado</span></td>"; break;
						case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
					}
					echo "<td>";
					echo "<button class='bn btn-xs btn-default' data-target='#verServicios2' data-toggle='modal' data-id='".$row['id']."'><span class='glyphicon glyphicon-search'></span></button>";
					echo "</td>";
				echo "</tr>";
			}
		}else{
			echo "<tr><td colspan='5'><em>No hay extintores en almacén en fecha seleccionada</em></td></tr>";
		}
	break;
	case 'buscar_extintor_categoria':
		$extintores = new MiClase();
		if($extintores->obtener_extintor_almacen_tipo($_POST['id_ext_categoria']))
		{
			while($row=$extintores->array->fetch_assoc())
			{
				echo "<tr data-toggle='tooltip' data-placement='top' title='".$row['observacion']."'>";
					echo "<td>".$row['id']."</td>";
					echo "<td>".$row['categoria']."</td>";
					echo "<td>".$row['capacidad']."lbs</td>";
					echo "<td>".$row['servicio']."</td>";
					echo "<td>".date("d-m-Y", strtotime($row['fecha_registro']))."</td>";
					echo "<td>".$row["departamento"]." ".$row["pasillo"]."</td>";
					switch ($row['estadoExtintor']) {
						case '0': echo "<td><span class='label label-info'>En Espera</span></td>"; break;
						case '1': echo "<td><span class='label label-primary'>En Taller</span></td>"; break;
						case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
						case '3': echo "<td><span class='label label-success'>Despachado</span></td>"; break;
						case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
					}
					echo "<td>";
					echo "<button class='bn btn-xs btn-default' data-target='#verServicios2' data-toggle='modal' data-id='".$row['id']."'><span class='glyphicon glyphicon-search'></span></button>";
					echo "</td>";
				echo "</tr>";
			}
		}else{
			echo "<tr><td colspan='5'><em>No hay extintores en almacén en fecha seleccionada</em></td></tr>";
		}
	break;
	case 'buscar_quimico_categoria':
		$ser_categoria = new MiClase();
		if($ser_categoria->obtener_quimicos_por_categoria($_POST['id_ext_categoria'])){
			while($row=$ser_categoria->array->fetch_assoc()){
				echo "<tr>";
				echo "<td>".$row['id']."</td>";
				echo "<td>".$row['ext_categoria']."</td>";
				echo "<td>".$row['nombre']."</td>";
				echo "<td>".$row['cantidad']."</td>";
				echo "<td>".$row['departamento']." ".$row['pasillo']."</td>";
				echo "</tr>";
			}
		}else{
			echo "<tr><td colspan='5'><em>No hay qu&iacute;micos registrados.</em></td></tr>";
		}
	break;
	case 'whattime':
		echo date("h:m:s");
	break;
	case 'buscar_extintores_with_servicios_fecha':
		$notas = new Notas();
		if($notas->obtener_notas_por_fecha_rango($_POST['from'], $_POST['to']))
		{
			while($row2=$notas->array->fetch_assoc())
			{
				$extintores = new Notas();
				if($extintores->obtener_extintores_nota($row2['id']))
				{
					$servicios = new Notas();
					while($row=$extintores->array->fetch_assoc())
					{
						echo "<tr>";
						echo "<td>".$row['id']."</td>";
						echo "<td>".$row['categoria']."</td>";
						echo "<td>".$row['capacidad']."lbs</td>";
						echo "<td>".$row['servicio_general']."</td>";
						switch ($row['estado']) {
							case '0': echo "<td><span class='label label-info'>En Espera</span></td>"; break;
							case '1': echo "<td><span class='label label-primary'>En taller</span></td>"; break;
							case '2': echo "<td><span class='label label-warning'>Listo</span></td>"; break;
							case '3': echo "<td><span class='label label-success'>Retirado</span></td>"; break;
							case '4': echo "<td><span class='label label-danger'>Cancelado</span></td>"; break;
						}
						echo "<td>";
						echo " <button class='btn btn-xs' data-toggle='modal' data-target='#verServicios' data-id='".$row['id']."'><span class='glyphicon glyphicon-eye-open'></span></button>";
						echo " <button class='btn btn-xs'><span class='glyphicon glyphicon-print' onclick='imprimir_reporte_06(".$row['id'].")'></span></button>";
						//echo " <button class='btn btn-xs' onclick='imprimir_reporte_06(".$row['id'].", true)'>PDF</button>";
						echo "</td>";
						echo "</tr>";
					}
				}		
			}
		}
	break;
	default:
		# code...
	break;
}

?>