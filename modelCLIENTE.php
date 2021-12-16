<?php

class modelCLIENTE{

    private $db;

    function __construct(){
        $this->db = new PDO('mysql:host=...;'.'dbname=...;charset=utf8', 'root', '');
    }

    // ejercicio 1 y 2
    function getClienteByDNI($dni){
        $sentencia = $this->db->prepare( "SELECT * FROM CLIENTE where dni = ?");
        $sentencia->execute(array($dni));
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    // ejercicio 1
    function getClienteById($id){
        $sentencia = $this->db->prepare( "SELECT * FROM CLIENTE where id = ?");
        $sentencia->execute(array($id));
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }

    // ejercicio 1
    function addCliente($nombre, $dni, $telefono, $direccion,$ejecutivo){
        $sentencia = $this->db->prepare( "INSERT INTO CLIENTE(nombre, dni, telefono, direccion,ejecutivo) VALUES(?,?,?,?,?)");
        $sentencia->execute(array($nombre, $dni, $telefono, $direccion,$ejecutivo));
        $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $this->db->lastInsertId();
    }
}