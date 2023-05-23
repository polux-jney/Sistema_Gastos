<?php   
require_once "../modelos/Categoria.php";
$categoria=new Categoria();

//Obtenemos nuestras variables del arreglo post
$idCategoria=isset($_POST['idCategoria'])?limpiarCadenas($_POST['idCategoria']):"";
$descripcion=isset($_POST['descripcion'])?limpiarCadenas($_POST['descripcion']):"";

//Agregamos lógica para fechas de registro y variables auxiliares 
date_default_timezone_set('America/Mexico_City');
$fechaActualizacion=date("Y-m-d H:i:s");
$idEmpActualiza=1; // Cambiar por el usuario de la sesion.


switch ($_GET["op"]){
    case 'listar':
      $rspta=$categoria->listar();
      $data=Array();
      while ($reg=$rspta->fetch_object()){
        $data[]=array(
          "0"=>($reg->activo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idCategoria.')"><i class="far fa-edit"></i></button>'.
          ' <button class="btn btn-danger" onclick="desactivar('.$reg->idCategoria.')"><i class="far fa-window-close"></i></button>':'<button class="btn btn-warning" onclick="mostrar('.$reg->idCategoria.')"><i class="fa fa-edit"></i></button>'.
          ' <button class="btn btn-primary" onclick="activar('.$reg->idCategoria.')"><i class="far fa-check-square"></i></button>',
          "1"=>$reg->descripcion,
          "2"=>$reg->fechaCreacion,
          "3"=>$reg->fechaActualizacion,
          "4"=>($reg->activo)?'<span class="badge badge-success">Activado</span>':'<span class="badge badge-danger">Desactivado</span>',
          "5"=>$reg->idEmpActualiza
        );
      }
      
      $results=array(
        "sEcho"=>1, //informacion para el datatables
        "iTotalRecords"=>count($data),
        "iTotalDisplayRecords"=>count($data),
        "aaData"=>$data
      );

      echo json_encode($results);

    break;
    //Agregamos caso de guardar y editar
    case 'guardaryeditar':
      //Agregamos validación para saber si tenemos que guardar una edición o crear un nuevo registro
      if(empty($idCategoria)){
        //Ejecutamos la instrucción de insertar
        $rspta=$categoria->insertar($descripcion);
        //Configuramos el mensaje de respuesta
        echo $rspta!=0?"Categoria registrado":"Error categoria no resgistrado";
      }else{
        //Ejecutamos la instrucción de editar
        $rspta=$categoria->editar($idCategoria, $descripcion, $fechaActualizacion, $idEmpActualiza);
        //Configuramos el mensaje de respuesta
        echo $rspta!=0?"Categoria actualizado":"Error categoria no actualizado";
      }
      
    break;
    //Establecemos el caso para la opción mostrar
    case 'mostrar':
      //Llamamos al método mostrar de nuestro objeto
      $rspta=$categoria->mostrar($idCategoria);
      //codificamos a json el resultado para que viaje correctamente por request.
      echo json_encode($rspta);
    break;

    //Creamos el caso para desactivar
    case 'desactivar':
      //Mandamos a ejecutar el método para desactivar de nuestro objeto
      $rspta=$categoria->desactivar($idCategoria);
      //Configuramos mensaje de respuesta
      echo $rspta?"Categoria desactivado":"Error categoria no desactivado";
    break;
    
    //Reutilizamos el código para implementar la funcionalidad de activar.
    case 'activar':
      $rspta=$categoria->activar($idCategoria);
      echo $rspta?"Categoria activado":"Error categoria no activado";
    break;
  /*
  
          echo "$reg->idCategoria";
          echo "$reg->descripcion";
          echo "$reg->activo";
          echo "$reg->fechaCreacion";
          echo "$reg->fechaActualizacion";
          echo "$reg->idEmpActualiza";
          */
} 

?>