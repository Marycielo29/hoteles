<?php
require_once "../library/conexion.php";

class TokenModel{
    private $conexion;
    function __construct(){
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }

    public function generarTokenParaCliente($id_cliente) {
            // Validar que el id_cliente sea un entero positivo
            if (!is_numeric($id_cliente) || $id_cliente <= 0) {
                return false;
            }

            // Generar un token único (puedes ajustar la longitud)
            $token = bin2hex(random_bytes(32)); // 64 caracteres hexadecimales

            // Verificar que no exista otro token activo para el mismo cliente (opcional)
            // Puedes omitir esto si permites múltiples tokens por cliente
            /*
            $queryCheck = "SELECT id FROM tokens WHERE id_client = :id_client AND activo = 1";
            $stmtCheck = $this->conexion->prepare($queryCheck);
            $stmtCheck->bindParam(':id_client', $id_cliente, PDO::PARAM_INT);
            $stmtCheck->execute();
            if ($stmtCheck->rowCount() > 0) {
                // Opcional: desactivar tokens anteriores
                $this->desactivarTokensAnteriores($id_cliente);
            }
            */

            // Insertar el nuevo token
            $sql = $this->conexion->prepare("INSERT INTO tokens (id_client_api, token) 
                      VALUES (?,?)");

           if (!$sql) {
            error_log("Error en la preparación de la consulta: " . $this->conexion->error);
            return false;
            }

        // Vincular parámetros: 'i' = integer, 's' = string
        $sql->bind_param("is", $id_cliente, $token);

        // Ejecutar
        if ($sql->execute()) {
            $sql->close();
            return true;
        } else {
            error_log("Error al ejecutar la inserción del token: " . $sql->error);
            $sql->close();
            return false;
        }
    }

    /**
     * (Opcional) Desactiva todos los tokens anteriores de un cliente
     */
    private function desactivarTokensAnteriores($id_cliente) {
        // Preparar la consulta con marcadores de posición (?)
        $sql = $this->conexion->prepare("UPDATE tokens SET estado = 0 WHERE id_client_api = ?");

        if ($sql) {
            // Vincular el parámetro: 'i' para entero
            $sql->bind_param("i", $id_cliente);
            $sql->execute();
            $sql->close();
        } else {
            error_log("Error al preparar la consulta para desactivar tokens: " . $this->conexion->error);
        }
    }

    public function listarTokens($id_client){
        $array = array();
        $sql = $this->conexion->query("SELECT * FROM tokens WHERE id_client_api='$id_client'");
        while ($objeto = $sql->fetch_object()) {
            array_push($array, $objeto);
        }
        return $array;
    }
    public function actualizarEstadoToken($id_token, $estado){
        if($estado == 1){
            $sql = $this->conexion->query("UPDATE tokens SET estado = 0 WHERE id = $id_token");
        }else if($estado == 0){
          $sql = $this->conexion->query("UPDATE tokens SET estado = 1 WHERE id = $id_token");
        }
        return $sql;
    }


}