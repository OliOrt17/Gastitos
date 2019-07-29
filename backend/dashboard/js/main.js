$(document).ready(function(){
  $("#login").on("click",function(e){
    e.preventDefault();
    let email=$("#email").val();
    let password=$("#password").val();
    
    let obj={
        "accion":"login",
        "user":email,
        "password":password
    }

    if(email.length==0 || password.length==0){
        
    }else{
        $.ajax({
            url:"includes/_funciones.php",
            datatype:"json",
            type:"post",
            data:obj,
            success:function(data){
                if(data==0){
                  $.notify("El usuario es incorrecto","error");
                }else if(data==1){
                  $.notify("Exito","success");
                  $.notify("espere un momento", "info");
                  setTimeout(function(){ location.href='dashboard/index.php'; }, 2000);
                }else{
                  $.notify("contraseña incorreta","error");
                }
            }
        })
    }
});
$("#signup-btn").on('click', function(e){
    $('#signup-content').show();
    $('#recuperar-content').hide();
e.preventDefault();		
});
$("#recuperar-btn").on('click', function(e){
    $('#recuperar-content').show();
$('#signup-content').hide();
e.preventDefault();		
});

$("#registrar").on("click",function(e){
    e.preventDefault();

    let nom=$("#nom").val();
    let email=$("#email1").val();
    let password=$("#password1").val();
    let ver={
      "accion":"verificar_usr",
      "email":email
    }
    let obj={
        "accion": "registrar",
        "nombre": nom,
        "email": email,
        "password": password
    }
    if(email.length==0 || password.length==0){
      Swal.fire({
        type: 'error',
        title: 'Oops...',
        text: 'No dejes campos vacios!'
      })
    }else{
      $.ajax({
        url:"includes/_funciones.php",
        datatype:"json",
        type:"post",
        data:ver,
        success:function(data){
          if(data==1){
            $.ajax({
              url:"includes/_funciones.php",
              datatype:"json",
              type:"post",
              data:obj,
              success:function(data){
                if(data==1){
                  $.notify("registro exito","success");
                  setTimeout(function(){ location.href='index.html'; }, 2000);
                }else{
                  Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Intentalo de nuevo!'
                  })
                }
              }
            })
          }else{
            Swal.fire({
              type: 'error',
              title: 'Oops...',
              text: 'Este usuario ya existe intentalo con otro!'
            })
          }
        }
      })
    }

});

//recuperar
$("#recuperar").on("click",function(e){
    e.preventDefault();

    let email=$("#email3").val();

    let obj={
        "accion": "recuperar",
        "email": email
    }
    if(email.length==0){
        
    }else{
        $.ajax({
            url:"includes/_funciones.php",
            datatype:"json",
            type:"post",
            data:obj,
            success:function(data){
                if(data==1){
                    $.notify("Se te envio un enlace a tu email","success");
                    setTimeout(function(){ location.href='recuperar.php'; }, 3000);
                }else{
                  $.notify("Este usuario no exite","error");
                }
            }
        })
    }

});


//comentario
$("#comentario").on("click",function(e){
    e.preventDefault();
    alert("lffdkjl");
    let nom=$("#nom").val();
    let email=$("#email").val();
    let asunto=$("#asunto").val();
    let mensaje=$("#mensaje").val();

    let obj={
        "accion":"comentario",
        "nombre":nom,
        "email":email,
        "asunto":asunto,
        "mensaje":mensaje
    }

    $.ajax({
        url:"backend/includes/_funciones.php",
        datatype:"json",
        type:"post",
        data:obj,
        success:function(data){
            if(data==1){
                $.notify("su mensaje fue enviado","success");
            }
        }

    })
});

//actualizar contraseña
$("#actualizar").on("click",function(e){
    e.preventDefault();
    let pass=$("#password").val();
    let pass1=$("#password1").val();
    
    if(pass==pass1){
        let obj={
            "accion":"actualizar",
            "password":pass
        }
        $.ajax({
            url:"includes/_funciones.php",
            datatype:"json",
            type:"post",
            data:obj,
            success:function(data){
                if(data==1){
                    $.notify("Tu contraseña fue actualizada","success");
                }else{
                    $.notify("Intentelo mas tarde","error");
                }
            }

        });
    }else{
        $.notify("La contraseña no concide","error");
    }
});

