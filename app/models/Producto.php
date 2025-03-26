<?php

require_once 'Conexion.php';

class Producto extends Conexion{

  private $conexion;

  public function __construct(){
    $this->conexion = parent::getConexion();
  }

  public function add($params=[]): bool{

    $saveStatus = false;
    try{
      $sql = "INSERT INTO productos (tipo, genero, talla, precio) VALUES (?,?,?,?)";
      $consulta = $this->conexion->prepare($sql);
      $saveStatus = $consulta->execute(array(
        $params["tipo"],
        $params["genero"],
        $params["talla"],
        $params["precio"]
      ));

      return $saveStatus;
    }
    catch(Exception $e){
      return false;
    }
  }


  /**
   * Retorna una coleccion de registros a productos
   * @return  array
   */

  public function getAll(): array{
    try{
      $sql = "SELECT id, tipo, genero, talla, precio FROM productos ORDER BY id DESC";
      $consulta = $this->conexion->prepare($sql);
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      return ['code'=> 0,'msg'=> $e->getMessage()];
    }
  }
}