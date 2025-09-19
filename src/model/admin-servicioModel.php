<?php
require_once "../library/conexion.php";

class ServicioModel
{

    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }

    public function registrarServicio($id_hotel,$nombre)
    {
        $sql = $this->conexion->query("INSERT INTO servicios (hotel_id,nombre) VALUES ('$id_hotel','$nombre')");
        if ($sql) {
            $sql = $this->conexion->insert_id;
        } else {
            $sql = 0;
        }
        return $sql;
    }
    public function eliminarServicio($id_Servicio)
    {
        $sql = $this->conexion->prepare("DELETE FROM servicios WHERE servicio_id=?");
        $sql->bind_param('i',$id_Servicio);
        $resultado = $sql->execute();
        if ($resultado === false) {
            return false; 
        }
        $filasAfectadas = $sql->affected_rows;
        $sql->close();
         return $filasAfectadas > 0;
    }
    public function listarServiciosHotel($idHotel){
        $arrRespuesta = array();
        $sql = $this->conexion->query("SELECT * FROM servicios WHERE hotel_id ='$idHotel'");
        while ($objeto = $sql->fetch_object()) {
            array_push($arrRespuesta, $objeto);
        }
        return $arrRespuesta;
    }

    public function buscarServicioById($id)
    {
        $sql = $this->conexion->query("SELECT * FROM servicios WHERE servicio_id='$id'");
        $sql = $sql->fetch_object();
        return $sql;
    }

   public function actualizarServicio($id_servicio,$nombre)
    {
        $sql = $this->conexion->query("UPDATE servicios SET nombre='$nombre' WHERE servicio_id='$id_servicio'");
        return $sql;
    }
}