//cerrar sesion
$("#logout").on("click",function(e){
    e.preventDefault();
    let obj={
        "accion":"cerrar_sesion"
    }

    $.ajax({
        url:"../includes/_funciones.php",
        datatype:"json",
        type:"post",
        data:obj,
        success:function(data){
            if(data==1){
              Swal.fire(
                'Sesion cerrada!',
                'Presione el boton!',
                'success'
              )
              setTimeout(function(){ location.href='../index.html'; }, 3000);
            }else{
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Algo salio mal!'
                  })
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

  //cambiar el status de usuarios
  $("#status_usr").on("click",function(){
      
    let id=$(this).data("id");
    console.log(id);
    let obj={
        "accion":"status_usr",
        "id" : id
    }

    $.ajax({
        url:"../includes/_funciones.php",
        datatype: "json",
        type: "post",
        data: obj,
        success: function(data){
            if(data==1){
                alert("jsjsjh");
            }else{
                alert("yyuuy");
            }
        }
    })
  });

  //usuarios
  $(".eliminar_usr").on("click", function(e){
      e.preventDefault();

    let id=$(this).data("id");
    let obj = {
          "accion" : "eliminar_usr",
          "id" : id
      }
      Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Registro eliminado!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: "../includes/_funciones.php",
            type: "POST",
            dataType: "json",
            data: obj,
            success: function(data){
              if(data==1){
                location.reload();
                
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                
              }
            }
          })
  
        }else{
          Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Algo salio mal!'
          })
        }
      })
  });
    function mostrar_usr(){
        let obj = {
        "accion" : "mostrar_usr"
        }
        
        $.post("../includes/_funciones.php",obj, function(data){
        let template = ``; 
        $.each(data, function(e,elem){
            template += `
            <tr>
            <td>${elem.usr_nom}</td>
            <td>${elem.usr_email}</td>
            <td>${elem.usr_fechai}</td>
            <td> 
            <?php 
                if($usr["usr_status"]==1){
                 echo '<a id="status_usr" href="#"> <i class="fa fa-circle" aria-hidden="true" style="color:green" ></i></a>';
                } else if($usr["usr_status"]==0){
                     echo '<a id="status_usr" href="#"><i class="fa fa-circle" aria-hidden="true" style="color:red" ></i></a>';
                }  
            ?>
          </td>
            <td>
            <a href="#" class="editar_usr"data-id="${elem.usr_id}"><i class="fas fa-edit"></i></a>
            </td>
        <td>
            <a href="#" class="eliminar_usr" data-id="${elem.usr_id}"><i class="fas fa-trash"></i></a></td>
            </tr>
            `;
        });
        $("#table_datos tbody").html(template);
        },"JSON");      
    }
   
  
  $("#guardar_usr").click(function(){
    let nombre=$("#nom").val();
    let email=$("#email").val();
    let password=$("#pass").val();

    let obj={
      "accion":"insertar_usr",
      "nombre": nombre,
      "email":email,
      "password":password
    }
    
    if($(this).data("edicion")==1){
      obj["accion"]="editar_usr";
      obj["id"]=$(this).data("id");
      $(this).removeData("edicion").removeData("id");
    }if(nombre=="" || email=="" || password==""){
      alert("No dejes campos vacios");
      return;
    }else{
      $.ajax({
        url: "../includes/_funciones.php",
        type: "POST",
        dataType: "json",
        data: obj,
        success: function(data){
          if(data==1){
            location.reload();
            $("#modal").modal("hide");
            
            Swal.fire(
              'Registro exitoso!',
              'Presione el boton!',
              'success'
              
            )
            
          }else if(data==2){
            location.reload();
            $("#modal").modal("hide");
            
            Swal.fire(
              'Registro fue actualizado!',
              'Presione el boton!',
              'success'
              
            )
          }else{
            
            Swal.fire({
              type: 'error',
              title: 'Oops...',
              text: 'Algo salio mal!'
            })
          }

        }
      })
    }

  });
  $(document).on("click", ".editar_usr", function(){
    id=$(this).data("id");
    obj={
      "accion" : "consultar_usr",
      "id" : $(this).data("id")
    }
    $.post("../includes/_funciones.php", obj, function(data){
      $("#nom").val(data.usr_nom);
      $("#email").val(data.usr_email);
      $("#pass").val(data.usr_password);
    }, "JSON");
  
    $("#guardar_usr").text("Actualizar").data("edicion", 1).data("id", id);
    $(".modal-title").text("Editar usuarios");
    $("#modal").modal("show");
  
  });

  //categoria
  $(".eliminar_cat").on("click", function(e){
    e.preventDefault();

  let id=$(this).data("id");
  let obj = {
        "accion" : "eliminar_cat",
        "id" : id
    }
    Swal.fire({
      title: '¿Estás seguro?',
      text: "¡No podrás revertir esto!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Registro eliminado!'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "../includes/_funciones.php",
          type: "POST",
          dataType: "json",
          data: obj,
          success: function(data){
            if(data==1){
              mostrar_cat();
              
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
              
            }
          }
        })

      }else{
        Swal.fire({
          type: 'error',
          title: 'Oops...',
          text: 'Algo salio mal!'
        })
      }
    })
});
  function mostrar_cat(){
      let obj = {
      "accion" : "mostrar_cat"
      }
      
      $.post("../includes/_funciones.php",obj, function(data){
      let template = ``; 
      $.each(data, function(e,elem){
          template += `
          <tr>
          <td>${elem.cat_nom}</td>
          <td>${elem.cat_tipo}</td>
          <td>${elem.cat_fechai}</td>
          <td>
          <a href="#" class="editar_cat"data-id="${elem.cat_id}"><i class="fa fa-pencil-square-o"></i></a>
          </td>
      <td>
          <a href="#" class="eliminar_cat" data-id="${elem.cat_id}"><i class="fa fa-trash-o"></i></a></td>
          </tr>
          `;
      });
      $("#table_datos tbody").html(template);
      },"JSON");      
  }
 

