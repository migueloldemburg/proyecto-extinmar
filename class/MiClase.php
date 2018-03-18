<?php
class MiClase{
	function __construct(){
       $this->conectar();
    }
    function __destruct(){
        $this->desconectar();
    }
    function conectar(){
        require('Conexion.php');
        $this->conex = $conexion;
    }
    function desconectar(){
        $this->conex->close();  
    }

    function cambiar_estado($id, $de, $estado){
        $id = $this->conex->real_escape_string(strip_tags($id,ENT_QUOTES));
        $de = $this->conex->real_escape_string(strip_tags($de,ENT_QUOTES));
        $estado = $this->conex->real_escape_string(strip_tags($estado,ENT_QUOTES));

        $update = "UPDATE $de SET estado = $estado WHERE id = $id ";
        if($this->conex->query($update)){
            return true;
        }else{
            $this->error = "Ha ocurrido un problema al intentar eliminar.";
            return false;
        }
    }

    function eliminar_elemento($id, $de){
        $id = $this->conex->real_escape_string(strip_tags($id,ENT_QUOTES));
        $de = $this->conex->real_escape_string(strip_tags($de,ENT_QUOTES));

        $delete = "DELETE FROM $de WHERE id = $id ";
        if($this->conex->query($delete)){
            return true;
        }else{
            $this->error = "Ha ocurrido un problema al intentar eliminar.";
            return false;
        }
    }

    function registrar_categoria($nombre, $estado){
        $nombre = $this->conex->real_escape_string(strip_tags(strtoupper($nombre),ENT_QUOTES));
        $estado = $this->conex->real_escape_string(strip_tags(strtoupper($estado),ENT_QUOTES));
        $this->error = "";
        
        $insert = "INSERT INTO ext_categoria (nombre, estado) VALUES ('$nombre', $estado)";
        if($this->conex->query($insert)){
            return true;
        }else{
            $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
            return false;
        }
    }

    function obtener_categorias(){
        $select = "SELECT * FROM ext_categoria WHERE estado <> 2 ORDER BY id ASC";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function obtener_categoria_by_id($id){
        $id = $this->conex->real_escape_string(strip_tags(strtolower($id),ENT_QUOTES));

        $select = "SELECT * FROM ext_categoria WHERE id = $id ";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){
            $datos = $sql_select->fetch_assoc();
            $this->id = $datos['id'];
            $this->nombre = $datos['nombre'];
            $this->estado = $datos['estado'];
            return true;
        }else{
            return false;
        }
    }

    function obtener_extintores_by_categoria($id_ext_categoria){
        $id_ext_categoria = $this->conex->real_escape_string(strip_tags(strtolower($id_ext_categoria),ENT_QUOTES));

        $select = "SELECT e.*, e_c.nombre FROM extintor AS e INNER JOIN ext_categoria AS e_c ON e_c.id = e.id_ext_categoria WHERE e.id_ext_categoria = $id_ext_categoria AND e.estado <> 2 ";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function obtener_servicio_extintor($id_extintor){
        $id_extintor = $this->conex->real_escape_string(strip_tags(strtolower($id_extintor),ENT_QUOTES));

        $select = "SELECT sd.id, sd.id_servicio, sd.cantidad, e.capacidad, s.nombre, s.precio, s.cantidad AS cantidadStock FROM servicios_por_defecto AS sd INNER JOIN extintor AS e ON e.id = sd.id_extintor INNER JOIN servicio AS s ON s.id = sd.id_servicio WHERE sd.id_extintor = $id_extintor";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function editar_categoria($id, $nombre){
        $id = $this->conex->real_escape_string(strip_tags($id,ENT_QUOTES));
        $nombre = $this->conex->real_escape_string(strip_tags(strtoupper($nombre),ENT_QUOTES));

        $update = "UPDATE ext_categoria SET nombre = '$nombre' WHERE id = $id";
        if($this->conex->query($update)){
            return true;
        }else{
            $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
            return false;
        }
    }

    function registrar_extintor($id_ext_categoria, $capacidad, $estado){
        $id_ext_categoria = $this->conex->real_escape_string(strip_tags($id_ext_categoria,ENT_QUOTES));
        $capacidad = $this->conex->real_escape_string(strip_tags($capacidad,ENT_QUOTES));
        $estado = $this->conex->real_escape_string(strip_tags($estado,ENT_QUOTES));
        $this->error = "";
        
        $select = "SELECT * FROM extintor WHERE capacidad = $capacidad AND id_ext_categoria = $id_ext_categoria ";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){
            $this->error = "Ya existe un extintor con la capacidad seleccionada.";
            return false;
        }else{
             $insert = "INSERT INTO extintor (id_ext_categoria, capacidad, estado) VALUES ($id_ext_categoria, $capacidad, $estado)";
            if($this->conex->query($insert)){
                return true;
            }else{
                $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
                return false;
            }
        }
    }

    function obtener_extintor_by_id($id){
        $id = $this->conex->real_escape_string(strip_tags(strtolower($id),ENT_QUOTES));

        $select = "SELECT e.*, e_c.nombre  FROM extintor AS e INNER JOIN ext_categoria AS e_c ON e_c.id = e.id_ext_categoria WHERE e.id = $id ";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){
            $datos = $sql_select->fetch_assoc();
            $this->id = $datos['id'];
            $this->id_ext_categoria = $datos['id_ext_categoria'];
            $this->nombre_categoria = $datos['nombre'];
            $this->capacidad = $datos['capacidad'];
            $this->estado = $datos['estado'];
            return true;
        }else{
            return false;
        }
    }

