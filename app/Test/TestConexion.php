<?php

require_once "../models/Conexion.php";

$cadenaSucia1 = "<h1>Luis</h1>";
$cadenaSucia2 = "<script>alert('Andrea')</script>";
$cadenaSucia3 = "SELECT * FROM miTabla";
$cadenaSuci4 = "DELETE FROM Usuarios";
$cadenaSuci5 = "A === A";

$limpio = Conexion::limpiarCadena($cadenaSucia5);
//var_dump($limpio);

$valorURL = "14"; // SmxCN2NtL2xzNnlXTmY5dWRjVXp4QT09
$valorEncriptadon = Conexion::encryption($valorURL);
//var_dump($valorEncriptadon);

$desencriptado = Conexion::decryption($valorEncriptadon);
//var_dump($desencriptado);

//la contraseña se encriptan pero no se puede desencriptar
$claveUsuario = "SENATI123"; //$2y$10$FXtVq60jabukrAG73B8HLOfNQwjoLDX9XP0nstdpp0eZHOZLupSNK
$claveEncriptada = password_hash($claveUsuario, PASSWORD_BCRYPT);
var_dump($claveEncriptada);

?>