<?php
require_once "../library/conexion.php";

class Api{
    private $conexion;
    function __construct(){
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }

     // busqueda api

   public function buscarHotelesNombre($data)
    {
        $sql = $this->conexion->query("SELECT * FROM hoteles WHERE id='$id'");
        $sql = $sql->fetch_object();
        return $sql;
    }
}