$("#guardar_cat").click(function(){
  let nombre=$("#nom").val();
  let tipo=$("#lista").val();

  let obj={
    "accion":"insertar_cat",
    "nombre": nombre,
    "tipo":tipo
  }
  
  if($(this).data("edicion")==1){
    obj["accion"]="editar_cat";
    obj["id"]=$(this).data("id");
    $(this).removeData("edicion").removeData("id");
  }if(nombre==""){
    alert("No dejes campos vacios");
    return;
  }else{
    $.ajax({
      url: "../includes/_funciones.php",
      type: "POST",
      dataType: "json",
      data: obj,
      success: function(data){
        if(data==1){
          
          $("#modal").modal("hide");
          
          Swal.fire(
            'Registro exitoso!',
            'Presione el boton!',
            'success'
            
          )
          mostrar_cat();
        }else if(data==2){
          
          $("#modal").modal("hide");
          
          Swal.fire(
            'Registro fue actualizado!',
            'Presione el boton!',
            'success'
            
          )
          mostrar_cat();
        }else{
          
          Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Algo salio mal!'
          })
        }

      }
    })
  }

});
$(document).on("click", ".editar_cat", function(){
  id=$(this).data("id");
  obj={
    "accion" : "consultar_cat",
    "id" : $(this).data("id")
  }
  $.post("../includes/_funciones.php", obj, function(data){
    $("#nom").val(data.cat_nom);
    $("#lista").val(data.cat_tipo);
  }, "JSON");

  $("#guardar_cat").text("Actualizar").data("edicion", 1).data("id", id);
  $(".modal-title").text("Editar categorias");
  $("#modal").modal("show");

});
//FIN DOCUMENT READY
});
