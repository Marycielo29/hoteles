<?php
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-usuarioModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objUsuario = new UsuarioModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo == "registrarUsuario"){
  $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
     if($_POST){
       $nombre = trim($_POST['nombreCompleto']);
       $email = trim($_POST['emailUsuario']);
       $password = trim($_POST['passwordUsuario']);
       $rol = $_POST['rolUsuario'];

       $passwordHash = password_hash($password, PASSWORD_DEFAULT);

       if($nombre == ""|| $email == "" || $password == ""|| $rol == ""){
        $arr_Respuesta = array('status' => false, 'mensaje' => 'Campos vacios');
       }else{
        $id_new_user = $objUsuario->registrarUsuario($nombre,$email,$passwordHash,$rol);
        if($id_new_user > 0){
         $arr_Respuesta = array('status' => true, 'mensaje' => 'Registro exitoso');
        }else{
         $arr_Respuesta = array('status' => false, 'mensaje' => 'Error registro');
        }
       }
     }
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "listarUsuarios"){
  $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $arr_usuarios = $objUsuario->listarUsuarios();
        if($arr_usuarios){
           for ($i=0; $i < count($arr_usuarios); $i++) { 
            if($arr_usuarios[$i]->estado == 1){
              $arr_usuarios[$i]->estado = '<span class="badge bg-success">Activo</span>';
            }else{$arr_usuarios[$i]->estado = '<span class="badge bg-danger">Inactivo</span>';}
            $id_usuario = $arr_usuarios[$i]->id;
             $opciones = ' <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#actualizarUsuario" onclick="obtenerUsuario('.$id_usuario.');"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="antesEliminarUsuario('.$id_usuario.');"><i class="bi bi-trash"></i></button>';
            $arr_usuarios[$i]->options = $opciones;
            }
           
            $arr_Respuesta['contenido'] = $arr_usuarios;
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
if($tipo == "obtenerUsuario"){
      $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
      $id_user = trim($_POST['idUser']);
      $arrUsuario = $objUsuario->buscarUsuarioById($id_user);
      $arr_Respuesta['contenido'] = $arrUsuario;
      $arr_Respuesta['status'] = true;
    }
    echo json_encode($arr_Respuesta);
  }

  if($tipo == "actualizarUsuario"){
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
       if ($_POST) {
       $idUser = trim($_POST['idUser']);
       $nombre = trim($_POST['new_nombre']);
       $email = trim($_POST['NewEmail']);
       $rol = $_POST['newRol'];
       $estado = $_POST['estadoUsuario'];
        if($nombre == ""|| $email == "" || $rol == ""|| $estado == ""){
        $arr_Respuesta = array('status' => false, 'mensaje' => 'Campos vacios');
       }else{
         $actualizar = $objUsuario->actualizarUsuario($idUser,$nombre,$email,$rol,$estado);
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