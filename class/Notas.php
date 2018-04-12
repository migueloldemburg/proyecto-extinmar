<?php
class Notas{
	function __construct(){
       $this->conectar();
    }
    function __destruct(){
        $this->desconectar();
    }
    function conectar(){
        require('Conexion.php');
        $this->conex = $conexion;
        $this->username = $username;
        $this->password = $password;
    }
    function desconectar(){
        $this->conex->close();   
    }

    function registrar_nota($id_usuario, $id_cliente){
        $id_usuario = $this->conex->real_escape_string(strip_tags($id_usuario,ENT_QUOTES));
        $id_cliente = $this->conex->real_escape_string(strip_tags($id_cliente,ENT_QUOTES));

        $fecha_registro = date("Y-m-d");

        $insert = "INSERT INTO nota (id_usuario, id_cliente, total, estado, fecha_registro, observacion) VALUES ($id_usuario, $id_cliente, 0, 0, '$fecha_registro', '') ";
        if($this->conex->query($insert)){
            $this->id_nota = $this->conex->insert_id;
            return true;
        }else{
            $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
            return false;
        }
    }

    function agregar_extintor_a_nota($id_nota, $id_extintor, $id_ser_categoria, $precio){
        $id_nota = $this->conex->real_escape_string(strip_tags($id_nota,ENT_QUOTES));
        $id_extintor = $this->conex->real_escape_string(strip_tags($id_extintor,ENT_QUOTES));
        $id_ser_categoria = $this->conex->real_escape_string(strip_tags($id_ser_categoria,ENT_QUOTES));
        $precio = $this->conex->real_escape_string(strip_tags($precio,ENT_QUOTES));

        $insert = "INSERT INTO nota_extintor (id_nota, id_extintor, id_ser_categoria, id_ubicacion, estado, precio, observacion) VALUES ($id_nota, $id_extintor, $id_ser_categoria, 0, 0, $precio, '') ";
        if($this->conex->query($insert)){
            $this->id_nota_extintor = $this->conex->insert_id;
            return true;
        }else{
            $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
            return false;
        }
    }

    function agregar_servicio_a_extintor($id_nota_extintor, $id_servicio, $precio, $cantidad){
        $id_nota_extintor = $this->conex->real_escape_string(strip_tags($id_nota_extintor,ENT_QUOTES));
        $id_servicio = $this->conex->real_escape_string(strip_tags($id_servicio,ENT_QUOTES));
        $precio = $this->conex->real_escape_string(strip_tags($precio,ENT_QUOTES));
        $cantidad = $this->conex->real_escape_string(strip_tags($cantidad,ENT_QUOTES));

        $insert = "INSERT INTO servicio_extintor (id_nota_extintor, id_servicio, precio, cantidad, observacion, estado) VALUES ($id_nota_extintor, $id_servicio, $precio, $cantidad, '', 0) ";
        if($this->conex->query($insert)){
            return true;
        }else{
            $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
            return false;
        }
    }