    function editar_extintor($id, $capacidad){
        $id = $this->conex->real_escape_string(strip_tags($id,ENT_QUOTES));
        $capacidad = $this->conex->real_escape_string(strip_tags($capacidad,ENT_QUOTES));

        $update = "UPDATE extintor SET capacidad = $capacidad WHERE id = $id";
        if($this->conex->query($update)){
            return true;
        }else{
            $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
            return false;
        }
    }

    function registrar_ubicacion($departamento, $pasillo, $estado){
        $departamento = $this->conex->real_escape_string(strip_tags(strtoupper($departamento),ENT_QUOTES));
        $pasillo = $this->conex->real_escape_string(strip_tags(strtoupper($pasillo),ENT_QUOTES));
        $estado = $this->conex->real_escape_string(strip_tags(strtoupper($estado),ENT_QUOTES));
        $this->error = "";
        
        $insert = "INSERT INTO ubicacion (departamento, pasillo, estado) VALUES ('$departamento', '$pasillo', $estado)";
        if($this->conex->query($insert)){
            return true;
        }else{
            $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
            return false;
        }
    }

    function obtener_departamentos(){
        $select = "SELECT * FROM ubicacion WHERE estado <> 2 ORDER BY id ASC";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function obtener_ubicacion_by_id($id){
        $id = $this->conex->real_escape_string(strip_tags(strtolower($id),ENT_QUOTES));

        $select = "SELECT * FROM ubicacion WHERE id = $id AND estado <> 2 ";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){
            $datos = $sql_select->fetch_assoc();
            $this->id = $datos['id'];
            $this->departamento = $datos['departamento'];
            $this->pasillo = $datos['pasillo'];
            $this->estado = $datos['estado'];
            return true;
        }else{
            return false;
        }
    }

    function editar_departamento($id, $departamento, $pasillo){
        $id = $this->conex->real_escape_string(strip_tags($id,ENT_QUOTES));
        $departamento = $this->conex->real_escape_string(strip_tags(strtoupper($departamento),ENT_QUOTES));
        $pasillo = $this->conex->real_escape_string(strip_tags(strtoupper($pasillo),ENT_QUOTES));

        $update = "UPDATE ubicacion SET departamento = '$departamento', pasillo = '$pasillo' WHERE id = $id";
        if($this->conex->query($update)){
            return true;
        }else{
            $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
            return false;
        }
    }

    function registrar_ser_categoria($nombre, $precio, $estado){
        $nombre = $this->conex->real_escape_string(strip_tags(strtoupper($nombre),ENT_QUOTES));
        $precio = $this->conex->real_escape_string(strip_tags($precio,ENT_QUOTES));
        $estado = $this->conex->real_escape_string(strip_tags($estado,ENT_QUOTES));
        $this->error = "";
        
        $insert = "INSERT INTO ser_categoria (nombre, precio, estado) VALUES ('$nombre', '$precio', $estado)";
        if($this->conex->query($insert)){
            return true;
        }else{
            $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
            return false;
        }
    }

