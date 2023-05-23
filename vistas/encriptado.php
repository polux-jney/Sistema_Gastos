<?php 
require_once("../config/conexion.php");

$texto="Edgar Gabriel Ordoñez Canizalez";

echo "Texto Original:".$texto."<br>";

$enc=encryption($texto);

echo "Texto Encriptado:".$enc."<br>";

$des=decryption($enc);

echo "Texto desencriptado:".$des."<br>";



 ?>