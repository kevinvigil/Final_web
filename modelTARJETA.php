<?php

class modelTARJETA{
    private $db;

    function __construct(){
        $this->db = new PDO('mysql:host=...;'.'dbname=...;charset=utf8', 'root', '');
    }
    
    // ejercicio 1
    function addTarjeta ($fecha_alta, $nro_tarjeta,$fecha_vencimiento,$tipo_tarjeta, $id_cliente){
        $sentencia = $this->db->prepare( "INSERT INTO ACTIVIDAD(fecha_alta, nro_tarjeta,fecha_vencimiento,tipo_tarjeta, id_cliente) VALUES(?,?,?,?,?)");
        $sentencia->execute(array($fecha_alta, $nro_tarjeta,$fecha_vencimiento,$tipo_tarjeta, $id_cliente));
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    // ejercicio 2
    function tarjetasAsociadas($id_cliente){
        $sentencia = $this->db->prepare( "SELECT * FROM TARJETA where id_cliente = ?");
        $sentencia->execute(array($id_cliente));
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }

    // ejercicio 4
    function deleteTarjeta($id){
        $sentencia = $this->db->prepare("DELETE FROM categoria where id=?");    
        $sentencia->execute(array($id)); 
    }

    // ejercicio 4
    function taretasByID($id){
        $sentencia = $this->db->prepare( "SELECT * FROM TARJETA where id = ?");
        $sentencia->execute(array($id));
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }
}