    function editar_ser_categoria($id, $nombre, $precio){
        $id = $this->conex->real_escape_string(strip_tags($id,ENT_QUOTES));
        $nombre = $this->conex->real_escape_string(strip_tags(strtoupper($nombre),ENT_QUOTES));
        $precio = $this->conex->real_escape_string(strip_tags($precio,ENT_QUOTES));
        $this->error = "";
        
        $update = "UPDATE ser_categoria SET nombre = '$nombre', precio = $precio WHERE id = $id";
        if($this->conex->query($update)){
            return true;
        }else{
            $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
            return false;
        }
    }

    function obtener_ser_categoria(){
        $select = "SELECT * FROM ser_categoria WHERE estado <> 2 ORDER BY id ASC";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function obtener_ser_categoria_not_repuestos(){
        $select = "SELECT * FROM ser_categoria WHERE estado <> 2 AND LOWER(nombre) <> 'repuesto' ORDER BY id ASC";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function obtener_servicios($tipo){
        $tipo = $this->conex->real_escape_string(strip_tags(strtolower($tipo),ENT_QUOTES));
        $select = "SELECT s.*, u.departamento, u.pasillo FROM servicio AS s LEFT JOIN ubicacion AS u ON u.id = s.id_ubicacion WHERE s.tipo = '$tipo' AND s.estado <> 2 ORDER BY s.id ASC";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function obtener_quimicos_por_categoria($id_ext_categoria){
        $id_ext_categoria = $this->conex->real_escape_string(strip_tags(strtolower($id_ext_categoria),ENT_QUOTES));
        if($id_ext_categoria==0){
            $select = "SELECT s.id, s.nombre, s.cantidad, u.departamento, u.pasillo, ec.nombre AS ext_categoria FROM servicios_por_defecto AS spd INNER JOIN servicio AS s ON s.id = spd.id_servicio INNER JOIN extintor AS e ON e.id = spd.id_extintor INNER JOIN ubicacion AS u ON u.id = s.id_ubicacion INNER JOIN ext_categoria AS ec ON ec.id = e.id_ext_categoria WHERE s.tipo = 'quimico' ";
        }else{
            $select = "SELECT s.id, s.nombre, s.cantidad, u.departamento, u.pasillo, ec.nombre AS ext_categoria FROM servicios_por_defecto AS spd INNER JOIN servicio AS s ON s.id = spd.id_servicio INNER JOIN extintor AS e ON e.id = spd.id_extintor INNER JOIN ubicacion AS u ON u.id = s.id_ubicacion INNER JOIN ext_categoria AS ec ON ec.id = e.id_ext_categoria WHERE e.id_ext_categoria = $id_ext_categoria AND s.tipo = 'quimico' ";
        }
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function registrar_servicio($nombre, $precio, $tipo, $id_ubicacion, $estado, $cantidad){
        $nombre = $this->conex->real_escape_string(strip_tags(strtoupper($nombre),ENT_QUOTES));
        $precio = $this->conex->real_escape_string(strip_tags($precio,ENT_QUOTES));
        $tipo = $this->conex->real_escape_string(strip_tags($tipo,ENT_QUOTES));
        $id_ubicacion = $this->conex->real_escape_string(strip_tags($id_ubicacion,ENT_QUOTES));
        $estado = $this->conex->real_escape_string(strip_tags($estado,ENT_QUOTES));
        $cantidad = $this->conex->real_escape_string(strip_tags($cantidad,ENT_QUOTES));
        $this->error = "";
        
        $insert = "INSERT INTO servicio (nombre, precio, id_ubicacion, tipo, estado, cantidad) VALUES ('$nombre', $precio, $id_ubicacion, '$tipo', $estado, '$cantidad')";
        if($this->conex->query($insert)){
            return true;
        }else{
            $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
            return false;
        }
    }

    function obtener_servicio_by_id($id){
        $id = $this->conex->real_escape_string(strip_tags(strtolower($id),ENT_QUOTES));

        $select = "SELECT s.*, u.departamento, u.pasillo FROM servicio AS s LEFT JOIN ubicacion AS u ON u.id = s.id_ubicacion WHERE s.id = $id ";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){
            $datos = $sql_select->fetch_assoc();
            $this->id = $datos['id'];
            $this->tipo = $datos['tipo'];
            $this->nombre = $datos['nombre'];
            $this->precio = $datos['precio'];
            $this->cantidad = $datos['cantidad'];
            $this->id_ubicacion = $datos['id_ubicacion'];
            $this->departamento = $datos['departamento'];
            $this->pasillo = $datos['pasillo'];
            $this->estado = $datos['estado'];
            return true;
        }else{
            return false;
        }
    }

    function editar_servicio($id, $nombre, $precio, $id_ubicacion, $cantidad){
        $id = $this->conex->real_escape_string(strip_tags($id,ENT_QUOTES));
        $nombre = $this->conex->real_escape_string(strip_tags(strtoupper($nombre),ENT_QUOTES));
        $precio = $this->conex->real_escape_string(strip_tags($precio,ENT_QUOTES));
        $id_ubicacion = $this->conex->real_escape_string(strip_tags($id_ubicacion,ENT_QUOTES));
        $cantidad = $this->conex->real_escape_string(strip_tags($cantidad,ENT_QUOTES));

        $update = "UPDATE servicio SET nombre = '$nombre', precio = $precio, id_ubicacion = $id_ubicacion, cantidad = '$cantidad' WHERE id = $id";
        if($this->conex->query($update)){
            return true;
        }else{
            $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
            return false;
        }
    }

    function obtener_servicios_categoria($id_ser_categoria){
        $id_ser_categoria = $this->conex->real_escape_string(strip_tags($id_ser_categoria,ENT_QUOTES));

        $select = "SELECT scd.*, s.id_ubicacion, s.tipo, s.nombre, s.precio, s.estado, s.cantidad FROM ser_categoria_por_defecto AS scd INNER JOIN servicio AS s ON s.id = scd.id_servicio WHERE scd.id_ser_categoria = $id_ser_categoria ORDER BY scd.id ASC";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function asociar_servicio_a_categoria($id_servicio, $id_ser_categoria){
        $id_servicio = $this->conex->real_escape_string(strip_tags($id_servicio,ENT_QUOTES));
        $id_ser_categoria = $this->conex->real_escape_string(strip_tags($id_ser_categoria,ENT_QUOTES));

        $select = "SELECT ser_def.*, ser.nombre FROM ser_categoria_por_defecto AS ser_def INNER JOIN ser_categoria AS ser ON ser.id = ser_def.id_ser_categoria WHERE ser_def.id_servicio = $id_servicio AND ser_def.id_ser_categoria = $id_ser_categoria";

        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){ 
            $datos = $sql_select->fetch_assoc();
            $this->error = "Este servicio ya se encuentra asociado a <strong>".$datos['nombre']."</strong>";
            return false;
        }else{
            $insert = "INSERT INTO ser_categoria_por_defecto (id_ser_categoria, id_servicio) VALUES ($id_ser_categoria, $id_servicio)";
            if($this->conex->query($insert)){
                return true;
            }else{
                $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
                return false;
            }
        }
    }

    function asociar_servicio_a_extintor($id_servicio, $id_extintor, $cantidad){
        $id_servicio = $this->conex->real_escape_string(strip_tags($id_servicio,ENT_QUOTES));
        $id_extintor = $this->conex->real_escape_string(strip_tags($id_extintor,ENT_QUOTES));
        $cantidad = $this->conex->real_escape_string(strip_tags($cantidad,ENT_QUOTES));

        $select = "SELECT * FROM servicios_por_defecto WHERE id_servicio = $id_servicio AND id_extintor = $id_extintor ";

        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){ 
            $datos = $sql_select->fetch_assoc();
            $this->error = "Este servicio ya se encuentra asociado a este extintor";
            return false;
        }else{
            $insert = "INSERT INTO servicios_por_defecto (id_extintor, id_servicio, cantidad) VALUES ($id_extintor, $id_servicio, $cantidad)";
            if($this->conex->query($insert)){
                return true;
            }else{
                $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
                return false;
            }
        }
    }

    function obtener_ser_categoria_by_id($id_ser_categoria){
        $id_ser_categoria = $this->conex->real_escape_string(strip_tags(strtolower($id_ser_categoria),ENT_QUOTES));

        $select = "SELECT * FROM ser_categoria WHERE id = $id_ser_categoria ";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){
            $datos = $sql_select->fetch_assoc();
            $this->id = $datos['id'];
            $this->nombre = $datos['nombre'];
            $this->precio = $datos['precio'];
            $this->estado = $datos['estado'];
            return true;
        }else{
            return false;
        }
    }

    function sumar_a_almacen($id, $cantidad){
        if($this->obtener_servicio_by_id($id)){
            if($this->tipo == 'servicio'){
                return true;// no se cmabia nada
            }elseif ($this->tipo == 'quimico') {
                $stock = preg_replace('/[^0-9]+/', '', $this->cantidad);
                $unidad = preg_replace('/[^A-Za]+/', '', $this->cantidad);
                $cantidad = preg_replace('/[^0-9]+/', '', $cantidad);

                $nuevaCantidad = $stock + $cantidad;
                return $this->set_nueva_cantidad($nuevaCantidad.$unidad);
            }elseif($this->tipo == 'repuesto'){
                $stock = preg_replace('/[^0-9]+/', '', $this->cantidad);
                $unidad = preg_replace('/[^A-Za]+/', '', $this->cantidad);
                $cantidad = preg_replace('/[^0-9]+/', '', $cantidad);

                $nuevaCantidad = $stock + $cantidad;
                return $this->set_nueva_cantidad($nuevaCantidad);
            }
        }else{
            $this->error = "Id no se encuentra";
            return false;
        }
    }

    function restar_de_almacen($id, $cantidad){
        if($this->obtener_servicio_by_id($id)){
            if($this->tipo == 'servicio'){
                return true;// no se cmabia nada
            }elseif ($this->tipo == 'quimico') {
                $stock = preg_replace('/[^0-9]+/', '', $this->cantidad);
                $unidad = preg_replace('/[^A-Za]+/', '', $this->cantidad);
                $cantidad = preg_replace('/[^0-9]+/', '', $cantidad);

                $nuevaCantidad = $stock - $cantidad;
                if($nuevaCantidad < 0)
                    $nuevaCantidad = 0;
                return $this->set_nueva_cantidad($nuevaCantidad.$unidad);
            }elseif($this->tipo == 'repuesto'){
                $stock = preg_replace('/[^0-9]+/', '', $this->cantidad);
                $unidad = preg_replace('/[^A-Za]+/', '', $this->cantidad);
                $cantidad = preg_replace('/[^0-9]+/', '', $cantidad);

                $nuevaCantidad = $stock - $cantidad;
                if($nuevaCantidad < 0)
                    $nuevaCantidad = 0;
                return $this->set_nueva_cantidad($nuevaCantidad);
            }
        }else{
            $this->error = "Id no se encuentra";
            return false;
        }
    }

    function set_nueva_cantidad($cantidad){
        $update = "UPDATE servicio SET cantidad = '$cantidad' WHERE id = ".$this->id;
        if($this->conex->query($update)){
            return true;
        }else{
            $this->error = "Ha ocurrido un problema al intentar eliminar.";
            return false;
        }
    }

    function obtener_extintor_almacen($desde, $hasta, $id_ubicacion){
        $desde = $this->conex->real_escape_string(strip_tags(date("Y-m-d", strtotime($desde)),ENT_QUOTES));
        $hasta = $this->conex->real_escape_string(strip_tags(date("Y-m-d", strtotime($hasta)),ENT_QUOTES));
        $id_ubicacion = $this->conex->real_escape_string(strip_tags($id_ubicacion,ENT_QUOTES));

        if($id_ubicacion==0){
            $select = " SELECT ne.id, ne.estado AS estadoExtintor, ne.observacion, ec.nombre AS categoria, e.capacidad, sc.nombre AS servicio, n.fecha_registro, n.fecha_entrega 
                        FROM nota_extintor AS ne 
                        INNER JOIN extintor AS e ON e.id = ne.id_extintor 
                        INNER JOIN ser_categoria AS sc ON sc.id = ne.id_ser_categoria 
                        INNER JOIN ubicacion AS u ON u.id = ne.id_ubicacion 
                        INNER JOIN ext_categoria AS ec ON ec.id = e.id_ext_categoria 
                        INNER JOIN nota AS n ON n.id = ne.id_nota 
                        WHERE (n.fecha_registro BETWEEN '$desde' AND '$hasta' )AND ne.estado <> 3 AND ne.estado <> 4 ";
        }else{
            $select = " SELECT ne.id, ne.estado AS estadoExtintor, ne.observacion, ec.nombre AS categoria, e.capacidad, sc.nombre AS servicio, n.fecha_registro, n.fecha_entrega 
                        FROM nota_extintor AS ne 
                        INNER JOIN extintor AS e ON e.id = ne.id_extintor 
                        INNER JOIN ser_categoria AS sc ON sc.id = ne.id_ser_categoria 
                        INNER JOIN ubicacion AS u ON u.id = ne.id_ubicacion 
                        INNER JOIN ext_categoria AS ec ON ec.id = e.id_ext_categoria 
                        INNER JOIN nota AS n ON n.id = ne.id_nota 
                        WHERE (n.fecha_registro BETWEEN '$desde' AND '$hasta' ) AND ne.estado <> 3 AND ne.estado <> 4 AND ne.id_ubicacion = $id_ubicacion ";
        }
        // AND (n.fecha_entrega NOT BETWEEN '$desde' AND '$hasta')
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function obtener_extintor_almacen_tipo($id_ext_categoria){
        $id_ext_categoria = $this->conex->real_escape_string(strip_tags($id_ext_categoria,ENT_QUOTES));

        if($id_ext_categoria==0){
            $select = " SELECT ne.id, ne.estado AS estadoExtintor, ne.observacion, ec.nombre AS categoria, e.capacidad, sc.nombre AS servicio, n.fecha_registro, n.fecha_entrega 
                        FROM nota_extintor AS ne 
                        INNER JOIN extintor AS e ON e.id = ne.id_extintor 
                        INNER JOIN ser_categoria AS sc ON sc.id = ne.id_ser_categoria 
                        INNER JOIN ubicacion AS u ON u.id = ne.id_ubicacion 
                        INNER JOIN ext_categoria AS ec ON ec.id = e.id_ext_categoria 
                        INNER JOIN nota AS n ON n.id = ne.id_nota 
                        WHERE ne.estado <> 3 AND ne.estado <> 4 ";
        }else{
            $select = " SELECT ne.id, ne.estado AS estadoExtintor, ne.observacion, ec.nombre AS categoria, e.capacidad, sc.nombre AS servicio, n.fecha_registro, n.fecha_entrega 
                        FROM nota_extintor AS ne 
                        INNER JOIN extintor AS e ON e.id = ne.id_extintor 
                        INNER JOIN ser_categoria AS sc ON sc.id = ne.id_ser_categoria 
                        INNER JOIN ubicacion AS u ON u.id = ne.id_ubicacion 
                        INNER JOIN ext_categoria AS ec ON ec.id = e.id_ext_categoria 
                        INNER JOIN nota AS n ON n.id = ne.id_nota 
                        WHERE ne.estado <> 3 AND ne.estado <> 4 AND ec.id = $id_ext_categoria ";
        }
        // AND (n.fecha_entrega NOT BETWEEN '$desde' AND '$hasta')
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function get_categorias_cantidad($month, $year, $id_ext_categoria){
        $select = " SELECT COUNT(ne.id) AS cantidad 
                    FROM nota_extintor AS ne 
                    INNER JOIN nota AS n ON n.id = ne.id_nota 
                    INNER JOIN extintor AS e ON e.id = ne.id_extintor
                    INNER JOIN ext_categoria AS ec ON ec.id = e.id_ext_categoria
                    WHERE n.fecha_culminacion IS NOT NULL AND MONTH(n.fecha_registro) = '$month' AND YEAR(n.fecha_registro) = '$year' AND ec.id = $id_ext_categoria
                    ";

        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){ 
            $datos = $sql_select->fetch_assoc();
            return $datos['cantidad'];
        }else{
            return 0;
        }
    }

    function validar_nombre($nombre){
        $nombre = $this->conex->real_escape_string(strip_tags($nombre,ENT_QUOTES));
        
        $select = "SELECT * FROM ext_categoria WHERE UPPER(nombre) = '$nombre' ";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){
            return false;
        }else{
            return true;
        }
    }

}
?>