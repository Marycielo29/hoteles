<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');

// Manejo de preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once('../model/apiModel.php');
require_once('../model/clienteModel.php');

// Instanciar clases
$objApi = new Api();
$objClient = new Cliente();

$tipo = $_GET['tipo'] ?? '';
$token = $_REQUEST['token'] ?? '';

// ==========================
// 🔒 VALIDAR TOKEN GLOBALMENTE
// ==========================
$tokenn = explode("-", $token);
if ($tokenn[2] == '' || count($tokenn) < 3) {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Acceso no autorizado - token inválido');
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    exit;
}

$id_cliente = $tokenn[2];

// Validar estado del cliente
$estadoCliente = $objApi->validarEstadoCliente($id_cliente);
if ($estadoCliente != 1) {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Cliente API inactivo');
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    exit;
}

// Validar token activo
$validarClienteToken = $objApi->validarClienteToken($id_cliente, $token);
if (!$validarClienteToken) {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Acceso no autorizado - token inactivo o inválido');
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    exit;
}

// ===========================================
// ✅ DESDE AQUÍ YA PASÓ VALIDACIÓN DE TOKEN
// ===========================================

// Endpoint: Obtener todos los hoteles
if ($tipo == "verTodosHoteles") {
    $arr_hoteles = $objApi->obtenerTodosHoteles();

    $arr_Respuesta = array(
        'status' => true,
        'msg' => 'Hoteles obtenidos exitosamente',
        'contenido' => $arr_hoteles
    );

    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    exit;
}

// Endpoint: Buscar hoteles por nombre o ubicación
if ($tipo == "buscarHotelesPorNombre") {
    $input = json_decode(file_get_contents('php://input'), true);
    $termino = $input['termino'] ?? $_POST['termino'] ?? '';

    if (empty($termino)) {
        $arr_Respuesta = array('status' => false, 'msg' => 'El parámetro "termino" es requerido.');
    } else {
        $arr_hoteles = $objApi->buscarHotelesPorNombre($termino);
        $arr_Respuesta = array(
            'status' => true,
            'msg' => 'Búsqueda realizada exitosamente',
            'contenido' => $arr_hoteles,
            'total' => count($arr_hoteles)
        );
    }

    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    exit;
}

// Endpoint: Buscar habitaciones por tipo
if ($tipo == "buscarHabitacionesPorTipo") {
    $input = json_decode(file_get_contents('php://input'), true);
    $tipo_habitacion = $input['tipo_habitacion'] ?? $_POST['tipo_habitacion'] ?? '';

    if (empty($tipo_habitacion)) {
        $arr_Respuesta = array('status' => false, 'msg' => 'El parámetro "tipo_habitacion" es requerido.');
    } else {
        $arr_habitaciones = $objApi->buscarHabitacionesPorTipo($tipo_habitacion);
        $arr_Respuesta = array(
            'status' => true,
            'msg' => 'Búsqueda de habitaciones realizada exitosamente',
            'contenido' => $arr_habitaciones,
            'total' => count($arr_habitaciones)
        );
    }

    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    exit;
}

// Endpoint: Obtener hotel por ID con sus habitaciones
if ($tipo == "verHotelPorId") {
    $hotel_id = $_GET['hotel_id'] ?? 0;

    if ($hotel_id == 0) {
        $arr_Respuesta = array('status' => false, 'msg' => 'El parámetro "hotel_id" es requerido.');
    } else {
        $hotel = $objApi->obtenerHotelPorId($hotel_id);
        $habitaciones = $objApi->obtenerHabitacionesPorHotel($hotel_id);

        if ($hotel) {
            $arr_Respuesta = array(
                'status' => true,
                'msg' => 'Hotel obtenido exitosamente',
                'contenido' => array(
                    'hotel' => $hotel,
                    'habitaciones' => $habitaciones
                )
            );
        } else {
            $arr_Respuesta = array('status' => false, 'msg' => 'Hotel no encontrado.');
        }
    }

    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    exit;
}

// Endpoint: Búsqueda combinada (nombre + tipo de habitación)
if ($tipo == "verHotelesApiByNombreHabitacion") {
    $input = json_decode(file_get_contents('php://input'), true);
    $nombre = $input['nombre'] ?? $_POST['nombre'] ?? '';
    $habitaciones = $input['habitaciones'] ?? $_POST['habitaciones'] ?? '';

    $arr_hoteles = $objApi->buscarHotelesNombreHabitacion($nombre, $habitaciones);
    $arr_Respuesta = array(
        'status' => true,
        'msg' => 'Búsqueda combinada realizada exitosamente',
        'contenido' => $arr_hoteles,
        'total' => count($arr_hoteles)
    );

    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    exit;
}

// Endpoint: Obtener servicios
if ($tipo == "verServicios") {
    $arr_servicios = $objApi->obtenerServicios();

    $arr_Respuesta = array(
        'status' => true,
        'msg' => 'Servicios obtenidos exitosamente',
        'contenido' => $arr_servicios
    );

    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    exit;
}

// Si no coincide ningún tipo
$arr_Respuesta = array(
    'status' => false,
    'msg' => 'Endpoint no encontrado o tipo de petición inválido.'
);
echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
?>
