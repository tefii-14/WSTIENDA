<?php
require_once '../models/Usuario.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos enviados
    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input['nombre_usuario']) || !isset($input['contraseña'])) {
        echo json_encode(['status' => false, 'msg' => 'Faltan datos']);
        exit;
    }

    $usuario = new Usuario();
    $response = $usuario->login($input['nombre_usuario'], $input['contraseña']);

    echo json_encode($response);
} else {
    echo json_encode(['status' => false, 'msg' => 'Método no permitido']);
}
?>