    function obtener_notas_por_fecha($fecha){
        $fecha = $this->conex->real_escape_string(strip_tags(date("Y-m-d", strtotime($fecha)),ENT_QUOTES));

        $select = " SELECT n.*, u.usuario, u.nombre AS usuario_nombre, u.apellido AS usuario_apellido, c.cliente 
                    FROM nota AS n INNER JOIN usuario AS u ON u.id = n.id_usuario 
                    INNER JOIN cliente AS c ON c.id = n.id_cliente 
                    WHERE n.fecha_registro = '$fecha' ORDER BY n.id DESC ";
        $sql_select = $this->conex->query($select);
        
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function obtener_notas_por_fecha_rango($desde, $hasta){
        $desde = $this->conex->real_escape_string(strip_tags(date("Y-m-d", strtotime($desde)),ENT_QUOTES));
        $hasta = $this->conex->real_escape_string(strip_tags(date("Y-m-d", strtotime($hasta)),ENT_QUOTES));

        $select = " SELECT n.*, u.usuario, u.nombre AS usuario_nombre, u.apellido AS usuario_apellido, c.cliente 
                    FROM nota AS n INNER JOIN usuario AS u ON u.id = n.id_usuario 
                    INNER JOIN cliente AS c ON c.id = n.id_cliente 
                    WHERE n.fecha_registro BETWEEN '$desde' AND '$hasta' ORDER BY n.id DESC ";
        $sql_select = $this->conex->query($select);
        
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function obtener_notas_por_estado($estado, $from, $to){
        $estado = $this->conex->real_escape_string(strip_tags($estado,ENT_QUOTES));
        $from = $this->conex->real_escape_string(strip_tags(date("Y-m-d", strtotime($from)),ENT_QUOTES));
        $to = $this->conex->real_escape_string(strip_tags(date("Y-m-d", strtotime($to)),ENT_QUOTES));

        $select = " SELECT n.*, u.usuario, u.nombre AS usuario_nombre, u.apellido AS usuario_apellido, c.cliente 
                    FROM nota AS n INNER JOIN usuario AS u ON u.id = n.id_usuario 
                    INNER JOIN cliente AS c ON c.id = n.id_cliente 
                    WHERE ( (n.fecha_registro BETWEEN '$from' AND '$to') OR (n.fecha_culminacion BETWEEN '$from' AND '$to') OR (n.fecha_entrega BETWEEN '$from' AND '$to')) ".( ($estado!='') ? "AND n.estado = $estado":"" )." ORDER BY id DESC ";
        $sql_select = $this->conex->query($select);
        
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function obtener_notas_por_estado02($estado, $from, $to){
        $estado = $this->conex->real_escape_string(strip_tags(strtolower($estado),ENT_QUOTES));
        $from = $this->conex->real_escape_string(strip_tags(date("Y-m-d", strtotime($from)),ENT_QUOTES));
        $to = $this->conex->real_escape_string(strip_tags(date("Y-m-d", strtotime($to)),ENT_QUOTES));

        $select = " SELECT n.*, u.usuario, u.nombre AS usuario_nombre, u.apellido AS usuario_apellido, c.cliente 
                    FROM nota AS n INNER JOIN usuario AS u ON u.id = n.id_usuario 
                    INNER JOIN cliente AS c ON c.id = n.id_cliente 
                    WHERE ( (n.fecha_registro BETWEEN '$from' AND '$to') OR (n.fecha_culminacion BETWEEN '$from' AND '$to') OR (n.fecha_entrega BETWEEN '$from' AND '$to')) AND (n.estado = 3 OR n.estado = 2) ";
        $sql_select = $this->conex->query($select);
        
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function obtener_num_extintores($id_nota){
        $id_nota = $this->conex->real_escape_string(strip_tags(strtolower($id_nota),ENT_QUOTES));

        $select = " SELECT COUNT(id_extintor) AS num_extintores FROM nota_extintor WHERE id_nota = $id_nota ";
        $sql_select = $this->conex->query($select);
        
        if($sql_select->num_rows > 0){ 
            $datos = $sql_select->fetch_assoc();
            return $datos['num_extintores'];
        }else{
            return 0;
        }
    }

    function obtener_nota_por_id($id_nota){
        $id_nota = $this->conex->real_escape_string(strip_tags(strtolower($id_nota),ENT_QUOTES));

        $select = " SELECT n.*, u.usuario, u.nombre AS usuario_nombre, u.apellido AS usuario_apellido, c.cliente 
                    FROM nota AS n INNER JOIN usuario AS u ON u.id = n.id_usuario 
                    INNER JOIN cliente AS c ON c.id = n.id_cliente 
                    WHERE n.id = '$id_nota'  ";
        $sql_select = $this->conex->query($select);
        
        if($sql_select->num_rows > 0){ 
            $datos = $sql_select->fetch_assoc();
            $this->id = $datos['id'];
            $this->id_usuario = $datos['id_usuario'];
            $this->id_cliente = $datos['id_cliente'];
            $this->total = $datos['total'];
            $this->estado = $datos['estado'];
            $this->fecha_registro = date("d-m-Y", strtotime($datos['fecha_registro']));
            $this->fecha_culminacion = date("d-m-Y", strtotime($datos['fecha_culminacion']));
            $this->fecha_entrega = date("d-m-Y", strtotime($datos['fecha_entrega']));
            $this->usuario = $datos['usuario'];
            $this->usuario_nombre = $datos['usuario_nombre'];
            $this->usuario_apellido = $datos['usuario_apellido'];
            $this->cliente = $datos['cliente'];
            $this->observacion = $datos['observacion'];
            return true;
        }else{
            return false;
        }
    }

    function obtener_extintores_nota($id_nota){
        $id_nota = $this->conex->real_escape_string(strip_tags(strtolower($id_nota),ENT_QUOTES));

        $select = " SELECT ne.id, ne.estado, ne.precio, ne.observacion, ne.id_ubicacion, e.capacidad, sc.nombre AS servicio_general, ec.nombre AS categoria
                    FROM nota_extintor AS ne 
                    INNER JOIN extintor AS e ON e.id = ne.id_extintor 
                    INNER JOIN ser_categoria AS sc ON sc.id = ne.id_ser_categoria 
                    LEFT JOIN ubicacion AS u ON u.id = ne.id_ubicacion 
                    INNER JOIN ext_categoria AS ec ON ec.id = e.id_ext_categoria
                    WHERE ne.id_nota = $id_nota ";
        $sql_select = $this->conex->query($select);
        
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function obtener_servicios_nota($id_nota_extintor){
        $id_nota_extintor = $this->conex->real_escape_string(strip_tags(strtolower($id_nota_extintor),ENT_QUOTES));

        $select = " SELECT se.*, s.tipo, s.nombre, s.cantidad AS cantidadStock 
                    FROM servicio_extintor AS se 
                    INNER JOIN servicio AS s ON s.id = se.id_servicio 
                    WHERE se.id_nota_extintor = $id_nota_extintor";
        $sql_select = $this->conex->query($select);
        
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function cancelar_nota($id, $observacion){
        $id = $this->conex->real_escape_string(strip_tags(strtolower($id),ENT_QUOTES));
        $observacion = $this->conex->real_escape_string(strip_tags(strtoupper($observacion),ENT_QUOTES));

        $update = "UPDATE nota SET estado = 4, observacion = '$observacion' WHERE id = $id ";
        if($this->conex->query($update)){
            $update = "UPDATE nota_extintor SET estado = 4 WHERE id_nota = $id ";
            if($this->conex->query($update)){
                
                $select = " SELECT * FROM nota_extintor WHERE id_nota = $id";
                $sql_select = $this->conex->query($select);
                    
                if($sql_select->num_rows > 0){ 
                    while($row = $sql_select->fetch_assoc()){
                        $update = "UPDATE servicio_extintor SET estado = 4 WHERE id_nota_extintor = ".$row['id']." ";
                        $this->conex->query($update);
                    }
                    return true;
                }else{
                    return false;
                }
            }else{
                $this->error = "Ha ocurrido un problema al intentar cancelar la nota.";
                return false;
            }
        }else{
            $this->error = "Ha ocurrido un problema al intentar cancelar la nota.";
            return false;
        }
    }

    function cambiar_ubicacion_nota_extintor($id, $id_ubicacion){
        $id = $this->conex->real_escape_string(strip_tags(strtolower($id),ENT_QUOTES));
        $id_ubicacion = $this->conex->real_escape_string(strip_tags(strtolower($id_ubicacion),ENT_QUOTES));

        $update = "UPDATE nota_extintor SET id_ubicacion = $id_ubicacion WHERE id = $id ";
        if($this->conex->query($update)){
            return true;
        }else{
            $this->error = "Id inválido.";
            return false;
        }
    }

    function cambiar_estado_servicio($id, $estado){
        $id = $this->conex->real_escape_string(strip_tags(strtolower($id),ENT_QUOTES));
        $estado = $this->conex->real_escape_string(strip_tags(strtolower($estado),ENT_QUOTES));

        $update = "UPDATE servicio_extintor SET estado = $estado WHERE id = $id ";
        if($this->conex->query($update)){
            return true;
        }else{
            $this->error = "Imposible cambiar.";
            return false;
        }
    }

    function cambiar_estado_nota($id, $estado){
        $id = $this->conex->real_escape_string(strip_tags(strtolower($id),ENT_QUOTES));
        $estado = $this->conex->real_escape_string(strip_tags(strtolower($estado),ENT_QUOTES));

        $update = "UPDATE nota SET estado = $estado WHERE id = $id ";
        if($this->conex->query($update)){
            $update = "UPDATE nota_extintor SET estado = $estado WHERE id_nota = $id ";
            if($this->conex->query($update)){
                $select = " SELECT * FROM nota_extintor WHERE id_nota = $id";
                $sql_select = $this->conex->query($select);
                    
                if($sql_select->num_rows > 0){ 
                    while($row = $sql_select->fetch_assoc()){
                        $update = "UPDATE servicio_extintor SET estado = $estado WHERE id_nota_extintor = ".$row['id']." ";
                        $this->conex->query($update);
                    }
                }
            }
            return true;
        }else{
            $this->error = "Imposible cambiar.";
            return false;
        }
    }

    function enviar_notificacion_cliente($cliente_nombre, $email, $id_nota){
        $cliente_nombre = $this->conex->real_escape_string(strip_tags(strtolower($cliente_nombre),ENT_QUOTES));
        $email = $this->conex->real_escape_string(strip_tags(strtolower($email),ENT_QUOTES));
        $id_nota = $this->conex->real_escape_string(strip_tags(strtolower($id_nota),ENT_QUOTES));

        $destinatario = $email;

        include('libs/mail/class.phpmailer.php');
        include('libs/mail/class.smtp.php');
      
        $username = $this->username;
        $password = $this->password;
        $subject = "Ha recibido un correo de <EXTINMAR CA>";
        $titulo = "< Orden de Servicio >";

        $observacion = "
        <div style='width:600; height: 50px; background: #111; padding: 5px 15px; box-sizing:border-box'>
            <p style='text-align: center;color:#fe0000'>INFORMACION</p>
        </div>
        <div style='width:600; min-height: 50px; border: #111 solid 2px; padding: 10px 15px; box-sizing:border-box'>
            <strong>Hola estimado ".$cliente_nombre.", nos complace informarle que su orden #".$id_nota." se encuentra lista. Ya puede pasar por nuestras oficinas para recoger sus extintores.</strong><br><br>
            <br><br>
            Siempre a la orden,<br>Equipo de EXTINMAR C.A.
            <br><br>
        </div>
        ";
        // *********************************************

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = 'UTF-8';
        // 0 en produccion
        $mail->SMTPDebug  = 0;
        $mail->Host       = 'smtp.gmail.com';
        $mail->Port       = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth   = true;
        $mail->Username   = $username;
        $mail->Password   = $password;
        $mail->SetFrom($username, $titulo);
        $mail->AddAddress($destinatario, 'Extinmar');
        $mail->isHtml(true);
        $mail->Subject = $subject;
        $mail->MsgHTML($observacion);
        $mail->AltBody = $observacion;

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        if($mail->Send()){
            $this->msj = 'Hemos enviado sus datos de usuario al correo que nos ha especificado.';
            return true;
        }else{
           $this->error = 'Parece que nuestro proveedor de correo ha fallado. Intente nuevamente.';
           return false;
        }
    }

    function set_fecha_culminacion(){
        $update = "UPDATE nota SET fecha_culminacion = '".date("Y-m-d")."' WHERE id = ".$this->id." ";
        if($this->conex->query($update)){
            return true;
        }else{
            $this->error = "Id inválido.";
            return false;
        }
    }

    function set_fecha_entrega(){
        $update = "UPDATE nota SET fecha_entrega = '".date("Y-m-d")."' WHERE id = ".$this->id." ";
        if($this->conex->query($update)){
            return true;
        }else{
            $this->error = "Id inválido.";
            return false;
        }
    }

}
?>