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

$tipo = $_GET['tipo'] ?? '';

// Instanciar clases
$objApi = new Api();
$objClient = new Cliente();

// Variables de token
$token = $_REQUEST['token'] ?? '';

/**
 * Endpoint: Obtener todos los hoteles
 * Método: GET
 * URL: apiController.php?tipo=verTodosHoteles&token=xxx-xxx-xxx
 */

if ($tipo == "verTodosHoteles") {
    $token_arr = explode("-", $token);
    $id_cliente = $token_arr[2] ?? 0;
    
    $arr_Cliente = $objClient->buscarClienteById($id_cliente);
    
    if ($arr_Cliente && $arr_Cliente->estado) {
        $arr_hoteles = $objApi->obtenerTodosHoteles();
        
        $arr_Respuesta = array(
            'status' => true,
            'msg' => 'Hoteles obtenidos exitosamente',
            'contenido' => $arr_hoteles
        );
    } else {
        $arr_Respuesta = array(
            'status' => false,
            'msg' => 'Error, cliente no activo o token inválido.'
        );
    }
    
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    die();
}

/**
 * Endpoint: Buscar hoteles por nombre o ubicación
 * Método: POST
 * URL: apiController.php?tipo=buscarHotelesPorNombre&token=xxx-xxx-xxx
 * Body: { "termino": "Madrid" }
 */
if ($tipo == "buscarHotelesPorNombre") {
    $token_arr = explode("-", $token);
    $id_cliente = $token_arr[2] ?? 0;
    
    $arr_Cliente = $objClient->buscarClienteById($id_cliente);
    
    if ($arr_Cliente && $arr_Cliente->estado) {
        // Leer datos POST JSON
        $input = json_decode(file_get_contents('php://input'), true);
        $termino = $input['termino'] ?? $_POST['termino'] ?? '';
        
        if (empty($termino)) {
            $arr_Respuesta = array(
                'status' => false,
                'msg' => 'El parámetro "termino" es requerido.'
            );
        } else {
            $arr_hoteles = $objApi->buscarHotelesPorNombre($termino);
            
            $arr_Respuesta = array(
                'status' => true,
                'msg' => 'Búsqueda realizada exitosamente',
                'contenido' => $arr_hoteles,
                'total' => count($arr_hoteles)
            );
        }
    } else {
        $arr_Respuesta = array(
            'status' => false,
            'msg' => 'Error, cliente no activo o token inválido.'
        );
    }
    
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    die();
}

/**
 * Endpoint: Buscar habitaciones por tipo
 * Método: POST
 * URL: apiController.php?tipo=buscarHabitacionesPorTipo&token=xxx-xxx-xxx
 * Body: { "tipo_habitacion": "suite" }
 */
if ($tipo == "buscarHabitacionesPorTipo") {
    $token_arr = explode("-", $token);
    $id_cliente = $token_arr[2] ?? 0;
    
    $arr_Cliente = $objClient->buscarClienteById($id_cliente);
    
    if ($arr_Cliente && $arr_Cliente->estado) {
        $input = json_decode(file_get_contents('php://input'), true);
        $tipo_habitacion = $input['tipo_habitacion'] ?? $_POST['tipo_habitacion'] ?? '';
        
        if (empty($tipo_habitacion)) {
            $arr_Respuesta = array(
                'status' => false,
                'msg' => 'El parámetro "tipo_habitacion" es requerido.'
            );
        } else {
            $arr_habitaciones = $objApi->buscarHabitacionesPorTipo($tipo_habitacion);
            
            $arr_Respuesta = array(
                'status' => true,
                'msg' => 'Búsqueda de habitaciones realizada exitosamente',
                'contenido' => $arr_habitaciones,
                'total' => count($arr_habitaciones)
            );
        }
    } else {
        $arr_Respuesta = array(
            'status' => false,
            'msg' => 'Error, cliente no activo o token inválido.'
        );
    }
    
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    die();
}

/**
 * Endpoint: Obtener hotel por ID con sus habitaciones
 * Método: GET
 * URL: apiController.php?tipo=verHotelPorId&token=xxx-xxx-xxx&hotel_id=1
 */
if ($tipo == "verHotelPorId") {
    $token_arr = explode("-", $token);
    $id_cliente = $token_arr[2] ?? 0;
    
    $arr_Cliente = $objClient->buscarClienteById($id_cliente);
    
    if ($arr_Cliente && $arr_Cliente->estado) {
        $hotel_id = $_GET['hotel_id'] ?? 0;
        
        if ($hotel_id == 0) {
            $arr_Respuesta = array(
                'status' => false,
                'msg' => 'El parámetro "hotel_id" es requerido.'
            );
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
                $arr_Respuesta = array(
                    'status' => false,
                    'msg' => 'Hotel no encontrado.'
                );
            }
        }
    } else {
        $arr_Respuesta = array(
            'status' => false,
            'msg' => 'Error, cliente no activo o token inválido.'
        );
    }
    
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    die();
}

/**
 * Endpoint: Búsqueda combinada (nombre de hotel + tipo de habitación)
 * Método: POST
 * URL: apiController.php?tipo=verHotelesApiByNombreHabitacion&token=xxx-xxx-xxx
 * Body: { "nombre": "Hotel", "habitaciones": "suite" }
 */
if ($tipo == "verHotelesApiByNombreHabitacion") {
    $token_arr = explode("-", $token);
    $id_cliente = $token_arr[2] ?? 0;
    
    $arr_Cliente = $objClient->buscarClienteById($id_cliente);
    
    if ($arr_Cliente && $arr_Cliente->estado) {
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
    } else {
        $arr_Respuesta = array(
            'status' => false,
            'msg' => 'Error, cliente no activo o token inválido.'
        );
    }
    
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    die();
}

/**
 * Endpoint: Obtener servicios disponibles
 * Método: GET
 * URL: apiController.php?tipo=verServicios&token=xxx-xxx-xxx
 */
if ($tipo == "verServicios") {
    $token_arr = explode("-", $token);
    $id_cliente = $token_arr[2] ?? 0;
    
    $arr_Cliente = $objClient->buscarClienteById($id_cliente);
    
    if ($arr_Cliente && $arr_Cliente->estado) {
        $arr_servicios = $objApi->obtenerServicios();
        
        $arr_Respuesta = array(
            'status' => true,
            'msg' => 'Servicios obtenidos exitosamente',
            'contenido' => $arr_servicios
        );
    } else {
        $arr_Respuesta = array(
            'status' => false,
            'msg' => 'Error, cliente no activo o token inválido.'
        );
    }
    
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    die();
}

// Si no coincide ningún tipo
$arr_Respuesta = array(
    'status' => false,
    'msg' => 'Endpoint no encontrado o tipo de petición inválido.'
);

echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
?>