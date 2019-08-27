<?php
require_once '../includes/_db.php';
require_once '../includes/_funciones.php';

session_start();
global $db;
if(!isset($_COOKIE['lau']) || $_COOKIE['lau']==0){
  echo "Sesion no iniciada";
  header('Location: ../index.html');
  return false;
  exit();
}else{
  $u_id=$_COOKIE['lau'];
  
  $id=$_SESSION['USR_ID'];
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gastitos | Transacciones</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="css/font.css">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/switchery.css">
    <script src="js/switchery.js"></script>
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <body>
    <?php
     
     $tar=$db->query(
       "SELECT tareas.tar_id,tareas.tar_tiempo, tareas.tar_descripcion,  cliente.usr_id
       FROM tareas
       inner join proyectos using(pro_id)
       inner join cliente on proyectos.cli_id = cliente.cli_id
       where tareas.tar_status=1 and cliente.usr_id=$id"

     )->fetchAll();
     foreach($tar as $key => $tar){
       if($tar){
         echo '  <div class="tareaActiva" >
       <h1>El proyecto <strong>'.$tar["tar_descripcion"].'</strong> comenzó <strong>'.$tar["tar_tiempo"].'</strong></h1> 
       
       <button data-id='.$tar["tar_id"].' id="guardar_tiempo">Detener</button>
       
        </div>';
       }
     }
    
   
   ?>
      <header class="header">
        <nav class="navbar navbar-expand-lg">
          <div class="search-panel">
            <div class="search-inner d-flex align-items-center justify-content-center">
              <div class="close-btn">Cerrar <i class="fa fa-close"></i>   </div>
              <form id="searchForm" action="#">
                <div class="form-group">
                  <input type="search" name="search" placeholder="¿Que estas buscando?...">
                  <button type="submit" class="submit">Buscar</button>
                  
                </div>
              </form>
            </div>
          </div>
          <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="navbar-header">
              <!-- Navbar Header-->
                <a href="index.html" class="navbar-brand">
                <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">Dark</strong><strong>Admin</strong></div>
                <div class="brand-text brand-sm"><strong class="text-primary">D</strong><strong>A</strong></div></a>
              <!-- Sidebar Toggle Btn-->
              <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
            </div>
            <div class="right-menu list-inline no-margin-bottom">
              <div class="list-inline-item"><a href="#" class="search-open nav-link"><i class="icon-magnifying-glass-browser"></i></a></div>
              <!-- Log out               -->
              <div class="list-inline-item logout">
                <a id="logout"  class="nav-link"> <span class="d-none d-sm-inline">Cerrar Sesión </span><i class="icon-logout"></i></a></div>
            </div>
          </div>
        </nav>
      </header>
      <div class="d-flex align-items-stretch">
        <!-- Sidebar Navigation-->
        <nav id="sidebar">
          <!-- Sidebar Header-->
          <div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="<?php 
              $usr = $db->select("usuarios","*",["usr_id"=>$id]);
               foreach($usr as $key => $usr){
                 echo $usr["usr_foto"];
               }
              ?>" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title">
            <h1 class="h5"><?php 
              $usr = $db->select("usuarios","*",["usr_id"=>$id]);
               foreach($usr as $key => $usr){
                 echo $usr["usr_nom"];
               }
              ?></h1>
            </div>
          </div>
          <!-- Sidebar Navidation Menus--><span class="heading">Modulos</span>
          <ul class="list-unstyled">
            <li><a href="index.php"> <i class="icon-home"></i>Inicio </a></li>
            <li ><a href="usuarios.php"> <i class="icon-user"></i>Usuarios </a></li>
            <li><a href="categorias.php"> <i class="icon-computer"></i>Categorias </a></li>
            <li class="active"><a href="transacciones.php"> <i class="icon-paper-and-pencil"></i>Transacciones </a></li>
            <li><a href="clientes.php"> <i class="icon-user"></i>clientes </a></li>
            <li ><a href="proyectos.php"> <i class="icon-computer"></i>proyectos</a></li>
            <li ><a href="tareas.php"> <i class="icon-paper-and-pencil"></i>Tareas</a></li>
        </nav>
        <!-- Sidebar Navigation end-->
        <div class="page-content">
          <!-- Page Header-->
          <div class="page-header no-margin-bottom">
            <div class="container-fluid">
              <h6 class="h5 no-margin-bottom"><?php
 
 $meses = array(1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
     'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
  $mes=date('n');
 echo date('j'). ' ' .$meses[date('n')] . ' de ' . date('Y');?></h6>

              
            </div>
          </div>
          <!-- Breadcrumb-->
          <div class="container-fluid">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
              <li class="breadcrumb-item active">Transacciones        </li>
            </ul>
          </div>
          <section class="no-padding-top">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="block">
                    <div class="title">
                      <strong>Transacciones &nbsp; &nbsp;</strong>
                      <button id="nuevo" type="button" class="btn btn-primary">Nuevo</button>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="table_datos">
                        <thead>
                          <tr>
                            <th>Tipo</th>
                            <th>Categoria</th>
                            <th>Descripcion</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $trs = $db->select("transacciones",
                            [
                              "[>]categorias"=>"cat_id",
                              "[>]usuarios"=>"usr_id"

                            ],
                            [
                              "transacciones.trs_id",
                              "transacciones.trs_tipo",
                              "transacciones.trs_descripcion",
                              "transacciones.trs_cantidad",
                              "transacciones.trs_fechai",
                              
                              "transacciones.tps_id",
                              "categorias.cat_id",
                              "categorias.cat_nom",
                              "usuarios.usr_id"],
                              ["usuarios.usr_id"=>$id,"ORDER"=>"transacciones.trs_fechai"

                            ]);

                            foreach($trs as $key => $trs){
                                
                          ?>
                         
                          <tr>
                            <td><?php echo $trs["cat_nom"];?></td>
                            <td><?php if($trs["tps_id"]==1){
                              echo "Ingresos";
                            }else{
                              echo "Gastos";
                            }?></td>
                            <td><?php echo $trs["trs_descripcion"];?></td>
                            <th><?php echo $trs["trs_cantidad"];?></th>
                            <th><?php echo $trs["trs_fechai"];?></th>
                            <td>
                              <a href="#" class="editar_trs" data-id="<?php echo $trs["trs_id"];?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                              </a>
                            </td>
                            <td>
                              <a href="#" class="eliminar_trs" data-id="<?php echo $trs["trs_id"];?>">
                              <i class="fa fa-trash-o" aria-hidden="true"></i>
                              </a>
                            </td>
                          </tr>
                          <?php
                          }
                          /*<tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                          </tr>
                          <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter       </td>
                          </tr>*/
                           ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <footer class="footer">
            <div class="footer__block block no-margin-bottom">
              <div class="container-fluid text-center">
                <!-- Please do not remove the backlink to us unless you support us at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                <p class="no-margin-bottom">2019 &copy; Your company. Design by <a href="https://bootstrapious.com/p/bootstrap-4-dark-admin">Bootstrapious</a>.</p>
              </div>
            </div>
          </footer>
        </div>
      </div>
      <!-- JavaScript files-->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/popper.js/umd/popper.min.js"> </script>
      <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
      <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
      <script src="vendor/chart.js/Chart.min.js"></script>
      <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
      <script src="js/front.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
      <script src="js/main.js"></script>
    </body>
</html>
<!-- Modal-->
<div id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div id="registro-content"class="modal-content">
      <div class="modal-header"><strong id="exampleModalLabel" class="modal-title">Agregar Transacciones</strong>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <p></p>
        <form id="formulario">
          <div class="form-group">
            <label>Tipo</label>
            <input id="num" type="text" class=" form-control-lg" placeholder="User" aria-label="Username" aria-describedby="basic-addon1" required="0" hidden="1" value="<?php echo $id?>">
            <select id="tipo" class="form-control">
            
                   <option value="0">Seleccionar tipo</option>
                    <?php 
                            $cat = $db->select("categorias","*"); 
                            foreach ($cat as $key => $cat) {
                        ?>
                                <option data-categoria="<?php echo $cat["tps_id"]?>" value="<?php echo $cat["cat_id"]?>"><?php echo $cat["cat_nom"]?></option>
                        <?php
                            }
                        ?>
                   </select>
          </div>
          <div class="form-group" >
          <label>Categoria</label>
            <select id="categoria"  class="form-control" disabled>
            
                   <option value="0">Seleccionar Categoria</option>
                    <?php 
                            $cat = $db->select("tipos","*"); 
                            foreach ($cat as $key => $cat) {
                        ?>
                                <option  value="<?php echo $cat["tps_id"]?>"><?php echo $cat["tps_nom"]?></option>
                        <?php
                            }
                        ?>
                   </select>
          </div>
          <div class="form-group">
            <label>Cantidad</label>
            <input type="number" value="0" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="cantidad" />
          </div>
          <div class="form-group">
            <label>Descripcion</label>
            <input type="text" id="descripcion" placeholder="Descripcion" class="form-control">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
        <button type="button" id="guardar_trs" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
