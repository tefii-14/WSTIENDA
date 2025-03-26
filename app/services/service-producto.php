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