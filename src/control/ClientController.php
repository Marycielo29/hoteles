<?php
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/Client.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objClient = new Client();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo =="registrarCliente"){
  $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
     if($_POST){
       $ruc = ucfirst(trim($_POST['ruc']));
       $razon_social = strtolower($_POST['razon_social']);
       $telefono = trim($_POST['telefono']);
       $correo = trim($_POST['correo']);

       if($ruc == ""|| $razon_social == "" || $telefono == ""|| $correo == "" || !is_numeric($ruc) || strlen($ruc)!== 11){
        $arr_Respuesta = array('status' => false, 'mensaje' => 'error sistema');
       }else{
        $id_new_cliente = $objClient->registrarClienteApi($ruc,$razon_social,$telefono,$correo);
        if($id_new_cliente > 0){
         $arr_Respuesta = array('status' => true, 'mensaje' => 'Registro exitoso');
        }else{
         $arr_Respuesta = array('status' => false, 'mensaje' => 'Error registro');
        }
       }
     }
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "listarClientes"){
  $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $arrClientes = $objClient->listarClientes();
        if($arrClientes){
           for ($i=0; $i < count($arrClientes); $i++) { 

            $arrClientes[$i]->estado = $arrClientes[$i]->estado == 1? '<span class="status status-activo">Activo</span>':'<span class="status status-inactivo">Inactivo</span>';

            $id_cliente = $arrClientes[$i]->id;
             $opciones = ' <button class="btn btn-outline-secondary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#actualizarCliente" onclick="obtenerCliente('.$id_cliente.');"><i class="bi bi-pencil-square"></i></button>
             <a href="tokensClient?data='.($id_cliente).'"><button class="btn btn-outline-warning btn-sm me-1"><i class="bi bi-key"></i></button><a>';
            $arrClientes[$i]->options = $opciones;
            }
           
            $arr_Respuesta['contenido'] = $arrClientes;
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['mensaje'] = 'ok';
        }
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "obtenerCliente"){
      $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
      $id_cliente = trim($_POST['data']);
      $arrCliente = $objClient->buscarClienteById($id_cliente);
      $arr_Respuesta['contenido'] = $arrCliente;
      $arr_Respuesta['status'] = true;
    }
    echo json_encode($arr_Respuesta);
  }

    if($tipo == "actualizarCliente"){
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
       if ($_POST) {
        $id_cliente = trim($_POST['data']);
       $ruc = $_POST['n_ruc'];
       $razon = trim($_POST['n_razon_social']);
       $telefono = ucfirst(trim($_POST['n_telefono']));
       $correo = trim($_POST['n_correo']);
       $estado = trim($_POST['estado']);
      
       if($id_cliente==""|| $ruc == "" || $razon == ""|| $telefono== ""|| $correo == ""||$estado == ""||!is_numeric($ruc)||strlen($ruc)!==11){
        $arr_Respuesta = array('status' => false, 'mensaje' => 'Error sistem');
       }else{
         $actualizar = $objClient->actualizarCliente($id_cliente,$ruc,$razon,$telefono,$correo,$estado);
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