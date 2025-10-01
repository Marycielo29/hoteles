<?php
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-hotelModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objHotel = new HotelModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo == "registrarHotel"){
  $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
     if($_POST){
       $nombre = ucfirst(trim($_POST['nombreHotel']));
       $descripcion = $_POST['descripcionHotel'];
       $direccion = trim($_POST['direccionHotel']);
       $ciudad = ucfirst(trim($_POST['ciudadHotel']));
       $categoria = trim($_POST['estrellasHotel']);
       $telefono = trim($_POST['telefonoHotel']);
       $email = trim($_POST['emailHotel']);
       if($nombre == ""|| $descripcion == "" || $direccion == ""|| $ciudad == ""|| $categoria == ""||$telefono == "" || $email == ""){
        $arr_Respuesta = array('status' => false, 'mensaje' => 'Campos vacios');
       }else{
        $id_new_hotel = $objHotel->registrarHotel($nombre,$descripcion,$direccion,$ciudad,$categoria,$telefono,$email);
        if($id_new_hotel > 0){
         $arr_Respuesta = array('status' => true, 'mensaje' => 'Registro exitoso');
        }else{
         $arr_Respuesta = array('status' => false, 'mensaje' => 'Error registro');
        }
       }
     }
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "listarHoteles"){
  $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $arr_hoteles = $objHotel->listarHoteles();
        if($arr_hoteles){
           for ($i=0; $i < count($arr_hoteles); $i++) { 
           //validacion de estrellas / categoria 
           switch ($arr_hoteles[$i]->categoria) {
            case '1':
              $arr_hoteles[$i]->estrellas = ' <i class="bi bi-star-fill"></i>';
              break;
            case '2':
              $arr_hoteles[$i]->estrellas = ' <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>';
              break;
            case '3':
              $arr_hoteles[$i]->estrellas = '<i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>';
              break;
              case '4':
                 $arr_hoteles[$i]->estrellas = '<i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>';
                 break;
              case '5':
                 $arr_hoteles[$i]->estrellas = '<i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>';
                break;
           }

            $id_hotel = $arr_hoteles[$i]->hotel_id;
             $opciones = ' <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#actualizarHotel" onclick="obtenerHotel('.$id_hotel.');"><i class="bi bi-pencil-square"></i></button>
                            <a href="detalleHotel?data='.($id_hotel).'"><button class="btn btn-warning btn-sm"><i class="bi bi-eye-fill"></i></button></a>
                            <a href="servicios?data='.($id_hotel).'"><button class="btn btn-success btn-sm"><i class="bi bi-folder-symlink-fill"></i></button></a>
                            <a href="habitaciones?data='.($id_hotel).'"><button class="btn btn-info btn-sm" ><i class="bi bi-houses-fill"></i></button></a>';
            $arr_hoteles[$i]->options = $opciones;
            }
           
            $arr_Respuesta['contenido'] = $arr_hoteles;
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['mensaje'] = 'ok';
        }
    }
    echo json_encode($arr_Respuesta);
}

if ($tipo == "eliminarUsuario") {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');

    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {

        if (!isset($_POST['idUser']) || empty($_POST['idUser'])) {
            $arr_Respuesta = array('status' => false, 'mensaje' => 'ID de usuario no proporcionado');
        } else {
            $id_user = trim($_POST['idUser']);

            if (!is_numeric($id_user) || (int)$id_user <= 0) {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'ID de usuario inválido');
            } else {
                $id_user = (int)$id_user;

                $eliminar = $objUsuario->eliminarUsuario($id_user);

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

if($tipo == "obtenerHotel"){
      $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
      $idHotel = trim($_POST['data']);
      $arrHotel = $objHotel->buscarHotelById($idHotel);

          switch ($arrHotel->categoria) {
            case '1':
              $arrHotel->estrellas = ' <i class="bi bi-star-fill"></i>';
              break;
            case '2':
              $arrHotel->estrellas = ' <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>';
              break;
            case '3':
              $arrHotel->estrellas = '<i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>';
              break;
              case '4':
                 $arrHotel->estrellas = '<i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>';
                 break;
              case '5':
                 $arrHotel->estrellas = '<i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>';
                break;
           }

      $arr_Respuesta['contenido'] = $arrHotel;
      $arr_Respuesta['status'] = true;
    }
    echo json_encode($arr_Respuesta);
  }

  if($tipo == "actualizarHotel"){
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
       if ($_POST) {
       $idHotel = trim($_POST['data']);
       $nombre = trim($_POST['new_nombreHotel']);
       $ciudad = trim($_POST['NewCiudadHotel']);
       $categoria = $_POST['NewEstrellasHotel'];
       $direccion = $_POST['newDireccion'];
       $telefono = $_POST['newTelefono'];
       $correo = $_POST['newEmailHotel'];
       $descripcion = $_POST['NewDescripcion'];

        if($nombre == ""|| $ciudad == "" || $categoria == ""|| $direccion == ""|| $telefono == ""|| $correo == ""|| $descripcion == ""){
        $arr_Respuesta = array('status' => false, 'mensaje' => 'Campos vacios');
       }else{
         $actualizar = $objHotel->actualizarHotel($idHotel,$nombre,$ciudad,$categoria,$direccion,$telefono,$correo,$descripcion);
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