<?php
require_once "../library/conexion.php";

class HabitacionModel
{

    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }

    public function registrarHabitacion($id_hotel,$tipo,$capacidad,$precioNoche,$moneda,$fecha,$cantidad)
    {
        $sql = $this->conexion->query("INSERT INTO habitaciones (hotel_id,tipo,capacidad,precio_noche,moneda,fecha,cantidad_disponible) VALUES ('$id_hotel','$tipo','$capacidad','$precioNoche','$moneda','$fecha','$cantidad')");
        if ($sql) {
            $sql = $this->conexion->insert_id;
        } else {
            $sql = 0;
        }
        return $sql;
    }
    public function eliminarHabitacion($idHabitacion)
    {
        $sql = $this->conexion->prepare("DELETE FROM habitaciones WHERE id=?");
        $sql->bind_param('i',$idHabitacion);
        $resultado = $sql->execute();
        if ($resultado === false) {
            return false; 
        }
        $filasAfectadas = $sql->affected_rows;
        $sql->close();
         return $filasAfectadas > 0;
    }
    public function listarHabitacionesByHotel($idHotel){
        $arrRespuesta = array();
        $sql = $this->conexion->query("SELECT * FROM habitaciones WHERE hotel_id ='$idHotel'");
        while ($objeto = $sql->fetch_object()) {
            array_push($arrRespuesta, $objeto);
        }
        return $arrRespuesta;
    }
    public function buscarHabitacionById($id)
    {
        $sql = $this->conexion->query("SELECT * FROM habitaciones WHERE id='$id'");
        $sql = $sql->fetch_object();
        return $sql;
    }
   public function actualizarHabitacion($id_habitacion,$tipo,$capacidad,$precioNoche,$moneda,$fecha,$cantidad)
    {
        $sql = $this->conexion->query("UPDATE habitaciones SET tipo='$tipo',capacidad='$capacidad',precio_noche='$precioNoche',moneda ='$moneda',fecha='$fecha',cantidad_disponible='$cantidad' WHERE id='$id_habitacion'");
        return $sql;
    }
}