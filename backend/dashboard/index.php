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
    <title>Gastitos | Inicio </title>
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
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <header class="header">
      <nav class="navbar navbar-expand-lg">
        <div class="search-panel">
          <div class="search-inner d-flex align-items-center justify-content-center">
            <div class="close-btn">Cerrar <i class="fa fa-close"></i></div>
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
            <h1 class="h5"><?php $id=$_SESSION['USR_ID'];
              $usr = $db->select("usuarios","*",["usr_id"=>$id]);
               foreach($usr as $key => $usr){
                 echo $usr["usr_nom"];
               }
              ?></h1>
          
          </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Modulos</span>
        <ul class="list-unstyled">
          <li class="active"><a href="index.php"> <i class="icon-home"></i>Inicio </a></li>
          <li><a href="usuarios.php"> <i class="icon-user"></i>Usuarios </a></li>
          <li><a href="categorias.php"> <i class="icon-computer"></i>Categorias </a></li>
          <li><a href="transacciones.php"> <i class="icon-paper-and-pencil"></i>Transacciones </a></li>
          <li><a href="clientes.php"> <i class="icon-user"></i>clientes </a></li>
            <li ><a href="proyectos.php"> <i class="icon-computer"></i>proyectos</a></li>
            <li ><a href="tareas.php"> <i class="icon-paper-and-pencil"></i>Tareas</a></li>
      </nav>
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Principal</h2>
          </div>
        </div>
        <section class="no-padding-top no-padding-bottom">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-user-1"></i></div><strong>Tarea</strong>
                    </div>
                    <div class="number dashtext-1"><?php 
              $tar=$db->query(
                "SELECT sum(tareas.tar_precio) as precio, cliente.usr_id
                FROM tareas
                inner join proyectos using(pro_id)
                inner join cliente on proyectos.cli_id = cliente.cli_id
                where tareas.tar_status=0 and cliente.usr_id=$id"
      
              )->fetchAll();
              foreach($tar as $key => $tar){
                $pre=$tar["precio"];
              }
              echo round($pre,2);
               ?></div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: 55% "aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-1"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-contract"></i></div><strong>Ingresos</strong>
                    </div>
                    <div class="number dashtext-2"><?php $trs=$db->sum("transacciones","trs_cantidad",["tps_id"=>1,"usr_id"=>$id]);
                    echo round($trs,2);?></div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-2"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-paper-and-pencil"></i></div><strong>Gastos</strong>
                    </div>
                    <div class="number dashtext-3"><?php $t=$db->sum("transacciones","trs_cantidad",["tps_id"=>2,"usr_id"=>$id]);
                    echo round($t,2);?></div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-3"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-writing-whiteboard"></i></div><strong>Balance</strong>
                    </div>
                    <div class="number dashtext-4"><?php $result=round($trs-$t,2);
                    if($result>0){echo "<font color='greed'>".$result."</font>";}else{echo "<font color='red'>".$result."</font>";}?> </div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template "></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      
        <section class="no-padding-top">
            <div class="container-fluid">
              <div class="row">
                <!--Ingreso-->
                <div class="col-lg-6 col-md-12">
                <div class="title">
                  <h2> &nbsp; &nbsp;    &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; Ingresos  &nbsp; <button id="nuevo" type="button" class="btn btn-primary">Nuevo</button></h2>
                     
                    </div>
                   
                    <br>
                  <div class="block">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="table_datos">
                        <thead>
                          <tr>
                            <th>Categoria</th>
                            <th>Monto</th>
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
                              ["usuarios.usr_id"=>$id,"transacciones.tps_id"=>1

                            ]);

                            foreach($trs as $key => $trs){
                                
                          ?>
                         
                          <tr>
                            <td><?php echo $trs["cat_nom"]."-".$trs["trs_descripcion"];?></td>
                            <th><?php echo $trs["trs_cantidad"];?></th>
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
                <!--Gastos-->
                <div class="col-lg-6 col-md-12">
                <div class="title">
                  <h2> &nbsp; &nbsp;    &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; Gastos &nbsp; <button id="nuevo_gas" type="button" class="btn btn-primary">Nuevo</button></h2>
                     
                    </div>
                   
                    <br>
                  <div class="block">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="table_datos">
                        <thead>
                          <tr>
                            <th>Categoria</th>
                            <th>Monto</th>
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
                              ["usuarios.usr_id"=>$id, "transacciones.tps_id"=>2

                            ]);

                            foreach($trs as $key => $trs){
                                
                          ?>
                         
                          <tr>
                            <td><?php echo $trs["cat_nom"]."-".$trs["trs_descripcion"];?></td>
                            <th><?php echo $trs["trs_cantidad"];?></th>
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
          <section class="no-padding-top">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="block">
                    <div class="title">
                      <strong>Tareas &nbsp; &nbsp;</strong>
                     
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="table_datos">
                        <thead>
                          <tr>
                            <th>Cliente</th>
                            <th>Proyecto</th>
                            <th>Descripcion</th>
                            <th>Tiempo</th>
                            <th>Pago</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $tar = $db->query(
                              "SELECT tareas.tar_id,tareas.tar_descripcion, tareas.tar_dif, tareas.tar_precio,proyectos.pro_nom, cliente.cli_nom, cliente.usr_id
                              FROM tareas
                              inner join proyectos using(pro_id)
                              inner join cliente on proyectos.cli_id = cliente.cli_id
                              where tareas.tar_status=0 and cliente.usr_id=$id "

                            )->fetchAll();
                            foreach($tar as $key => $tar){
                              
                          ?>
                            
                          <tr>
                            <td><?php echo $tar["cli_nom"];?></td>
                            <td><?php echo $tar["pro_nom"];?></td>
                            <td><?php echo $tar["tar_descripcion"];?></td>
                            
                            <td><?php echo round($tar["tar_dif"]/3600,4)." HRS";?></td>
                            <td><?php echo "$".round($tar["tar_precio"],2);?></td>
                            
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
              <p class="no-margin-bottom">2019 &copy; Sistemita. Design by <a href="https://bootstrapious.com/p/bootstrap-4-dark-admin">Bootstrapious</a>.</p>
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
    <script src="js/charts-home.js"></script>
    <script src="js/front.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="js/main.js"></script>
    
  </body>
</html>
<!-- Modal-->
<div id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div id="registro-content"class="modal-content">
      <div class="modal-header"><strong id="exampleModalLabel" class="modal-title">Agregar Ingresos</strong>
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
                            $cat = $db->select("categorias","*",["tps_id"=>1]); 
                            foreach ($cat as $key => $cat) {
                        ?>
                                <option  value="<?php echo $cat["cat_id"]?>"><?php echo $cat["cat_nom"]?></option>
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
            <input type="text" id="descripcion" placeholder="Tipo" class="form-control">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
        <button type="button" id="guardar_ing" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal-->
<div id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div id="registro-content"class="modal-content">
      <div class="modal-header"><strong id="exampleModalLabel" class="modal-title">Agregar Gastos</strong>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <p></p>
        <form id="formulario">
          <div class="form-group">
            <label>Tipo</label>
            <input id="num" type="text" class=" form-control-lg" placeholder="User" aria-label="Username" aria-describedby="basic-addon1" required="0" hidden="1" value="<?php echo $id?>">
            <select id="tipo1" class="form-control">
            
                   <option value="0">Seleccionar tipo</option>
                    <?php 
                            $cat = $db->select("categorias","*",["tps_id"=>2]); 
                            foreach ($cat as $key => $cat) {
                        ?>
                                <option  value="<?php echo $cat["cat_id"]?>"><?php echo $cat["cat_nom"]?></option>
                        <?php
                            }
                        ?>
                   </select>
          </div>
          
          <div class="form-group">
            <label>Cantidad</label>
            <input type="number" value="0" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="cantidad1" />
          </div>
          <div class="form-group">
            <label>Descripcion</label>
            <input type="text" id="descripcion1" placeholder="Tipo" class="form-control">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
        <button type="button" id="guardar_gas" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>