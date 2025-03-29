<?php
require_once "../models/Usuario.php";
$usuario = new Usuario();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Allow: GET, POST, PUT, DELETE");
header("Content-type: application/json; charset=utf-8");

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo == 'GET') {
    $registros = [];

    if (isset($_GET['q'])) {
        switch ($_GET['q']) {
            case 'showAll': 
                $registros = $usuario->getAll(); 
                break;
            case 'findById': 
                if (isset($_GET['id_usuario'])) {
                    $registros = $usuario->getById($_GET['id_usuario']);
                } else {
                    $registros = ['status' => false, 'msg' => 'ID de usuario no proporcionado.'];
                }
                break;
        }
    }

    echo json_encode($registros);
} 

elseif ($metodo == 'POST') {
    // Detectar si los datos vienen por JSON o por form-data
    $inputJSON = file_get_contents('php://input');
    $datos = json_decode($inputJSON, true);

    if (!$datos) {
        // Si no se recibió JSON, intentamos con $_POST (form-data)
        $datos = $_POST;
    }

    if (isset($datos['nombre_usuario']) && isset($datos['contraseña']) && count($datos) == 2) {
        // LOGIN
        $usuarioData = $usuario->login($datos['nombre_usuario'], $datos['contraseña']);
        echo json_encode($usuarioData);
    } 
    elseif (isset($datos['nombre_completo'], $datos['nombre_usuario'], $datos['telefono'], $datos['email'], $datos['contraseña'])) {
        // REGISTRO
        $registro = [
            'nombre_completo' => $datos['nombre_completo'],
            'nombre_usuario' => $datos['nombre_usuario'],
            'telefono' => $datos['telefono'],
            'email' => $datos['email'],
            'contraseña' => $datos['contraseña']
        ];
        $status = $usuario->add($registro);
        echo json_encode($status);
    } 
    else {
        echo json_encode(['status' => false, 'msg' => 'Datos incompletos.']);
    }
}
?>