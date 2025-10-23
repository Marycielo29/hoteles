<?php
require_once "../library/conexion.php";

class Cliente {
    private $conexion;
    
    function __construct() {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }
    
    /**
     * Buscar cliente por ID para validación de token
     */
    public function buscarClienteById($id_cliente) {
        $stmt = $this->conexion->prepare("
            SELECT 
                id,
                ruc,
                razon_social,
                telefono,
                correo,
                estado,
                fecha_registro
            FROM Client_API
            WHERE id = ?
        ");
        
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($cliente = $result->fetch_object()) {
            return $cliente;
        }
        
        return null;
    }
    
    /**
     * Validar token completo
     */
    public function validarToken($token) {
        $token_arr = explode("-", $token);
        
        if (count($token_arr) !== 3) {
            return false;
        }
        
        $id_cliente = $token_arr[2];
        
        $stmt = $this->conexion->prepare("
            SELECT t.id, t.estado, c.estado as cliente_estado
            FROM Tokens t
            INNER JOIN Client_API c ON t.id_client_api = c.id
            WHERE t.token = ? AND c.id = ?
        ");
        
        $stmt->bind_param("si", $token, $id_cliente);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($token_data = $result->fetch_object()) {
            return ($token_data->estado == 1 && $token_data->cliente_estado == 1);
        }
        
        return false;
    }
}
?>