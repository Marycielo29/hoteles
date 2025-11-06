<?php
require_once "../library/conexion.php";

class TokenApiModel {
    private $conexion;
    public function __construct() {
        $this->conexion = (new Conexion())->connect();
    }

    public function listarTokens() {
        $arr = [];
        $sql = $this->conexion->query("SELECT token FROM token_api");
        while ($row = $sql->fetch_object()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function actualizarToken($nuevoToken) {
        $sql = $this->conexion->query("UPDATE token_api SET token = '$nuevoToken'");
        return $sql ? true : false;
    }
}





