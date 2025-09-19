<?php
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-habitacionModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objHabitacion = new HabitacionModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo == "registrarHabitacion"){
  $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
     if($_POST){
       $idHotel = trim($_POST['id_hotel']);
       $tipo = $_POST['tipoHabitacion'];
       $capacidad = trim($_POST['capacidad']);
       $precioNoche = ucfirst(trim($_POST['precioNoche']));
       $moneda = trim($_POST['moneda']);
       $fecha = trim($_POST['fecha']);
       $cantidad = trim($_POST['cantidad']);
       if($idHotel == ""|| $tipo == "" || $capacidad == ""|| $precioNoche== ""|| $moneda == ""||$fecha == "" || $cantidad == ""){
        $arr_Respuesta = array('status' => false, 'mensaje' => 'Campos vacios');
       }else{
        $id_new_habitacion = $objHabitacion->registrarHabitacion($idHotel,$tipo,$capacidad,$precioNoche,$moneda,$fecha,$cantidad);
        if($id_new_habitacion > 0){
         $arr_Respuesta = array('status' => true, 'mensaje' => 'Registro exitoso');
        }else{
         $arr_Respuesta = array('status' => false, 'mensaje' => 'Error registro');
        }
       }
     }
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "listarHabitaciones"){
  $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $id_hotell = trim($_POST['id_hotel']);
        $arr_habitacion = $objHabitacion->listarHabitacionesByHotel($id_hotell);
        if($arr_habitacion){
           for ($i=0; $i < count($arr_habitacion); $i++) {  
            $id_habitacion = $arr_habitacion[$i]->id;
             $opciones = ' <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#actualizarHabitacion" onclick="obtenerHabitacion('.$id_habitacion.');"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="antesEliminarHabitacion('.$id_habitacion.');"><i class="bi bi-trash"></i></button>';
            $arr_habitacion[$i]->options = $opciones;
            }
           
            $arr_Respuesta['contenido'] = $arr_habitacion;
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['mensaje'] = 'ok';
        }
    }
    echo json_encode($arr_Respuesta);
}

if ($tipo == "eliminarHabitacion") {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');

    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {

        if (!isset($_POST['idHabitacion']) || empty($_POST['idHabitacion'])) {
            $arr_Respuesta = array('status' => false, 'mensaje' => 'ID de usuario no proporcionado');
        } else {
            $id_habitacion = trim($_POST['idHabitacion']);

            if (!is_numeric($id_habitacion) || (int)$id_habitacion <= 0) {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'ID de usuario inválido');
            } else {
                $id_habitacion = (int)$id_habitacion;

                $eliminar = $objHabitacion->eliminarHabitacion($id_habitacion);

                if ($eliminar) {
                    $arr_Respuesta = array('status' => true, 'mensaje' => 'Eliminado Correctamente');
                } else {
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Fallo al eliminar');
                }
            }
        }
    }

    echo json_encode($arr_Respuesta);
}

if($tipo == "obtenerHabitacion"){
      $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
      $id_habitacion = trim($_POST['data']);
      $arrHotel = $objHabitacion->buscarHabitacionById($id_habitacion);
      $arr_Respuesta['contenido'] = $arrHotel;
      $arr_Respuesta['status'] = true;
    }
    echo json_encode($arr_Respuesta);
  }

  if($tipo == "actualizarHabitacion"){
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
       if ($_POST) {
        $id_habitacion = trim($_POST['data']);
       $tipo = $_POST['n_tipoHabitacion'];
       $capacidad = trim($_POST['n_capacidad']);
       $precioNoche = ucfirst(trim($_POST['n_precioNoche']));
       $moneda = trim($_POST['n_moneda']);
       $fecha = trim($_POST['n_fecha']);
       $cantidad = trim($_POST['n_cantidad']);
       if($id_habitacion==""|| $tipo == "" || $capacidad == ""|| $precioNoche== ""|| $moneda == ""||$fecha == "" || $cantidad == ""){
        $arr_Respuesta = array('status' => false, 'mensaje' => 'Campos vacios');
       }else{
         $actualizar = $objHabitacion->actualizarHabitacion($id_habitacion,$tipo,$capacidad,$precioNoche,$moneda,$fecha,$cantidad);
         if($actualizar){
         $arr_Respuesta = array('status' => true, 'mensaje' => 'Actualizazdo correctamente');
         }else{
          $arr_Respuesta = array('status' => false, 'mensaje' => 'Error de sistema');
         }
       }
       }
    }
    echo json_encode($arr_Respuesta);
  }
?>