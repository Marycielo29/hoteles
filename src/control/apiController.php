<?php
session_start();
require_once('../model/apiModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objAdmin = new AdminModel();
$objApi = new Api();
//variables de sesion
$token = $_REQUEST['token'];


//Peticiones de la API
if ($tipo == "verHotelesApiByNombre") {
  $token_arr = explode("-", $token);
  $id_cliente = $token_arr[2];
  $arr_Cliente = $objClient->buscarClienteById($client_api);
  if ($arr_Cliente->estado) {
    $data = $_POST['data'];
    $arr_hoteles = $objClient->buscarHotelesNombre($data);
    $arr_Respuesta = array('status' => true, 'msg' => '', 'contenido'=>$arr_hoteles);

  }else {
    $arr_Respuesta = array('status'=> false, 'msg' => 'Error, cliente no activo.');

  }
  echo json_encode($arr_Respuesta);
}

/*//listar
if ($tipo == "verHotelesApiByNombre") {
    $token_arr = explode("-", $token);
    $id_cliente = $token_arr[2];
    $arr_Cliente = $objClient->buscarClienteById($client_api);

    if ($arr_Cliente->estado) {
        $data = isset($_POST['data']) ? trim($_POST['data']) : ""; 
        $arr_hoteles = $objClient->buscarHotelesNombre($data); 
        $arr_Respuesta = array('status' => true, 'msg' => '', 'contenido' => $arr_hoteles);
    } else {
        $arr_Respuesta = array('status'=> false, 'msg' => 'Error, cliente no activo.');
    }

    echo json_encode($arr_Respuesta);
}*/



?>