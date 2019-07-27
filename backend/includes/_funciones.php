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
    $header="De: $nombre \n";
    $header.="Correo: $email \n";
    $header.="Asunto: $asunto\n";
    $header.="Mensaje: $mensaje \n";
    //enviando mensaje
   $enviar= mail($destino,$header);
   if($enviar){
       echo 1;
   }
}

?>
