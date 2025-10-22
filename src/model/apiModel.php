<?php
require_once "../library/conexion.php";

class Api{
    private $conexion;
    function __construct(){
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }

// Buscar hoteles combinando nombre + tipo de habitación
public function buscarHotelesNombreHabitacion($nombre, $habitaciones)
{
    $nombre = $this->conexion->real_escape_string($nombre);
    $habitaciones = $this->conexion->real_escape_string($habitaciones);

    $sql = $this->conexion->query(" SELECT * FROM hoteles WHERE nombre LIKE '%$nombre%' AND habitaciones LIKE '%$habitaciones%' ");

    $resultado = [];
    while ($row = $sql->fetch_object()) {
        $resultado[] = $row;
    }
    return $resultado;
}




}