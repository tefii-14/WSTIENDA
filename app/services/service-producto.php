<?php

require_once "../models/Producto.php";
$producto = new Producto();

header("Access-Control-Allow-Origin");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Allow: GET, POST, PUT, DELETE");

header("Content-type: application/json; charset=utf-8");

$metodo=$_SERVER['REQUEST_METHOD'];

if($metodo == 'GET'){

  $registros = [];

  if (isset($_GET['q'])){
    switch ($_GET['q']){
      case'showAll': $registros = $producto->getAll(); break;
      case 'findById': $registros = $producto->getById(['id' => $_GET['id']]); break;
    }
  }

  //informar ele stado del servicio
  header('HTTP/1.1 200 Ok');
  echo json_encode($registros);
}

else if ($metodo == 'POST'){

  $inputJSON = file_get_contents('php://input');
  $datos = json_decode($inputJSON,true);

  $registro =[
    'tipo'=> $datos['tipo'],
    'genero'=> $datos['genero'],
    'talla'=> $datos['talla'],
    'precio'=> $datos['precio']
  ];

  $status = $producto->add($registro);

  //informar ele stado del servicio
  header('HTTP/1.1 200 Ok');
  echo json_encode(['status'=> $status]);
}

else if ($metodo == 'PUT') {

  $inputJSON = file_get_contents('php://input');
  $datos = json_decode($inputJSON, true);

  if (!isset($datos['id'])) {
      header('HTTP/1.1 400 Bad Request');
      echo json_encode(['error' => 'ID del producto es requerido']);
      exit();
  }

  $registro = [
      'id' => $datos['id'],
      'tipo' => $datos['tipo'],
      'genero' => $datos['genero'],
      'talla' => $datos['talla'],
      'precio' => $datos['precio']
  ];

  $status = $producto->update($registro);

  header('HTTP/1.1 200 OK');
  echo json_encode(['status' => $status]);
}

else if($metodo == 'DELETE'){

  //oBTENEMOS EL ID DE LA URL
  $requestURI = $_SERVER['REQUEST_URI'];
  $uriSegments = explode('/', $requestURI);

  //Asumiento que la URL contiene el ID a eliminar al final
  $idEliminar = intval(end($uriSegments));

  $status = $producto->delete(['id' => $idEliminar]);

  //Informar el estado del servicio
  header('HTTP/1.1 200 Ok');
  echo json_encode(['status'=>$status]);
}