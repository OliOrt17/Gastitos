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
      case 'insertToken':
        insertToken();
      break;
      case "cambiar_status":
      cambiar_status();
      break;
      //transacciones
      case "insertar_trs":
      insertar_trs();
      break;
      case "consultar_trs":
        consultar_trs();
      break;
      case "editar_trs":
        editar_trs();
      break;
      case "eliminar_trs":
      eliminar_trs();
      break;
     /* case "mostrar_trs":
      mostrar_trs();
      break;*/
      case "carga_foto":
      carga_foto();
      break;
      case "gastos":
      gastos();
      break;
      case "ingresos":
      ingresos();
      break;
    }
  }
    function ingresos(){
      global $db;
      extract($_POST);
    
        $insertar=$db ->insert("transacciones",["cat_id" => $tipo,
                                          "trs_descripcion" =>$descripcion,
                                          "trs_cantidad" => $cantidad,
                                          "tps_id"=>1,
                                          "trs_fechai" => date("Y").date("m").date("d"),
                                          "usr_id"=>$num]);
    
      if($insertar){
        echo 1;
      }
    }
    function gastos(){
      global $db;
    extract($_POST);
  
      $insertar=$db ->insert("transacciones",["cat_id" => $tipo,
                                        "trs_descripcion" =>$descripcion,
                                        "trs_cantidad" => $cantidad,
                                        "tps_id"=>2,
                                        "trs_fechai" => date("Y").date("m").date("d"),
                                        "usr_id"=>$num]);
  
    if($insertar){
      echo 1;
    }
    }
    //funcion para cargar imagenes
    function carga_foto(){
      if(isset($_FILES["archivo"])){
          $foto=$_FILES["archivo"]["name"];
          $temporal=$_FILES["archivo"]["tmp_name"];
          $carpeta="../../assets/images/";
          $arreglo["texto"]="Error";
          $arreglo["satus"]=0;
          if(move_uploaded_file($temporal , $carpeta.$foto)){
              $arreglo["texto"]="Subida exitosa";
              $arreglo["archivo"]=$carpeta.$foto;
              $arreglo["status"]=1;
          }
          echo json_encode($arreglo);
      }
  }
  //transacciones
  //insertar
  function insertar_trs(){
    global $db;
    extract($_POST);
  
      $insertar=$db ->insert("transacciones",["cat_id" => $tipo,
                                        "trs_descripcion" =>$descripcion,
                                        "trs_cantidad" => $cantidad,
                                        "tps_id"=>$categoria,
                                        "trs_fechai" => date("Y").date("m").date("d"),
                                        "usr_id"=>$num]);
  
    if($insertar){
      echo 1;
    }
  }
  function eliminar_trs(){
    global $db;
    extract($_POST);

    $eliminar=$db->delete("transacciones",["trs_id" => $id]);

    if($eliminar){
      echo 1;
    }
  }
  function consultar_trs(){
    global $db;
    extract($_POST);

    $consultar = $db -> get("transacciones","*",["AND" => ["trs_id"=>$id]]);
    echo json_encode($consultar);

  }
  function editar_trs(){
    global $db;
    extract($_POST);


      $editar=$db ->update("transacciones",["cat_id" => $tipo,
      "trs_descripcion" =>$descripcion,
      "trs_cantidad" => $cantidad,
      "tps_id"=>$categoria,
      "trs_fechai" => date("Y").date("m").date("d")],
      ["trs_id"=>$id]);
      
      if($editar){
        echo 2;
      }

  }
  /*function mostrar_trs(){
    global $db;
    $consultar = $db->get("transacciones","*",["AND" => ["trs_id"=>$id]]);
	  echo json_encode($consultar);
  }*/

 

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
                                        "usr_foto"=>$foto,
                                        "usr_fechai" => date("Y").date("m").date("d")]);
  
    if($insertar){
      echo 1;
    }
  }
  //cambiar status usuarios
  function cambiar_status(){
    global $db;
    extract($_POST);
    $actualizar=$db->update("usuarios",["usr_status" => $status],
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
      
      "usr_foto"=>$foto,
      "usr_fechai" => date("Y").date("m").date("d")],
      ["usr_id"=>$id]);
      
      if($editar){
        echo 2;
      }

  }


  //categorias
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
      "tps_id"=>$tipo,
      "cat_fechai" => date("Y").date("m").date("d")]);
  
    if($insertar){
      echo 1;
    }
  }
  //mostrar
  function mostrar_cat(){
    global $db;
    $consultar = $db->select("categorias",[
      "[>]tipos"=>"tps_id"],["categorias.cat_id",
      "categorias.cat_nom","categorias.cat_fechai","tipos.tps_id","tipos.tps_nom"]);
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
      "tps_id"=>$tipo,
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
   
    $actualizar=$db->update("usuarios",["usr_password" => $pass,
    "usr_fechar" => date("Y").date("m").date("d"),"token"=>null],
    ["usr_id"=>$id]);

    if($actualizar){
      echo 1;
    }
  }
  //recuperar contraseña
  function recuperar(){
    global $db;
    extract($_POST);

    if(!$db->select("usuarios","*",[
      "AND" =>[
      "usr_email" => $email,
      "usr_status" => "1"
          ]
      ])
    ){
  $arr = array('status' => 0);
}else{
  $arr = array('status' => 1);    
  }	
  header('Content-type: application/json; charset=utf-8');
  echo json_encode($arr);
  return;

  }
  function insertToken(){
    global $db;
    extract($_POST);  

     $token = uniqid();
    
     $editar=$db ->update("usuarios",[                                    
                                        "token"=>$token,                              
                                         ],["usr_email"=>$email]);
        if($editar){
        $arr = array('status' => 1,'token' => $token);    
        }else{
        $arr = array('status' => 0, 'token' => 'null');
        } 
    
    //Aunque el content-type no sea un problema en la mayoría de casos, es recomendable especificarlo
    header('Content-type: application/json; charset=utf-8');
	echo json_encode($arr);
  return;	
  
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
    /*$data = array();
    $conpassword=$db->get("usuarios","*",["usr_password"=>$password]);#consulta para la contraseña
    if($conpassword){
	    if($conpassword["usr_email"] == $user && $conpassword["usr_password"] == $password){
        session_start();
	    	$type = $conpassword["usr_id"];
	      $_SESSION['US']= $user;
	 	    $_SESSION['USR_ID']= $type;
         $data['status'] = 1;
	    }
    }else{
    	$data['status'] = 0;
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($data);*/
    $data = array();
    $conpassword=$db->select("usuarios","*",["usr_password"=>$password]);#consulta para la contraseña
    $conuser=$db->select("usuarios","*",["usr_email"=>$user]);#consulta para usuario

    if($conpassword && $conuser){
      $data['status'] = 1;
      $type=$db->select("usuarios","*",["AND"=>["usr_email"=>$user,"usr_password"=>$password]]);
      create_session($user,$type);
    }elseif(!$conuser){
      $data['status'] = 0;
    }elseif(!$conpassword){
      $data['status'] = 2;
    }

    
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($data);
  }

?>
