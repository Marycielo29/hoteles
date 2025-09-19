<?php
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-servicioModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objServicio = new ServicioModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo == "registrarServicio"){
  $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
     if($_POST){
       $idHotel = trim($_POST['id_hotel']);
       $nombre = trim($_POST['nombreServicio']);
     
       if($idHotel == ""|| $nombre == "" ){
        $arr_Respuesta = array('status' => false, 'mensaje' => 'Campos vacios');
       }else{
        $id_new_servicio = $objServicio->registrarServicio($idHotel,$nombre);
        if($id_new_servicio > 0){
         $arr_Respuesta = array('status' => true, 'mensaje' => 'Registro exitoso');
        }else{
         $arr_Respuesta = array('status' => false, 'mensaje' => 'Error registro');
        }
       }
     }
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "listarServicios"){
  $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $id_hotell = trim($_POST['id_hotel']);
        $arr_servicio = $objServicio->listarServiciosHotel($id_hotell);
        if($arr_servicio){
           for ($i=0; $i < count($arr_servicio); $i++) {  
            $id_servicio = $arr_servicio[$i]->servicio_id;
             $opciones = ' <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#actualizarServicio" onclick="obtenerServicio('.$id_servicio.');"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="antesEliminarServicio('.$id_servicio.');"><i class="bi bi-trash"></i></button>';
            $arr_servicio[$i]->options = $opciones;
            }
           
            $arr_Respuesta['contenido'] = $arr_servicio;
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['mensaje'] = 'ok';
        }
    }
    echo json_encode($arr_Respuesta);
}

if ($tipo == "eliminarServicio") {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');

    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {

        if (!isset($_POST['data']) || empty($_POST['data'])) {
            $arr_Respuesta = array('status' => false, 'mensaje' => 'ID de usuario no proporcionado');
        } else {
            $id_servicio = trim($_POST['data']);

            if (!is_numeric($id_servicio) || (int)$id_servicio <= 0) {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'ID de usuario inválido');
            } else {
                $id_servicio = (int)$id_servicio;

                $eliminar = $objServicio->eliminarServicio($id_servicio);

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

if($tipo == "obtenerServicio"){
      $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
      $id_servicio = trim($_POST['data']);
      $arrServicio = $objServicio->buscarServicioById($id_servicio);
      $arr_Respuesta['contenido'] = $arrServicio;
      $arr_Respuesta['status'] = true;
    }
    echo json_encode($arr_Respuesta);
  }

  if($tipo == "actualizarServicio"){
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
       if ($_POST) {
        $id_servicio = trim($_POST['data']);
       $nombre = $_POST['n_nombreServicio'];
       if($id_servicio==""|| $nombre == ""){
        $arr_Respuesta = array('status' => false, 'mensaje' => 'Campos vacios');
       }else{
         $actualizar = $objServicio->actualizarServicio($id_servicio,$nombre);
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