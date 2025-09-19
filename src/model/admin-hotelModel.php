<?php
require_once "../library/conexion.php";

class HotelModel
{

    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }

    public function registrarHotel($nombre,$descripcion,$direccion,$ciudad,$categoria,$telefono,$email)
    {
        $sql = $this->conexion->query("INSERT INTO hoteles (nombre,descripcion,direccion,ciudad,categoria,telefono,email_contacto) VALUES ('$nombre','$descripcion','$direccion','$ciudad','$categoria','$telefono','$email')");
        if ($sql) {
            $sql = $this->conexion->insert_id;
        } else {
            $sql = 0;
        }
        return $sql;
    }
    //eliminar hotel estructura
    public function eliminarUsuario($idUser)
    {
        $sql = $this->conexion->prepare("DELETE FROM usuarios WHERE id=?");
        $sql->bind_param('i',$idUser);
        $resultado = $sql->execute();
        if ($resultado === false) {
            return false; 
        }
        $filasAfectadas = $sql->affected_rows;
        $sql->close();
         return $filasAfectadas > 0;
    }
    public function listarHoteles(){
        $arrRespuesta = array();
        $sql = $this->conexion->query("SELECT * FROM hoteles");
        while ($objeto = $sql->fetch_object()) {
            array_push($arrRespuesta, $objeto);
        }
        return $arrRespuesta;
    }
    public function buscarHotelById($id)
    {
        $sql = $this->conexion->query("SELECT * FROM hoteles WHERE hotel_id='$id'");
        $sql = $sql->fetch_object();
        return $sql;
    }
   public function actualizarHotel($idHotel,$nombre,$ciudad,$categoria,$direccion,$telefono,$correo,$descripcion)
    {
        $sql = $this->conexion->query("UPDATE hoteles SET nombre='$nombre',descripcion='$descripcion',direccion='$direccion',ciudad ='$ciudad',categoria='$categoria',telefono='$telefono',email_contacto='$correo' WHERE hotel_id='$idHotel'");
        return $sql;
    }
}