<?php
require_once __DIR__ . '/../models/Client.php';

class ClientController {

    // Listar clientes
    public function index() {
        $client = new Client();
        $stmt = $client->getAll();
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($clients);
    }

    // Obtener cliente por ID
    public function show($id) {
        $client = new Client();
        $data = $client->getById($id);
        echo json_encode($data);
    }

    // Crear cliente
    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        $client = new Client();
        $client->ruc = $data['ruc'];
        $client->razon_social = $data['razon_social'];
        $client->telefono = $data['telefono'];
        $client->correo = $data['correo'];
        $client->fecha_registro = date("Y-m-d H:i:s");
        $client->estado = 1;
        $client->create();
        echo json_encode(["status" => "success"]);
    }

    // Editar cliente
    public function edit($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $client = new Client();
        $client->id = $id;
        $client->ruc = $data['ruc'];
        $client->razon_social = $data['razon_social'];
        $client->telefono = $data['telefono'];
        $client->correo = $data['correo'];
        $client->estado = $data['estado'];
        $client->update();
        echo json_encode(["status" => "updated"]);
    }
}
