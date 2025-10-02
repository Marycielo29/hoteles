<?php
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/TokenModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objToken = new TokenModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo =="generarToken"){
  $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
     if($_POST){
        $id_client = $_POST['id_client'];
       if (!empty($id_client)) {
                // Llamar al modelo para generar el token
                $resultado = $objToken->generarTokenParaCliente($id_client);
                if ($resultado) {
                    $arr_Respuesta = array('status' => true, 'mensaje' => 'Token generado correctamente');
                } else {
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al generar el token en la base de datos');
                }
            } else {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'ID de cliente no proporcionado');
            }
     }else {
            $arr_Respuesta = array('status' => false, 'mensaje' => 'Método no permitido');
    }
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "listarTokens"){
  $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $id_client = $_POST['id_client'];
        if(empty($id_client)||!is_numeric($id_client)){
          $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al verificar cliente');
        }else{
            $arr_tokens = $objToken->listarTokens($id_client);
            if($arr_tokens){
            for ($i=0; $i < count($arr_tokens); $i++) { 

              /*   $arr_tokens[$i]->estado = $arr_tokens[$i]->estado == 1? '<span class="status status-activo">Activo</span>':'<span class="status status-inactivo">Inactivo</span>'; */
                   
                 $id_token = $arr_tokens[$i]->id;

                if($arr_tokens[$i]->estado == 1){
                  $arr_tokens[$i]->estado = '<span class="badge text-bg-success">Activo</span>';
                  $opciones = '<button class="btn btn-outline-success" onclick="cambiarEstado('.$id_token.','.(1).');"><i class="bi bi-toggle-on"></i></button>';
                }else if($arr_tokens[$i]->estado == 0){
                  $arr_tokens[$i]->estado = '<span class="badge text-bg-danger">Inactivo</span>';
                  $opciones = '<button class="btn btn-outline-danger" onclick="cambiarEstado('.$id_token.','.(0).');"><i class="bi bi-toggle-off"></i></button>';
                }
                $id_token = $arr_tokens[$i]->id;
            /*     $opciones = '<button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#actualizarCliente" onclick="obtenerCliente('.$id_token.');"><i class="bi bi-toggle-off"></i></button>
                <button class=" btn btn-outline-success"><i class="bi bi-toggle-off"></i></button>'; */
                $arr_tokens[$i]->options = $opciones;
                }
            
                $arr_Respuesta['contenido'] = $arr_tokens;
                $arr_Respuesta['status'] = true;
                $arr_Respuesta['mensaje'] = 'ok';
            }
        }
       
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "cambiarEstado"){
  $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        if($_POST){
           $id_token = $_POST['idToken'];
           $estado = $_POST['estado'];
           if(empty($id_token)||!is_numeric($id_token)){
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Token invalido');
           }else{
             $actualizar = $objToken->actualizarEstadoToken($id_token,$estado);
             if($actualizar){
                 $arr_Respuesta = array('status' => true, 'mensaje' => 'Estado cambiado');
             }else{
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error de sistema');
             }
           }
        }else{
          $arr_Respuesta = array('status' => false, 'mensaje' => 'Metodo invalido');
        }
    }
    echo json_encode($arr_Respuesta);
}

?>