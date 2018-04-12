<?php
class Usuarios{
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

    function autenticar_usuario($usuario, $clave){
        $usuario = $this->conex->real_escape_string(strip_tags(strtoupper($usuario),ENT_QUOTES));
        $clave = $this->conex->real_escape_string(strip_tags(strtolower($clave),ENT_QUOTES));

        $select = "SELECT * FROM usuario WHERE LOWER(usuario) = '$usuario' AND clave = '$clave' ";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){
            $datos = $sql_select->fetch_assoc();
            $this->id = $datos['id'];
            $this->usuario = $datos['usuario'];
            $this->nombre = $datos['nombre'];
            $this->apellido = $datos['apellido'];
            $this->nivel = $datos['nivel'];
            $this->clave = $datos['clave'];
            $this->email = $datos['email'];
            $this->estado = $datos['estado'];
            return true;
        }else{
            return false;
        }
    }

    function registrar_usuario( $usuario, $clave1, $clave2, $nombre, $apellido, $nivel, $email, $estado){
        $usuario = $this->conex->real_escape_string(strip_tags(strtoupper($usuario),ENT_QUOTES));
        $clave1 = $this->conex->real_escape_string(strip_tags($clave1,ENT_QUOTES));
        $clave2 = $this->conex->real_escape_string(strip_tags($clave2,ENT_QUOTES));
        $nombre = $this->conex->real_escape_string(strip_tags(strtoupper($nombre),ENT_QUOTES));
        $apellido = $this->conex->real_escape_string(strip_tags(strtoupper($apellido),ENT_QUOTES));
        $nivel = $this->conex->real_escape_string(strip_tags($nivel,ENT_QUOTES));
        $email = $this->conex->real_escape_string(strip_tags(strtoupper($email),ENT_QUOTES));
        $estado = $this->conex->real_escape_string(strip_tags($estado,ENT_QUOTES));
        $this->error = "";

        if($clave1 != $clave2){
            $this->error = "Claves no coinciden.";
            return false;
        }

        $select = "SELECT usuario FROM usuario WHERE LOWER(usuario) = '".strtolower($usuario)."' ";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){
            $this->error = "Ya existe este usuario.";
            return false;
        }else{
            $insert = "INSERT INTO usuario(usuario, clave, nombre, apellido, nivel, email, estado) VALUES ('$usuario', '$clave1', '$nombre', '$apellido', '$nivel', '$email', $estado)";
            if($this->conex->query($insert)){
                return true;
            }else{
                $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
                return false;
            }
        }
    }

    function obtener_usuarios(){
        $select = "SELECT * FROM usuario WHERE estado <> 2 ORDER BY id ASC";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function obtener_usuario_by_id($id){
        $id = $this->conex->real_escape_string(strip_tags(strtolower($id),ENT_QUOTES));

        $select = "SELECT * FROM usuario WHERE id = $id ";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){
            $datos = $sql_select->fetch_assoc();
            $this->id = $datos['id'];
            $this->usuario = $datos['usuario'];
            $this->nombre = $datos['nombre'];
            $this->apellido = $datos['apellido'];
            $this->nivel = $datos['nivel'];
            $this->clave = $datos['clave'];
            $this->email = $datos['email'];
            $this->estado = $datos['estado'];
            return true;
        }else{
            return false;
        }
    }

    function editar_usuario($id, $usuario, $clave1, $clave2, $nombre, $apellido, $nivel, $email, $estado){
        $usuario = $this->conex->real_escape_string(strip_tags($usuario,ENT_QUOTES));
        $clave1 = $this->conex->real_escape_string(strip_tags($clave1,ENT_QUOTES));
        $clave2 = $this->conex->real_escape_string(strip_tags($clave2,ENT_QUOTES));
        $nombre = $this->conex->real_escape_string(strip_tags($nombre,ENT_QUOTES));
        $apellido = $this->conex->real_escape_string(strip_tags($apellido,ENT_QUOTES));
        $nivel = $this->conex->real_escape_string(strip_tags($nivel,ENT_QUOTES));
        $email = $this->conex->real_escape_string(strip_tags($email,ENT_QUOTES));
        $estado = $this->conex->real_escape_string(strip_tags($estado,ENT_QUOTES));

        if($clave1 != $clave2){
            $this->error = "Claves no coinciden.";
            return false;
        }

        if($this->obtener_usuario_by_id($id)){
            if($this->usuario != $usuario){
                $select = "SELECT usuario FROM usuario WHERE LOWER(usuario) = '".strtolower($usuario)."' ";
                $sql_select = $this->conex->query($select);
                if($sql_select->num_rows > 0){
                    $this->error = "Ya existe este usuario.";
                    return false;
                }
            }

            $update = "UPDATE usuario SET usuario = '$usuario', clave = '$clave1', nombre = '$nombre', apellido = '$apellido', nivel = '$nivel', email = '$email', estado = $estado WHERE id = $id";
            if($this->conex->query($update)){
                return true;
            }else{
                $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
                return false;
            }
        }else{
            $this->error = "Usuario Inválido.";
            return false;
        }
    }

    function enviarDatosRecuperacion($destinatario){
        $destinatario = $this->conex->real_escape_string(strip_tags($destinatario,ENT_QUOTES));
       
        $select = "SELECT usuario, clave, nombre FROM usuario WHERE LOWER(email) = '".$destinatario."' ";
        $sql_select = $this->conex->query($select);
        
        if($sql_select->num_rows > 0){
            $datos = $sql_select->fetch_assoc();


            include('libs/mail/class.phpmailer.php');
            include('libs/mail/class.smtp.php');
          
            $username = $this->username;
            $password = $this->password;
            $subject = "Ha recibido un correo de <EXTINMAR CA>";
            $titulo = "<Recuperación de usuario>";

           $observacion = "
            <div style='width:600; height: 50px; background: #111; padding: 5px 15px; box-sizing:border-box'>
                <p style='text-align: center;color:#fe0000'>DATOS DE USUARIO</p>
            </div>
            <div style='width:600; min-height: 50px; border: #111 solid 2px; padding: 10px 15px; box-sizing:border-box'>
                <strong>Hola estimado ".$datos['nombre'].", hemos recibido una solicitud de envío de datos. Puede iniciar sesi&oacute;n nuevamente en nuestra plataforma con su usuario y clave:</strong><br><br>
                Usuario: <strong>".$datos['usuario']."</strong><br>
                Clave: <strong>".$datos['clave']."</strong><br><br>
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

            if($mail->Send()){
                $this->msj = 'Hemos enviado sus datos de usuario al correo que nos ha especificado.';
                return true;
            }else{
               $this->error = 'Parece que nuestro proveedor de correo ha fallado. Intente nuevamente.';
               return false;
            }
        }else{
            $this->error = 'Este correo no se encuentra en nuestra plataforma';
            return false;
        }
    }

    function sendNotificationStock($nombreProducto){
        $nombreProducto = $this->conex->real_escape_string(strip_tags($nombreProducto,ENT_QUOTES));
       
        include('libs/mail/class.phpmailer.php');
        include('libs/mail/class.smtp.php');
      
        $username = $this->username;
        $password = $this->password;
        $subject = "Ha recibido un correo de <EXTINMAR CA>";
        $titulo = "<Producto ha alcanzado nivel mínimo de inventario>";

       $observacion = "
        <div style='width:600; height: 50px; background: #111; padding: 5px 15px; box-sizing:border-box'>
            <p style='text-align: center;color:#fe0000'>INFORMACIÓN</p>
        </div>
        <div style='width:600; min-height: 50px; border: #111 solid 2px; padding: 10px 15px; box-sizing:border-box'>
            <strong>Le informamos que el articulo (".$nombreProducto.") se encuentra en su nivel mínimo en inventario. Tratar de reponer lo más pronto posible.</strong>
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

        if($this->obtener_usuarios()){
            while ($row = $this->array->fetch_assoc()) {
                if($row["nivel"] == "Administrador"){
                    $mail->AddAddress($row["email"], 'Extinmar');
                }
            }
        }
        $mail->isHtml(true);
        $mail->Subject = $subject;
        $mail->MsgHTML($observacion);
        $mail->AltBody = $observacion;

        if($mail->Send()){
            return true;
        }else{
           return false;
        }
    }

}
?>