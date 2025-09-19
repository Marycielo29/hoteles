<?php
require_once "../library/conexion.php";

class Client {
    private $conn;
    private $table = "Client_API";

    public $id;
    public $ruc;
    public $razon_social;
    public $telefono;
    public $correo;
    public $fecha_registro;
    public $estado;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Listar todos
    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener por ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                 (ruc, razon_social, telefono, correo, fecha_registro, estado) 
                 VALUES (:ruc, :razon_social, :telefono, :correo, :fecha_registro, :estado)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':ruc' => $this->ruc,
            ':razon_social' => $this->razon_social,
            ':telefono' => $this->telefono,
            ':correo' => $this->correo,
            ':fecha_registro' => $this->fecha_registro,
            ':estado' => $this->estado
        ]);
    }

    // Actualizar
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET ruc = :ruc, razon_social = :razon_social, telefono = :telefono, 
                      correo = :correo, estado = :estado
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':ruc' => $this->ruc,
            ':razon_social' => $this->razon_social,
            ':telefono' => $this->telefono,
            ':correo' => $this->correo,
            ':estado' => $this->estado,
            ':id' => $this->id
        ]);
    }
}
