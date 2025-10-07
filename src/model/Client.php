<?php
require_once "../library/conexion.php";

class Client{
    private $conexion;
    function __construct(){
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }

        public function registrarClienteApi($ruc,$razon_social,$telefono,$correo)
    {
        $sql = $this->conexion->query("INSERT INTO client_api (ruc,razon_social,telefono,correo) VALUES ('$ruc','$razon_social','$telefono','$correo')");
        if ($sql) {
            $sql = $this->conexion->insert_id;
        } else {
            $sql = 0;
        }
        return $sql;
    }
    public function listarClientes(){
        $arrRespuesta = array();
        $sql = $this->conexion->query("SELECT * FROM client_api");
        while ($objeto = $sql->fetch_object()) {
            array_push($arrRespuesta, $objeto);
        }
        return $arrRespuesta;
    }
    public function buscarClienteById($id)
    {
        $sql = $this->conexion->query("SELECT * FROM client_api WHERE id='$id'");
        $sql = $sql->fetch_object();
        return $sql;
    }
   public function actualizarCliente($id_cliente,$ruc,$razon,$telefono,$correo,$estado)
    {
        $sql = $this->conexion->query("UPDATE client_api SET ruc='$ruc',razon_social='$razon',telefono='$telefono',correo ='$correo',estado='$estado' WHERE id='$id_cliente'");
        return $sql;
    }

    // busqueda api

     public function buscarHotelesNombre($data)
    {
        $sql = $this->conexion->query("SELECT * FROM hoteles WHERE id='$id'");
        $sql = $sql->fetch_object();
        return $sql;
    }

}
