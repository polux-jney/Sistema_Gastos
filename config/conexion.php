<?php
require_once("global.php");

$conexion = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

mysqli_query($conexion, 'SET NAMES "'.DB_ENCODE.'"');

if(mysqli_connect_error()){
  printf("Error en la conexion a la base de datos: %s\n",mysqli_connect_error());
  exit();
}

//echo "Hola Mundo: ".$conexion->host_info." adios\n";


function ejecutarConsulta($sql){
  global $conexion;
  $query = $conexion->query($sql);
  return $query;
}

function ejecutarConsultaSimpleFila($sql){
  global $conexion;
  $query = $conexion->query($sql);
  $row=$query->fetch_assoc();
  return $row;
}

function ejecutarConsultaRetornaID($sql){
  global $conexion;
  $query = $conexion->query($sql);
  return $conexion->insert_id;
}

function limpiarCadenas($str){
  global $conexion;
  $str = mysqli_real_escape_string($conexion, trim($str));
  return htmlspecialchars($str);
}

if (!function_exists('encryption')){ //Valida si la función ya esta en memoria.
  function encryption($string){
    //write_log("ENTRANDO A conexion encryption - SK =  ".SECRET_KEY);//ejecutarConsulta($sql);
    $output=FALSE;
    $key = hash('sha256',SECRET_KEY);
    $iv=openssl_random_pseudo_bytes(openssl_cipher_iv_length(METHOD));
    $output=openssl_encrypt($string, METHOD,$key,0,$iv);
    $output=base64_encode($output.'::'.$iv);
    //write_log("ENTRANDO A conexion encryption - SK =  ".$output);//ejecutarConsulta($sql);
    return $output;
  }

  function decryption($string){
    //write_log("ENTRANDO A conexion decryption - SK =  ".SECRET_KEY);//ejecutarConsulta($sql);
    $key = hash('sha256',SECRET_KEY);
    list($string,$iv) = array_pad(explode('::', base64_decode($string), 2),2,null);
    $output=openssl_decrypt($string,METHOD,$key,0,$iv);
    //write_log("ENTRANDO A conexion decryption - SK =  ".$output);//ejecutarConsulta($sql);
    return $output;
  }

  function write_log($log_msg){
    $log_filename = "gastosLog";
    if (!file_exists($log_filename)){
        mkdir($log_filename, 0777, true);
    }
    $log_file_data = $log_filename.'/debug.log';
    file_put_contents($log_file_data, "===================== ".date("Y-m-d H:i:s")." ==============" . "\n", FILE_APPEND);
    file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
  }
}


  function set_pass($contra){
    $pwd_peppered = hash_hmac("sha256", $contra, PEPPER);
    $opciones = [
        'cost' => 11
    ];
    $pwd_hashed = password_hash($pwd_peppered, PASSWORD_BCRYPT, $opciones);
    return $pwd_hashed;
  }

  function val_pass($contra,$dbContra){

      $pwd_peppered = hash_hmac("sha256", $contra, PEPPER);

      $verification = password_verify($pwd_peppered, $dbContra);

      return $verification;
  }


?>