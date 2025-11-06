<?php
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/tokenapiModel.php');

header('Content-Type: application/json; charset=utf-8');

$tipo = $_GET['tipo'] ?? '';
$objSesion = new SessionModel();
$objToken = new TokenApiModel();

$id_sesion = $_REQUEST['sesion'] ?? '';
$token = $_REQUEST['token'] ?? '';

if ($tipo == "listarTokens") {
    $respuesta = ['status' => false, 'mensaje' => 'Error_Sesion'];
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $tokens = $objToken->listarTokens();
        if ($tokens) {
            $respuesta = ['status' => true, 'contenido' => $tokens, 'mensaje' => 'ok'];
        } else {
            $respuesta = ['status' => false, 'mensaje' => 'No hay tokens registrados'];
        }
    }
    echo json_encode($respuesta);
    exit;
}

if ($tipo == "actualizarToken") {
    $respuesta = ['status' => false, 'mensaje' => 'Error_Sesion'];
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        if ($_POST) {
            $nuevoToken = trim($_POST['n_token']);
            if ($nuevoToken == "") {
                $respuesta = ['status' => false, 'mensaje' => 'El token no puede estar vacío'];
            } else {
                $ok = $objToken->actualizarToken($nuevoToken);
                if ($ok) {
                    $respuesta = ['status' => true, 'mensaje' => 'Token actualizado correctamente'];
                } else {
                    $respuesta = ['status' => false, 'mensaje' => 'Error al actualizar el token'];
                }
            }
        }
    }
    echo json_encode($respuesta);
    exit;
}

