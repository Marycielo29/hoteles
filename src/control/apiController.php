<?php

require_once('../model/apiModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase model
$objAdmin = new AdminModel();
$objApi = new Api();

//variables de token
$token = $_REQUEST['token'];


// Peticiones de la API - Buscar hoteles por nombre + habitación
if ($tipo == "verHotelesApiByNombreHabitacion") {

  $token_arr = explode("-", $token);
  $id_cliente = $token_arr[2];

  $arr_Cliente = $objClient->buscarClienteById($id_cliente);

  if ($arr_Cliente->estado) {

    $nombre = $_POST['nombre'];          // Nombre del hotel
    $habitaciones = $_POST['habitaciones'];  // Tipo de habitación

    $arr_hoteles = $objClient->buscarHotelesNombreHabitacion($nombre, $habitaciones);

    $arr_Respuesta = array(
      'status' => true,
      'msg' => '',
      'contenido' => $arr_hoteles
    );

  } else {
    $arr_Respuesta = array(
      'status' => false,
      'msg' => 'Error, cliente no activo.'
    );
  }

  echo json_encode($arr_Respuesta, JSON_UNESCAPED_UNICODE);
  die();
}




?>