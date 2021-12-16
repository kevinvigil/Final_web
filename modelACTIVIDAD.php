<?php

class modelACTIVIDAD{
    private $db;

    function __construct(){
        $this->db = new PDO('mysql:host=...;'.'dbname=...;charset=utf8', 'root', '');
    }

    // ejercicio 1 y 3
    function addKms($id_cliente,$kms,$fecha,$tipo_operación){
        $sentencia = $this->db->prepare( "INSERT INTO ACTIVIDAD(id_cliente,kms,fecha,tipo_operación) VALUES(?,?,?,?)");
        $sentencia->execute(array($id_cliente,$kms,$fecha,$tipo_operación));
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    // ejercicio 2 y 3
    function actividadClienteId($id_cliente){
        $sentencia = $this->db->prepare( "SELECT * FROM ACTIVIDAD where id_cliente = ?");
        $sentencia->execute(array($id_cliente));
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }

    // ejercicio 4
    function actividadClienteIdYFecha($id_cliente,$fecha1, $fecha2){
        $sentencia = $this->db->prepare( "SELECT * FROM ACTIVIDAD where id_cliente = ? && ...");
        $sentencia->execute(array($id_cliente,$fecha1, $fecha2));
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }
}
