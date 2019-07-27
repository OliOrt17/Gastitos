$(document).ready(function(){
//CERRAR SESION
$("#logout").click(function(){
    let obj={
        "accion":"cerrar_sesion"
    }

    $.ajax({
        url:"backend/includes/_funciones.php",
        datatype:"json",
        type:"post",
        data:obj,
        success:function(data){
            if(data==1){
              alert("sesion cerrada");
              location.href="login.php";
            }else{
              alert("Ocurrio un error vuelva a intentarlo");
            }
        }
    })
});

//Login
$("#login").click(function(){
  let user=$("#login-username").val();
  let pass=$("#login-password").val();
  
  let obj={
    "accion":"login",
    "user":user,
    "pass":pass
  }
  $.ajax({
    url:"backend/includes/_funciones.php",
    datatype:"json",
    type:"post",
    data:obj,
    success:function(data){
      if(data==0){
        alert("El usuario es incorrecto");
      }else if(data==1){
        alert("Exito");
        setTimeout(function(){ location.href='index.php'; }, 2000);
      }else{
        alert("contraseña incorreta");
      }
    }
  })
});

//BOTON ACTIVAR FORMULARIO
$("#nuevo").click(function(){
  //alert("puto");
  $("#modal").modal("show");
  $("#formulario").trigger("reset");
});

//BOTON EXPORTAR
$("#export").click(function(){
  //alert("puto");
  /*let obj = {
        "accion" : "exportar",
    }

  $.ajax({
      url: "backend/includes/_funciones.php",
      type: "POST",
      dataType: "json",
      data: obj,
      success: function(data){
          if(data==1){alert("logrado");}else{alert("no logrado");}
      }
  })*/
});

//DEPARTAMENTOS
$("#guardarDep").click(function(){
  //alert("puto");
  nom=$("#nom").val();
  obj={
    accion: "insertar_depto",
    nom: nom
  }

  if($(this).data("edicion")==1){
  obj["accion"]="editar_depto";
     obj["id"]=$(this).data("id");
   $(this).removeData("edicion").removeData("id");
  }

  if(nom==""){
    alert("No dejes campos vacios");
    return;
  }else{
    $.ajax({
      url: "backend/includes/_funciones.php",
      type: "post",
      datatype: "json",
      data: obj,
      success: function(data){
        if(data==1){}
      }
    })
    location.reload();
  }
});

//BOTON DE EDICION depto
$(document).on("click", ".editar_depto", function(){
  id=$(this).data("id");
  obj={
    "accion" : "consultar_depto",
    "id" : $(this).data("id")
  }
  $.post("backend/includes/_funciones.php", obj, function(data){
    $("#nom").val(data.dpto_nom);
  }, "JSON");
  $("#guardarDep").text("Actualizar").data("edicion", 1).data("id", id);
  $(".modal-title").text("Editar Departamento");
  $("#modal").modal("show");

});

$(document).on("click", ".eliminar_depto", function(){
  id=$(this).data("id");
  let obj = {
        "accion" : "eliminar_depto",
        "id" : id
    }

  $.ajax({
      url: "backend/includes/_funciones.php",
      type: "POST",
      dataType: "json",
      data: obj,
      success: function(data){
          if(data==1){alert("logrado");}else{alert("no logrado");}
      }
  })
  location.reload();
});

//EQUIPO
$("#guardarEpo").click(function(){
  //alert("puto 23");
  nom=$("#nom").val();
  snu=$("#snu").val();
  lista=$("#lista").val();
  obj={
    accion: "insertar_equipo",
    nom: nom,
    snu: snu,
    lista: lista
  }

  if($(this).data("edicion")==1){
  obj["accion"]="editar_equipo";
     obj["id"]=$(this).data("id");
   $(this).removeData("edicion").removeData("id");
  }

  if(nom == "" || snu=="" || lista==0){
    alert("No dejes campos vacios");
    return;
  }else{
    $.ajax({
      url: "backend/includes/_funciones.php",
      type: "post",
      datatype: "json",
      data: obj,
      success: function(data){
        if(data==1){alert("skrull");}
      }
    })

  }
  location.reload();
});

$(document).on("click", ".editar_equipo", function(){
  id=$(this).data("id");
  obj={
    "accion" : "consultar_equipo",
    "id" : $(this).data("id")
  }
  $.post("backend/includes/_funciones.php", obj, function(data){
    $("#nom").val(data.epo_nom);
    $("#snu").val(data.epo_sn);
  }, "JSON");

  $("#guardarEpo").text("Actualizar").data("edicion", 1).data("id", id);
  $(".modal-title").text("Editar Equipo");
  $("#modal").modal("show");

});

$(document).on("click", ".eliminar_equipo", function(){
  id=$(this).data("id");
  let obj = {
        "accion" : "eliminar_equipo",
        "id" : id
    }

  $.ajax({
      url: "backend/includes/_funciones.php",
      type: "POST",
      dataType: "json",
      data: obj,
      success: function(data){
          if(data==1){alert("logrado");}else{alert("no logrado");}
      }
  })
  location.reload();
});



//ADMINISTRADORES
$("#guardarAdm").click(function(){
  //alert("puto 45");
  nom=$("#nom").val();
  email=$("#email").val();
  pass=$("#pass").val();
  obj={
    accion: "insertar_admin",
    nom: nom,
    email: email,
    pass:pass
  }

  if($(this).data("edicion")==1){
  obj["accion"]="editar_admin";
     obj["id"]=$(this).data("id");
   $(this).removeData("edicion").removeData("id");
  }

  if(nom=="" || email=="" || pass==""){
    alert("No dejes campos vacios");
    return;
  }else{
    $.ajax({
      url: "backend/includes/_funciones.php",
      type: "post",
      datatype: "json",
      data: obj,
      success: function(data){
        if(data==1){alert("djfhad");}
      }
    })
    location.reload();
  }
});

$(document).on("click", ".editar_admin", function(){
  id=$(this).data("id");
  obj={
    "accion" : "consultar_admin",
    "id" : $(this).data("id")
  }
  $.post("backend/includes/_funciones.php", obj, function(data){
    $("#nom").val(data.adm_nom);
    $("#email").val(data.adm_email);
    $("#pass").val(data.adm_pass);
  }, "JSON");

  $("#guardarAdm").text("Actualizar").data("edicion", 1).data("id", id);
  $(".modal-title").text("Editar Administrador");
  $("#modal").modal("show");

});

$(document).on("click", ".eliminar_admin", function(){
  id=$(this).data("id");
  let obj = {
        "accion" : "eliminar_admin",
        "id" : id
    }

  $.ajax({
      url: "backend/includes/_funciones.php",
      type: "POST",
      dataType: "json",
      data: obj,
      success: function(data){
          if(data==1){alert("logrado");}else{alert("no logrado");}
      }
  })
  location.reload();
});


//USUARIOS
$("#guardarUsr").click(function(){
  //alert("puto 45");
  nom=$("#nom").val();
  lista=$("#lista").val();
  pto=$("#pto").val();
  obj={
    accion: "insertar_user",
    nom: nom,
    lista: lista,
    pto:pto
  }

  if($(this).data("edicion")==1){
  obj["accion"]="editar_user";
     obj["id"]=$(this).data("id");
   $(this).removeData("edicion").removeData("id");
  }

  if(nom=="" || lista==0 || pto==""){
    alert("No dejes campos vacios");
    return;
  }else{
    $.ajax({
      url: "backend/includes/_funciones.php",
      type: "post",
      datatype: "json",
      data: obj,
      success: function(data){
        if(data==1){alert("djfhad");}
      }
    })
    location.reload();
  }
});

$(document).on("click", ".editar_user", function(){
  id=$(this).data("id");
  obj={
    "accion" : "consultar_user",
    "id" : $(this).data("id")
  }
  $.post("backend/includes/_funciones.php", obj, function(data){
    $("#nom").val(data.per_nom);
    $("#pto").val(data.per_pto);
  }, "JSON");

  $("#guardarUsr").text("Actualizar").data("edicion", 1).data("id", id);
  $(".modal-title").text("Editar Colaborador");
  $("#modal").modal("show");

});

$(document).on("click", ".eliminar_user", function(){
  id=$(this).data("id");
  let obj = {
        "accion" : "eliminar_user",
        "id" : id
    }

  $.ajax({
      url: "backend/includes/_funciones.php",
      type: "POST",
      dataType: "json",
      data: obj,
      success: function(data){
          if(data==1){alert("logrado");}else{alert("no logrado");}
      }
  })
  location.reload();
});

//FIN DOCUMENT READY
});
