<?php
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-servicioModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

// Instanciar las clases
$objSesion = new SessionModel();
$objServicio = new ServicioModel();
$objAdmin = new AdminModel();

// Variables de sesión
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

/**
 * Registrar un nuevo servicio y asociarlo a un hotel
 */
if ($tipo == "registrarServicio") {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        if ($_POST) {
            $idHotel = trim($_POST['id_hotel']);
            $nombre = trim($_POST['nombreServicio']);
            
            if ($idHotel == "" || $nombre == "") {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Campos vacíos');
            } else {
                $id_new_servicio = $objServicio->registrarServicio($idHotel, $nombre);
                
                if ($id_new_servicio > 0) {
                    $arr_Respuesta = array('status' => true, 'mensaje' => 'Registro exitoso');
                } else {
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error en el registro');
                }
            }
        }
    }
    
    echo json_encode($arr_Respuesta);
}

/**
 * Listar servicios de un hotel específico
 */
if ($tipo == "listarServicios") {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $id_hotel = trim($_POST['id_hotel']);
        $arr_servicio = $objServicio->listarServiciosHotel($id_hotel);
        
        if ($arr_servicio && count($arr_servicio) > 0) {
            for ($i = 0; $i < count($arr_servicio); $i++) {
                $id_servicio = $arr_servicio[$i]->servicio_id;
                
                // ⭐ IMPORTANTE: Pasar el hotel_id como segundo parámetro
                $opciones = '
                    <button class="btn btn-warning btn-sm me-1" 
                            data-bs-toggle="modal" 
                            data-bs-target="#actualizarServicio" 
                            onclick="obtenerServicio(' . $id_servicio . ');"
                            title="Editar servicio">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" 
                            onclick="antesEliminarServicio(' . $id_servicio . ', ' . $id_hotel . ');"
                            title="Eliminar servicio del hotel">
                        <i class="bi bi-trash"></i>
                    </button>';
                
                $arr_servicio[$i]->options = $opciones;
            }
            
            $arr_Respuesta['contenido'] = $arr_servicio;
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['mensaje'] = 'ok';
        } else {
            // No hay servicios pero la consulta fue exitosa
            $arr_Respuesta['contenido'] = [];
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['mensaje'] = 'No hay servicios registrados';
        }
    }
    
    echo json_encode($arr_Respuesta);
}

/**
 * Eliminar la asociación servicio-hotel
 */
if ($tipo == "eliminarServicio") {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');

    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        
        if (!isset($_POST['data']) || empty($_POST['data'])) {
            $arr_Respuesta = array('status' => false, 'mensaje' => 'ID de servicio no proporcionado');
        } else {
            $id_servicio = trim($_POST['data']);
            $id_hotel = isset($_POST['id_hotel']) ? trim($_POST['id_hotel']) : null;

            if (!is_numeric($id_servicio) || (int)$id_servicio <= 0) {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'ID de servicio inválido');
            } else {
                $id_servicio = (int)$id_servicio;
                
                // Si se proporciona el hotel, eliminar solo esa relación
                if ($id_hotel !== null && is_numeric($id_hotel)) {
                    $id_hotel = (int)$id_hotel;
                    $eliminar = $objServicio->eliminarServicio($id_servicio, $id_hotel);
                } else {
                    // Si no, eliminar todas las relaciones
                    $eliminar = $objServicio->eliminarServicio($id_servicio);
                }

                if ($eliminar) {
                    $arr_Respuesta = array('status' => true, 'mensaje' => 'Eliminado correctamente');
                } else {
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Fallo al eliminar o el servicio no está asociado a este hotel');
                }
            }
        }
    }

    echo json_encode($arr_Respuesta);
}

/**
 * Obtener información de un servicio por ID
 */
if ($tipo == "obtenerServicio") {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $id_servicio = trim($_POST['data']);
        $arrServicio = $objServicio->buscarServicioById($id_servicio);
        
        if ($arrServicio) {
            $arr_Respuesta['contenido'] = $arrServicio;
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['mensaje'] = 'ok';
        } else {
            $arr_Respuesta['mensaje'] = 'Servicio no encontrado';
        }
    }
    
    echo json_encode($arr_Respuesta);
}

/**
 * Actualizar el nombre de un servicio
 */
if ($tipo == "actualizarServicio") {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        if ($_POST) {
            $id_servicio = trim($_POST['data']);
            $nombre = trim($_POST['n_nombreServicio']);
            
            if ($id_servicio == "" || $nombre == "") {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Campos vacíos');
            } else {
                $actualizar = $objServicio->actualizarServicio($id_servicio, $nombre);
                
                if ($actualizar) {
                    $arr_Respuesta = array('status' => true, 'mensaje' => 'Actualizado correctamente');
                } else {
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error de sistema');
                }
            }
        }
    }
    
    echo json_encode($arr_Respuesta);
}

/**
 * Listar todos los servicios disponibles (globales)
 */
if ($tipo == "listarTodosServicios") {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $arr_servicios = $objServicio->listarTodosServicios();
        
        if ($arr_servicios) {
            $arr_Respuesta['contenido'] = $arr_servicios;
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['mensaje'] = 'ok';
        }
    }
    
    echo json_encode($arr_Respuesta);
}

/**
 * Verificar si un servicio está asociado a un hotel
 */
if ($tipo == "verificarServicioEnHotel") {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $id_servicio = trim($_POST['id_servicio']);
        $id_hotel = trim($_POST['id_hotel']);
        
        $existe = $objServicio->verificarServicioEnHotel($id_servicio, $id_hotel);
        
        $arr_Respuesta['existe'] = $existe;
        $arr_Respuesta['status'] = true;
        $arr_Respuesta['mensaje'] = 'ok';
    }
    
    echo json_encode($arr_Respuesta);
}
?>