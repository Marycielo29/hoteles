<?php

// DEBUG TEMPORAL - habilitar solo mientras investigas en el servidor
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/api_error.log'); // revisa este archivo en cPanel

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json; charset=utf-8');

// Manejo de preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Manejo global de excepciones/fatal errors para devolver JSON
set_exception_handler(function($e){
    error_log("Uncaught exception: " . $e->getMessage() . "\n" . $e->getTraceAsString());
    http_response_code(500);
    echo json_encode(['status' => false, 'mensaje' => 'Error interno del servidor (exception)', 'detalle' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
    exit;
});
register_shutdown_function(function(){
    $err = error_get_last();
    if ($err !== null) {
        error_log("Shutdown error: " . print_r($err, true));
        http_response_code(500);
        echo json_encode(['status' => false, 'mensaje' => 'Error fatal en ejecución', 'detalle' => $err['message']], JSON_UNESCAPED_UNICODE);
    }
});

try {
    // Asegurarse de que el archivo exista
    $modelPath = __DIR__ . '/../model/apiModel.php';
    if (!file_exists($modelPath)) {
        error_log("Archivo model no encontrado: $modelPath");
        http_response_code(500);
        echo json_encode(['status' => false, 'mensaje' => 'Error del servidor: model no encontrado.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    require_once($modelPath);

    $tipo = $_GET['tipo'] ?? '';

    // Instanciar clases
    $objApi = new Api();

    // Token (acepta GET o POST)
    $token = $_REQUEST['token'] ?? '';
    if (empty($token)) {
        echo json_encode(['status' => false, 'mensaje' => 'Error, token no proporcionado.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Validar formato del token antes de usar índices
    $tokenn = explode("-", $token);
    if (count($tokenn) < 3) {
        // Registrar por si el token no tiene el formato esperado
        error_log("Token con formato inválido: " . $token);
        echo json_encode(['status' => false, 'mensaje' => 'Error, token con formato inválido.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Obtener id_cliente con validación
    $id_cliente = intval($tokenn[2]);

    // VALIDACION DE TOKEN - envolver en try por si el model lanza excepciones
    $arr_token = $objApi->buscarToken($token, $id_cliente);
    if (!$arr_token) {
        echo json_encode(['status' => false, 'mensaje' => 'Error, token inválido.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Si la función devuelve un objeto, validar la propiedad estado de forma segura
    if (!isset($arr_token->estado) || intval($arr_token->estado) !== 1) {
        echo json_encode(['status' => false, 'mensaje' => 'Error, el token no está activo.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Buscar cliente, validar resultado
    $arr_cliente = $objApi->buscarClienteById($id_cliente);
    if (!$arr_cliente || !isset($arr_cliente->estado)) {
        error_log("buscarClienteById devolvió vacío o no tiene propiedad estado. id_cliente: $id_cliente");
        echo json_encode(['status' => false, 'mensaje' => 'Error, cliente no encontrado o inválido.'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    if (intval($arr_cliente->estado) !== 1) {
        echo json_encode(['status' => false, 'mensaje' => 'Error, el cliente no está activo.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Rutas / Endpoints
    if ($tipo === "verTodosHoteles") {
        // envolver la obtención en try por si la query falla
        try {
            $arr_hoteles = $objApi->obtenerTodosHoteles();
        } catch (Throwable $t) {
            error_log("Error en obtenerTodosHoteles: " . $t->getMessage() . "\n" . $t->getTraceAsString());
            echo json_encode(['status' => false, 'mensaje' => 'Error al obtener hoteles.', 'detalle' => $t->getMessage()], JSON_UNESCAPED_UNICODE);
            exit;
        }

        if ($arr_hoteles && count($arr_hoteles) > 0) {
            $arr_Respuesta = [
                'status' => true,
                'mensaje' => 'Hoteles obtenidos exitosamente',
                'contenido' => $arr_hoteles
            ];
        } else {
            $arr_Respuesta = [
                'status' => false,
                'mensaje' => 'No se encontraron hoteles.'
            ];
        }
        echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
        exit;
    }

   if ($tipo == "buscarHotelesPorNombre") {
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
                'mensaje' => 'Búsqueda realizada exitosamente',
                'contenido' => $arr_hoteles,
                'total' => count($arr_hoteles)
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
/* if ($tipo == "buscarHabitacionesPorTipo") {
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
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    die();
} */

/**
 * Endpoint: Obtener hotel por ID con sus habitaciones
 * Método: GET
 * URL: apiController.php?tipo=verHotelPorId&token=xxx-xxx-xxx&hotel_id=1
 */
/* if ($tipo == "verHotelPorId") {
        $hotel_id = $_GET['hotel_id'] ?? 0;
        
        if ($hotel_id == 0) {
            $arr_Respuesta = array(
                'status' => false,
                'mensaje' => 'El parámetro "hotel_id" es requerido.'
            );
        } else {
            $hotel = $objApi->obtenerHotelPorId($hotel_id);
            $habitaciones = $objApi->obtenerHabitacionesPorHotel($hotel_id);
            
            if ($hotel) {
                $arr_Respuesta = array(
                    'status' => true,
                    'mensaje' => 'Hotel obtenido exitosamente',
                    'contenido' => array(
                        'hotel' => $hotel,
                        'habitaciones' => $habitaciones
                    )
                );
            } else {
                $arr_Respuesta = array(
                    'status' => false,
                    'mensaje' => 'Hotel no encontrado.'
                );
            }
        }   
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    die();
} */

/**
 * Endpoint: Búsqueda combinada (nombre de hotel + tipo de habitación)
 * Método: POST
 * URL: apiController.php?tipo=verHotelesApiByNombreHabitacion&token=xxx-xxx-xxx
 * Body: { "nombre": "Hotel", "habitaciones": "suite" }
 */
/* if ($tipo == "verHotelesApiByNombreHabitacion") {
        $input = json_decode(file_get_contents('php://input'), true);
        $nombre = $input['nombre'] ?? $_POST['nombre'] ?? '';
        $habitaciones = $input['habitaciones'] ?? $_POST['habitaciones'] ?? '';
        
        $arr_hoteles = $objApi->buscarHotelesNombreHabitacion($nombre, $habitaciones);
        $arr_Respuesta = array(
            'status' => true,
            'mensaje' => 'Búsqueda combinada realizada exitosamente',
            'contenido' => $arr_hoteles,
            'total' => count($arr_hoteles)
        );
  
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    die();
} */

/**
 * Endpoint: Obtener servicios disponibles
 * Método: GET
 * URL: apiController.php?tipo=verServicios&token=xxx-xxx-xxx
 */
/* if ($tipo == "verServicios") {
        $arr_servicios = $objApi->obtenerServicios();
        
        $arr_Respuesta = array(
            'status' => true,
            'mensaje' => 'Servicios obtenidos exitosamente',
            'contenido' => $arr_servicios
        );  
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    die();
} */



    // Si llega aquí: tipo no reconocido
    echo json_encode(['status' => false, 'mensaje' => 'Endpoint no reconocido.'], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    // Registro adicional por si algo falla
    error_log("Catch global: " . $e->getMessage() . "\n" . $e->getTraceAsString());
    http_response_code(500);
    echo json_encode(['status' => false, 'mensaje' => 'Error interno del servidor (catch)', 'detalle' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
    exit;
}

/* header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
require_once('../model/apiModel.php');

$tipo = $_GET['tipo'] ?? '';


$objApi = new Api();


$token = $_REQUEST['token'] ?? '';

$tokenn = explode("-", $token);
$id_cliente = $tokenn[2] ?? 0;

$arr_token = $objApi->buscarToken($token, $id_cliente);
if(!$arr_token){
    $arr_Respuesta = array(
        'status' => false,
        'mensaje' => 'Error, token inválido.'
    );
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    die();
}else{
    if($arr_token->estado != 1){
        $arr_Respuesta = array(
            'status' => false,
            'mensaje' => 'Error, el token no está activo.'
        );
        echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }
}

$arr_cliente = $objApi->buscarClienteById($id_cliente);
   if($arr_cliente->estado != 1){
       $arr_Respuesta = array(
           'status' => false,
           'mensaje' => 'Error, el cliente no está activo.'
       );
       echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
       die();
   }


if ($tipo == "verTodosHoteles") {
        $arr_hoteles = $objApi->obtenerTodosHoteles();
        if($arr_hoteles){
        $arr_Respuesta = array(
            'status' => true,
            'mensaje' => 'Hoteles obtenidos exitosamente',
            'contenido' => $arr_hoteles
        );
        }else{
            $arr_Respuesta = array(
                'status' => false,
                'mensaje' => 'No se encontraron hoteles.'
            );
        }
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    die();
} */

/**
 * Endpoint: Buscar hoteles por nombre o ubicación
 * Método: POST
 * URL: apiController.php?tipo=buscarHotelesPorNombre&token=xxx-xxx-xxx
 * Body: { "termino": "Madrid" }
 */
if ($tipo == "buscarHotelesPorNombre") {
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
                'mensaje' => 'Búsqueda realizada exitosamente',
                'contenido' => $arr_hoteles,
                'total' => count($arr_hoteles)
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
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    die();
}

/**
 * Endpoint: Obtener hotel por ID con sus habitaciones
 * Método: GET
 * URL: apiController.php?tipo=verHotelPorId&token=xxx-xxx-xxx&hotel_id=1
 */
if ($tipo == "verHotelPorId") {
        $hotel_id = $_GET['hotel_id'] ?? 0;
        
        if ($hotel_id == 0) {
            $arr_Respuesta = array(
                'status' => false,
                'mensaje' => 'El parámetro "hotel_id" es requerido.'
            );
        } else {
            $hotel = $objApi->obtenerHotelPorId($hotel_id);
            $habitaciones = $objApi->obtenerHabitacionesPorHotel($hotel_id);
            
            if ($hotel) {
                $arr_Respuesta = array(
                    'status' => true,
                    'mensaje' => 'Hotel obtenido exitosamente',
                    'contenido' => array(
                        'hotel' => $hotel,
                        'habitaciones' => $habitaciones
                    )
                );
            } else {
                $arr_Respuesta = array(
                    'status' => false,
                    'mensaje' => 'Hotel no encontrado.'
                );
            }
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
        $input = json_decode(file_get_contents('php://input'), true);
        $nombre = $input['nombre'] ?? $_POST['nombre'] ?? '';
        $habitaciones = $input['habitaciones'] ?? $_POST['habitaciones'] ?? '';
        
        $arr_hoteles = $objApi->buscarHotelesNombreHabitacion($nombre, $habitaciones);
        $arr_Respuesta = array(
            'status' => true,
            'mensaje' => 'Búsqueda combinada realizada exitosamente',
            'contenido' => $arr_hoteles,
            'total' => count($arr_hoteles)
        );
  
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    die();
}

/**
 * Endpoint: Obtener servicios disponibles
 * Método: GET
 * URL: apiController.php?tipo=verServicios&token=xxx-xxx-xxx
 */
if ($tipo == "verServicios") {
        $arr_servicios = $objApi->obtenerServicios();
        
        $arr_Respuesta = array(
            'status' => true,
            'mensaje' => 'Servicios obtenidos exitosamente',
            'contenido' => $arr_servicios
        );  
    echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
    die();
}

// Si no coincide ningún tipo
$arr_Respuesta = array(
    'status' => false,
    'mensaje' => 'Endpoint no encontrado o tipo de petición inválido.'
);

echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
?>