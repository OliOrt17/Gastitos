<?php
  require_once '_db.php';
  function create_session($user,$type){
    session_start();
    $_SESSION['US']= $user;
    $_SESSION['USR_ID']= $type[0]["usr_id"];
    
    $cookie_name = "lau";
    $cookie_value = $type[0]["usr_id"];
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
    return;
  }
  function get_data_session(){

    return $_SESSION;
  }
  if(isset($_POST["accion"])){
    switch ($_POST["accion"]) {
      //Login
      case "login":
        login();
      break;
      //registro
      case "registrar":
        registrar();
      break;
      //verificar
      case "verificar_usr":
        verificar_usr();
      break;
      //recuperar contraseña
      case "recuperar":
        recuperar();
      break;
      //comentario
      case "comentario":
        comentario();
      break;
      //acualizar contraseña
      case "actualizar":
        actualizar();
      break;
      //cerrar sesion
      case "cerrar_sesion":
        cerrar_sesion();
      break;
      //cambiar status usuarios
      case "status_usr":
      status_usr();
      break;
      //usuarios
      case "eliminar_usr":
      eliminar_usr();
      break;
      case "mostrar_usr":
      mostrar_usr();
      break;
      case "insertar_usr":
        insertar_usr();
      break;
      case "consultar_usr":
        consultar_usr();
      break;
      case "editar_usr":
        editar_usr();
      break;
      //categorias
      case "eliminar_cat":
      eliminar_cat();
      break;
      case "mostrar_cat":
      mostrar_cat();
      break;
      case "insertar_cat":
        insertar_cat();
      break;
      case "consultar_cat":
        consultar_cat();
      break;
      case "editar_cat":
        editar_cat();
      break;
    }
  }

  //usuarios
  //eliminar
  function eliminar_usr(){
    global $db;
    extract($_POST);

    $eliminar=$db->delete("usuarios",["usr_id" => $id]);

    if($eliminar){
      echo 1;
    }
  }
  //insertar
  function insertar_usr(){
    global $db;
    extract($_POST);
  
      $insertar=$db ->insert("usuarios",["usr_nom" => $nombre,
                                        "usr_email" =>$email,
                                        "usr_password" => $password,
                                        "usr_fechai" => date("Y").date("m").date("d")]);
  
    if($insertar){
      echo 1;
    }
  }
  //mostrar
  function mostrar_usr(){
    global $db;
    $consultar = $db->select("usuarios","*");
	  echo json_encode($consultar);
  }
  //cambiar status usuarios
  function status_usr(){
    global $db;
    extract($_POST);
    $actualizar=$db->update("usuarios",["usr_status" => 0],
    ["usr_id"=>$id]);

    if($actualizar){
      echo 1;
    }
  }
  function consultar_usr(){
    global $db;
    extract($_POST);

    $consultar = $db -> get("usuarios","*",["AND" => ["usr_id"=>$id]]);
    echo json_encode($consultar);

  }
  //editar
  function editar_usr(){
    global $db;
    extract($_POST);


      $editar=$db ->update("usuarios",["usr_nom" => $nombre,
      "usr_email" =>$email,
      "usr_password" => $password,
      "usr_fechai" => date("Y").date("m").date("d")],
      ["usr_id"=>$id]);
      
      if($editar){
        echo 2;
      }

  }

  //categorias
  //usuarios
  //eliminar
  function eliminar_cat(){
    global $db;
    extract($_POST);

    $eliminar=$db->delete("categorias",["cat_id" => $id]);

    if($eliminar){
      echo 1;
    }
  }
  //insertar
  function insertar_cat(){
    global $db;
    extract($_POST);
  
      $insertar=$db ->insert("categorias",["cat_nom" => $nombre,
      "cat_tipo"=>$tipo,
      "cat_fechai" => date("Y").date("m").date("d")]);
  
    if($insertar){
      echo 1;
    }
  }
  //mostrar
  function mostrar_cat(){
    global $db;
    $consultar = $db->select("categorias","*");
	  echo json_encode($consultar);
  }
  function consultar_cat(){
    global $db;
    extract($_POST);

    $consultar = $db -> get("categorias","*",["AND" => ["cat_id"=>$id]]);
    echo json_encode($consultar);

  }
  //editar
  function editar_cat(){
    global $db;
    extract($_POST);


      $editar=$db ->update("categorias",["cat_nom" => $nombre,
      "cat_tipo"=>$tipo,
      "cat_fechai" => date("Y").date("m").date("d")],
      ["cat_id"=>$id]);
      
      if($editar){
        echo 2;
      }

  }


  //cerra sesion
  function cerrar_sesion(){
    $_COOKIE['lau']=0;
    setcookie("lau", 0, time()-1,"/");
    session_start();
    $cerrar=session_destroy();

    if($cerrar){
      echo 1;
    }
  }
  //actualizar contraseña
  function actualizar(){
    global $db;
    extract($_POST);
   
    $actualizar=$db->update("usuarios",["usr_password" => $password,
    "usr_fechar" => date("Y").date("m").date("d"),
    "usr_recuperar" => 2],["usr_id"=>1]);

    if($actualizar){
      echo 1;
    }
  }
  //recuperar contraseña
  function recuperar(){
    global $db;
    extract($_POST);

    $verificar=$db->select("usuarios","*",["usr_email"=>$email]);#verificacion de correo

    if($verificar){
      echo 1;
    }


  }
  //registrar
  function registrar(){
    global $db;
    extract($_POST);

    $insertar=$db->insert("usuarios",["usr_nom" => $nombre,
    "usr_email"=>$email,
    "usr_password"=>$password,
    "usr_fechai" => date("Y").date("m").date("d"),
    "usr_status"=>0]);

    if($insertar){
      echo 1;
    }
  }
  //verificar
  function verificar_usr(){
    global $db;
    extract($_POST);
    $conuser=$db->select("usuarios","*",["usr_email"=>$email]);#consulta para usuario
    
    if(!$conuser){
      echo 1;
    }
  }
  //LOGIN
  function login(){

    global $db;
    extract($_POST);
    $conpassword=$db->select("usuarios","*",["usr_password"=>$password]);#consulta para la contraseña
    $conuser=$db->select("usuarios","*",["usr_email"=>$user]);#consulta para usuario

    if($conpassword && $conuser){
      echo 1;
    }elseif(!$conuser){
      echo 0;
    }elseif(!$conpassword){
      echo 2;
    }

    $type=$db->select("usuarios","*",["AND"=>["usr_email"=>$user,"usr_password"=>$password]]);
    create_session($user,$type);
    
  }
  function comentario(){
    extract($_POST);
    global $db;
   //Datos para el correo
   $destino="xw_1745@hotmail.com";


   $cabeceras = "MIME-Version: 1.0\r\n";
    $cabeceras .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
    $cabeceras .= "Content-Transfer-Encoding: 8bit\r\n";

    $respuesta="De: $nombre \r\n";
    $respuesta.="E-mail: $email \r\n";
    $respuesta.="Mensaje: $mensaje \r\n";


   //enviando mensaje
    $enviar= mail($destino,$asunto,$respuesta,$cabeceras);
    if($enviar){
      echo 1;
    }
   
}

?>
