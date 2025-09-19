<?php
$tipo = $_REQUEST['tipo'];

if ($tipo == "iniciar_sesion") {
    session_start();
    $_SESSION['sesion_id'] = $_POST['session'];
    $_SESSION['sesion_usuario'] = $_POST['usuario'];
    $_SESSION['sesion_usuario_nom'] = $_POST['nombres_apellidos'];
    $_SESSION['sesion_token'] = $_POST['token'];
}
if ($tipo == "cerrar_sesion") {
    session_start();
    session_unset();
    session_destroy();
    $arrResponse = array('status' => true);
    echo json_encode($arrResponse);
}