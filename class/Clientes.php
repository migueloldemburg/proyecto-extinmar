<?php
class Clientes{
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

    function registrar_cliente($cliente, $predocumento, $documento, $email, $telefono1, $telefono2, $direccion, $fecha_registro){
        $cliente = $this->conex->real_escape_string(strip_tags(strtoupper($cliente),ENT_QUOTES));
        $predocumento = $this->conex->real_escape_string(strip_tags(strtoupper($predocumento),ENT_QUOTES));
        $documento = $this->conex->real_escape_string(strip_tags($documento,ENT_QUOTES));
        $email = $this->conex->real_escape_string(strip_tags(strtoupper($email),ENT_QUOTES));
        $telefono1 = $this->conex->real_escape_string(strip_tags($telefono1,ENT_QUOTES));
        $telefono2 = $this->conex->real_escape_string(strip_tags($telefono2,ENT_QUOTES));
        $direccion = $this->conex->real_escape_string(strip_tags(strtoupper($direccion),ENT_QUOTES));
        $fecha_registro = $this->conex->real_escape_string(strip_tags($fecha_registro,ENT_QUOTES));
        $this->error = "";

        $select = "SELECT id FROM cliente WHERE documento = '".$predocumento.$documento."' ";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){
            $this->error = "Este cliente ya se encuentra registrado.";
            return false;
        }else{
            $insert = "INSERT INTO cliente (cliente, documento, email, telefono1, telefono2, direccion, fecha_registro, estado) VALUES ('$cliente', '".$predocumento.$documento."', '$email', '$telefono1', '$telefono2', '$direccion', '$fecha_registro', 1)";
            if($this->conex->query($insert)){
                return true;
            }else{
                $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
                return false;
            }
        }
    }

    function obtener_clientes(){
        $select = "SELECT * FROM cliente WHERE estado <> 2 ORDER BY id ASC";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){ 
            $this->array = $sql_select;
            return true;
        }else{
            return false;
        }
    }

    function obtener_cliente_by_id($id){
        $id = $this->conex->real_escape_string(strip_tags(strtolower($id),ENT_QUOTES));

        $select = "SELECT * FROM cliente WHERE id = $id ";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){
            $datos = $sql_select->fetch_assoc();
            $this->id = $datos['id'];
            $this->cliente = $datos['cliente'];
            $this->predocumento = substr($datos['documento'],0 ,1);
            $this->documento = $datos['documento'];
            $this->email = $datos['email'];
            $this->telefono1 = $datos['telefono1'];
            $this->telefono2 = $datos['telefono2'];
            $this->direccion = $datos['direccion'];
            $this->fecha_registro = date("d-m-Y", strtotime($datos['fecha_registro']));
            $this->estado = $datos['estado'];
            return true;
        }else{
            return false;
        }
    }

    function obtener_cliente_by_documento($documento){
        $documento = $this->conex->real_escape_string(strip_tags(strtolower($documento),ENT_QUOTES));

        $select = "SELECT * FROM cliente WHERE LOWER(documento) = '".strtolower($documento)."' ";
        $sql_select = $this->conex->query($select);
        if($sql_select->num_rows > 0){
            $datos = $sql_select->fetch_assoc();
            $this->id = $datos['id'];
            $this->cliente = $datos['cliente'];
            $this->documento = $datos['documento'];
            $this->email = $datos['email'];
            $this->telefono1 = $datos['telefono1'];
            $this->telefono2 = $datos['telefono2'];
            $this->direccion = $datos['direccion'];
            $this->fecha_registro = date("d-m-Y", strtotime($datos['fecha_registro']));
            $this->estado = $datos['estado'];
            return true;
        }else{
            return false;
        }
    }

    function editar_cliente($id, $cliente, $predocumento, $documento, $email, $telefono1, $telefono2, $direccion){
        $id = $this->conex->real_escape_string(strip_tags($id,ENT_QUOTES));
        $cliente = $this->conex->real_escape_string(strip_tags(strtoupper($cliente),ENT_QUOTES));
        $predocumento = $this->conex->real_escape_string(strip_tags(strtoupper($predocumento),ENT_QUOTES));
        $documento = $this->conex->real_escape_string(strip_tags($documento,ENT_QUOTES));
        $email = $this->conex->real_escape_string(strip_tags(strtoupper($email),ENT_QUOTES));
        $telefono1 = $this->conex->real_escape_string(strip_tags($telefono1,ENT_QUOTES));
        $telefono2 = $this->conex->real_escape_string(strip_tags($telefono2,ENT_QUOTES));
        $direccion = $this->conex->real_escape_string(strip_tags(strtoupper($direccion),ENT_QUOTES));

        $update = "UPDATE cliente SET cliente = '$cliente', documento = '".$predocumento.$documento."', email = '$email', telefono1 = '$telefono1', telefono2 = '$telefono2', direccion = '$direccion' WHERE id = $id";
        if($this->conex->query($update)){
            return true;
        }else{
            $this->error = "Ha ocurrido un problema al intentar guardar los datos.";
            return false;
        }
    }
       










}
?>