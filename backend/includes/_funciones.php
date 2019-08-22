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
      //clientes
      case "insertar_cli":
      insertar_cli();
      break;
      case "editar_cli":
      editar_cli();
      break;
      case "consultar_cli":
      consultar_cli();
      break;
      case "eliminar_cli":
      eliminar_cli();
      break;
      //proyectos
      case "insertar_pro":
      insertar_pro();
      break;
      case "editar_pro":
      editar_pro();
      break;
      case "consultar_pro":
      consultar_pro();
      break;
      case "eliminar_pro":
      eliminar_pro();
      break;
      //tareas
      case "insertar_tar":
      insertar_tar();
      break;
      case "eliminar_tar":
      eliminar_tar();
      break;
      case "consultar_tar":
      consultar_tar();
      break;
      case "editar_tar":
      editar_tar();
      break;
      case "tiempo":
      tiempo();
      break;
    }
  }

  function tiempo(){
    global $db;
    extract($_POST);
    date_default_timezone_set('America/Cancun');
    $actual = date("Y-m-d H:i:s");
    $insertar=$db->update("tareas",["tar_final"=>$actual],["tar_id"=>$id]);

    if($insertar){
      $con=$db->query(
        "SELECT  TIMESTAMPDIFF(SECOND, tar_tiempo,tar_final) as tiempo, tar_pago
        FROM tareas
        where tar_status=1 "

      )->fetchAll();
        if($con){
          foreach($con as $key => $con){
            $tiempo=$con["tiempo"];
            $pago=$con["tar_pago"]/3600;
          }
          $t=$tiempo*$pago;
          $ultima=$db->update("tareas",["tar_precio"=>$t,"tar_dif"=>$tiempo,"tar_status"=>0],["tar_status"=>1]);

          if($ultima){
            echo 1;
          }
      }
    }
  }
  //tareas
  function insertar_tar(){
    global $db;
    extract($_POST);
    date_default_timezone_set('America/Cancun');
    $time=date("Y-m-d H:i:s");
    $con=$db->select("proyectos",["pro_precio"],["pro_id"=>$proyecto]);
    foreach($con as $key => $con){
      $valor=$con["pro_precio"];
    }
    $insertar=$db->insert("tareas",["pro_id"=>$proyecto,
    "tar_tiempo"=> $time,"tar_descripcion"=>$descripcion,"tar_pago"=>$valor, "tar_status"=>1]);

    if($insertar){
      echo 1;
    }
  }
  function editar_tar(){
    global $db;
    extract($_POST);
   
      $editar=$db ->update("tareas",["pro_id"=>$proyecto,
      "tar_tiempo"=>$fe,"tar_descripcion"=>$descripcion,
      "tar_pago"=>$pago],
      ["tar_id"=>$id]);
      
      if($editar){
        echo 2;
      }

  }
  function eliminar_tar(){
    global $db;
    extract($_POST);

    $eliminar=$db->delete("tareas",["tar_id" => $id]);

    if($eliminar){
      echo 1;
    }
  }
  function consultar_tar(){
    global $db;
    extract($_POST);

    $consultar = $db -> get("tareas",["[>]proyectos"=>"pro_id"],
    ["proyectos.pro_id",
    "proyectos.cli_id",
    "proyectos.pro_nom",
    "tareas.tar_id",
    "tareas.tar_descripcion",
    "tareas.tar_tiempo",
    "tareas.tar_pago"],
    ["AND" => ["tareas.tar_id"=>$id]]);
    echo json_encode($consultar);

  }

  //proyectos
  function insertar_pro(){
    global $db;
    extract($_POST);
    $insertar=$db ->insert("proyectos",["pro_nom" => $nom,
                                        "cli_id" =>$cliente,
                                        "pro_fecha" =>$fecha,
                                        "pro_precio"=>$precio]);

    if($insertar){
      echo 1;
    }
  }
  function eliminar_pro(){
    global $db;
    extract($_POST);

    $eliminar=$db->delete("proyectos",["pro_id" => $id]);

    if($eliminar){
      echo 1;
    }
  }
  function consultar_pro(){
    global $db;
    extract($_POST);

    $consultar = $db -> get("proyectos","*",["AND" => ["pro_id"=>$id]]);
    echo json_encode($consultar);

  }
  function editar_pro(){
    global $db;
    extract($_POST);
   
      $editar=$db ->update("proyectos",["pro_nom" => $nom,
    "cli_id" =>$cliente,
    "pro_fecha" =>$fecha,
    "pro_precio"=>$precio],
      ["pro_id"=>$id]);
      
      if($editar){
        echo 2;
      }

  }

    //clientes
    function insertar_cli(){
      global $db;
      extract($_POST);
      $insertar=$db ->insert("cliente",["cli_nom" => $nombre,
                                          "cli_empresa" =>$empresa,
                                          "cli_sitio" => $sitio,
                                          "cli_numero"=>$tel,
                                          "cli_ubicacion"=>$ubicacion,
                                          "cli_fecha" => date("Y").date("m").date("d"),
                                          "usr_id"=>$num,
                                          "cli_email"=>$email]);

      if($insertar){
        echo 1;
      }
    }
    function eliminar_cli(){
      global $db;
      extract($_POST);
  
      $eliminar=$db->delete("clientes",["cli_id" => $id]);
  
      if($eliminar){
        echo 1;
      }
    }
    function consultar_cli(){
      global $db;
      extract($_POST);
  
      $consultar = $db -> get("clientes","*",["AND" => ["cli_id"=>$id]]);
      echo json_encode($consultar);
  
    }
    function editar_cli(){
      global $db;
      extract($_POST);
  
  
        $editar=$db ->update("clientes",["cli_nom" => $nombre,
        "cli_empresa" =>$empresa,
        "cli_sitio" => $sitio,
        "cli_numero"=>$tel,
        "cli_ubicacion"=>$ubicacion,
        "cli_fecha" => date("Y").date("m").date("d"),
        "cli_email"=>$email],
        ["cli_id"=>$id]);
        
        if($editar){
          echo 2;
        }
  
    }

    //dashboard
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
                                        print_r($insertar);
  
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
    $conpassword=$db->get("usuarios","*",["usr_password"=>$password]);#consulta para la contraseña
    $conuser=$db->get("usuarios","*",["usr_email"=>$user]);#consulta para usuario
    $constatus=$db->get("usuarios","*",["usr_email"=>$user,"usr_status"=>1]);#consulta para usuario
    if($conpassword && $conuser && $constatus){
      $data['status'] = 1;
      $type=$db->select("usuarios","*",["AND"=>["usr_email"=>$user,"usr_password"=>$password]]);
      create_session($user,$type);
    }elseif(!$conuser){
      $data['status'] = 0;
    }elseif(!$conpassword){
      $data['status'] = 2;
    }elseif(!$constatus){
      $data['status'] = 3;
    }

    
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($data);
  }

?>
