$(document).ready(function(){
  var t;
  var tiempo;
  var precio;

  $('.start-timer-btn').on('click',function(){
    $('.timer').timer();
  });
  $('.resume-timer-btn').on('click',function(){
    $('.timer').timer("resume");
  });

  $('.pause-timer-btn').on('click',function(){
    $('.timer').timer("pause");
     tiempo=$("#timer").val().split(":").join(".");
    
     t=parseFloat(tiempo);
    
  });

  $('.remove-timer-btn').on('click',function(){
    $('.timer').timer("remove");
    $('.timer').timer();

  });

  //tareas
  $("#guardar_tar").click(function(){
    let to; //Conversion de minutos a segundos
    let fe; //para insertar tiempo
    if(tiempo.indexOf('min')!=-1){
      to=t*60;
    }if(tiempo.indexOf('sec')!=-1){
      to=t;
    }

    if(tiempo.indexOf('min')!=-1){
     if(t<10){
      fe="00:0"+t.toString().split(".").join(":");
     }else{
      fe="00:"+t.toString().split(".").join(":");
     }
    }
    if(tiempo.indexOf('sec')!=-1){
      if(t<10){
        fe="00:"+"00:0"+t;
      }else{
        fe="00:"+"00:"+t;
      }
    }
    
    let cliente=$("#cliente").val();
    let proyecto=$("#proyecto").val();
    let descripcion=$("#descripcion").val();
    precio = precio/3600;
    
    let pago = precio*to;
    
    let obj={
      "accion":"insertar_tar",
      "cliente":cliente,
      "proyecto":proyecto,
      "fe":fe,
      "descripcion":descripcion,
      "pago":pago
      
    }
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
          setTimeout(function(){ location.reload();}, 3000);
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

  $("#proyecto").change(function(){
    precio=$(this).find("option:selected").data("proyecto");
  });
  $(".eliminar_tar").on("click", function(){
  

    let id=$(this).data("id");
    let obj = {
          "accion" : "eliminar_tar",
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
                  'Booom!',
                  'Registro eliminado.',
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


  //gastos
  $("#guardar_gas").click(function(){
    let tipo=$("#tipo1").val();
    let cantidad=$("#cantidad1").val();
    let descripcion=$("#descripcion1").val();
    let num=$("#num").val();

    let obj={
      "accion":"gastos",
      "tipo":tipo,
      "cantidad":cantidad,
      "descripcion":descripcion,
      "num":num
    };

    $.ajax({
      url: "../includes/_funciones.php",
      type: "POST",
      dataType: "json",
      data: obj,
      success: function(data){
        if(data==1){
          
          $("#modal1").modal("hide");
          
          Swal.fire(
            'Registro exitoso!',
            'Presione el boton!',
            'success'
            
          )
          setTimeout(function(){ location.reload();}, 3000);
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

  $("#guardar_ing").click(function(){
    let tipo=$("#tipo").val();
    let cantidad=$("#cantidad").val();
    let descripcion=$("#descripcion").val();
    let num=$("#num").val();

    let obj={
      "accion":"ingresos",
      "tipo":tipo,
      "cantidad":cantidad,
      "descripcion":descripcion,
      "num":num
    };

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
          setTimeout(function(){ location.reload();}, 3000);
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

  $("#precio").click(function(e){
    e.preventDefault();
    let nom=$("#nombre").val();
    let email=$("#correo").val();
    let password=$("#contraseña").val();
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
    if(email.length==0 ){
      Swal.fire({
        type: 'error',
        title: 'Oops...',
        text: 'No dejes campos vacios!'
      })
    }else{
      $.ajax({
        url:"backend/includes/_funciones.php",
        datatype:"json",
        type:"post",
        data:ver,
        success:function(data){
          if(data==1){
            $.ajax({
              url:"backend/includes/_funciones.php",
              datatype:"json",
              type:"post",
              data:obj,
              success:function(data){
                if(data==1){
                  $.notify("registro exito","success");
                  setTimeout(function(){ location.href='backend/index.html'; }, 2000);
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
  //Cargar imagen
$("#archivo").change(function(){
  let formDatos=new FormData($("#formulario")[0]);
  formDatos.append("accion", "carga_foto");
  $.ajax({
      url: "../includes/_funciones.php",
      type: "POST",
      data: formDatos,
      contentType:false,
      processData:false,
      success: function(datos){
          let respuesta = JSON.parse(datos);
          if(respuesta.status==0){
              alert("No se guardo la foto");
          }
          let imagen=`
              <img src="${respuesta.archivo}" alt="img-fluid"/>
              `;
          $("#foto").val(respuesta.archivo);
          $("#respuesta").html(imagen);
      }
  });
  console.log(formDatos);
}); 

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
              console.log(data);
                if(data.status==0){
                  $.notify("El usuario es incorrecto","error");
                }else if(data.status==1){
                  setTimeout(function(){ location.href='dashboard/index.php'; }, 2000);
                  $.notify("Exito","success");
                  $.notify("espere un momento", "info");
                }else if(data.status==2){
                  $.notify("contraseña incorreta","error");
                }else{
                  $.notify("Tu cuenta esta inactiva, comuniquese con el administrador","error");
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
              console.log("conexion correcta", data);
                if(data.status==1){
                  obj['accion']="insertToken";
                  console.log("insertamos token");
                  $.ajax({
                    url:"includes/_funciones.php",
                    datatype:"json",
                    type:"post",
                    data:obj,
                    success:function(data){
                      console.log(data.status);
                      if(data.status!=1){
                        Swal.fire({
                          type: 'error',
                          title: 'Oops...',
                          text: 'Error en la verificacion!'
                        })
                      }else{
                        obj["token"]=data.token;
                        console.log("enviamos correo");
                        $.ajax({
                          url:"sendRecovery.php",
                          datatype:"json",
                          type:"post",
                          data:obj,
                          success:function(data){
                            if(data.status!=1){
                              if(data!=1){
                                Swal.fire({
                                  type: 'error',
                                  title: 'Oops...',
                                  text: 'Ocurrio un problema en el proceso!'
                                })
                              }else{
                                
                                Swal.fire({
                                  type: 'success',
                                  title: 'Oops...',
                                  text: 'mensaje enviado'
                                })
                                setTimeout(function(){ location.href='index.html'; }, 3000);
                              }
                            }
                          }
                        })
                        
                           
                      }
                    }
                  })
                }else{
                  Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Este user no existe!'
                  })
                
                }
            }
        })
    }

});
//actualizar contraseña
$("#actualizar").on("click",function(e){
  e.preventDefault();
  let pass=$("#password").val();
  let pass1=$("#password1").val();
  let id=$("#num").val();
  if(pass==pass1){
      let obj={
          "accion":"actualizar",
          "id":id,
          "pass":pass
      }
      $.ajax({
          url:"includes/_funciones.php",
          datatype:"json",
          type:"post",
          data:obj,
          success:function(data){
              if(data==1){
                Swal.fire(
                  'Genial!',
                  'Contraseña actualizada',
                  'success'
                )
                setTimeout(function(){ location.href='index.html'; }, 3000);   
              }else{
                Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: 'Algo salio mal!'
                })
              }
          }

      });
  }else{
    Swal.fire({
      type: 'error',
      title: 'Oops...',
      text: 'La contraseña no coenciden!'
    })
  }
});


//comentario
$("#comentario").on("click",function(e){
    e.preventDefault();
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
        url:"backend/comentarios.php",
        datatype:"json",
        type:"post",
        data:obj,
        success:function(data){
            if(data==1){
              $("#comentarios")[0].reset();
                $.notify("su mensaje fue enviado","success");
            }else{
              $.notify("Ocurrio un error","error");
            }
        }

    })
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
  $("#modal").modal("show");
  $("#formulario").trigger("reset");
});

$("#nuevo_gas").click(function(){
  $("#modal1").modal("show");
  $("#formulario").trigger("reset");
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
                  'BOOOM!',
                  'Registro eliminado',
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
  $("#guardar_usr").click(function(){
    let nombre=$("#nom").val();
    let email=$("#email").val();
    let password=$("#pass").val();
    let foto=$("#foto").val();

    let obj={
      "accion":"insertar_usr",
      "nombre": nombre,
      "email":email,
      "password":password,
      "foto":foto
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
      $("#archivo").val(data.usr_foto);
    }, "JSON");
  
    $("#guardar_usr").text("Actualizar").data("edicion", 1).data("id", id);
    $(".modal-title").text("Editar usuarios");
    $("#modal").modal("show");
  
  });
    //cambiar el status de usuarios
 $("#table_datos").on("change","#status_usr",function(){
      
  let id=$(this).data("id");
  let obj={
      "accion":"cambiar_status",
      "id" : id
  }

  if($(this).is(":checked")){
    obj["status"] = 1;
  }else{
    obj["status"] = 0;
  }

  $.ajax({
      url:"../includes/_funciones.php",
      datatype: "json",
      type: "post",
      data: obj,
      success: function(data){
          if(data==1){
            setTimeout(function(){ location.reload();}, 3000);
           
            Swal.fire(
              'Genial!',
              'Status cambiado',
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
});



  //categoria
  $(".eliminar_cat").on("click", function(){
  

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
              location.reload();
              
              Swal.fire(
                'Booom!',
                'Registro eliminado.',
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
          <td>${elem.tps_nom}</td>
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
          location.reload();
        }else if(data==2){
          
          $("#modal").modal("hide");
          
          Swal.fire(
            'Registro fue actualizado!',
            'Presione el boton!',
            'success'
            
          )
          location.reload();
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
    $("#lista").val(data.tps_id);
  }, "JSON");

  $("#guardar_cat").text("Actualizar").data("edicion", 1).data("id", id);
  $(".modal-title").text("Editar categorias");
  $("#modal").modal("show");

});


//transacciones
 $(".eliminar_trs").on("click", function(e){
  e.preventDefault();

let id=$(this).data("id");
let obj = {
      "accion" : "eliminar_trs",
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
            
            
            Swal.fire(
              'Boooom!',
              'Registro eliminado.',
              'success'
            )
            setTimeout(function(){ location.reload();}, 3000);
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
/*function mostrar_trs(){
  let id=$(this).data("id");
    let obj = {
    "accion" : "mostrar_trs",
    "id":id
    }
    
    $.post("../includes/_funciones.php",obj, function(data){
    let template = ``; 
    $.each(data, function(e,elem){
        template += `
        <tr>
        <td>${elem.trs_tipo}</td>
        <td>${elem.cat_nom}</td>
        <td>${elem.trs_descripcion}</td>
        <td>${elem.trs_cantidad}</td>
        <td>${elem.trs_fechai}</td>
        <td>
        <a href="#" class="editar_trs"data-id="${elem.trs_id}"><i class="fa fa-pencil-square-o"></i></a>
        </td>
    <td>
        <a href="#" class="eliminar_trs" data-id="${elem.cat_trs}"><i class="fa fa-trash-o"></i></a></td>
        </tr>
        `;
    });
    $("#table_datos tbody").html(template);
    },"JSON");      
}
*/
$("#guardar_trs").click(function(){
  let tipo=$("#tipo").val();
  let categoria=$("#categoria").val();
  let cantidad=$("#cantidad").val();
  let descripcion=$("#descripcion").val();
  let num=$("#num").val();

let obj={
  "accion":"insertar_trs",
  "tipo":tipo,
  "categoria":categoria,
  "cantidad":cantidad,
  "descripcion":descripcion,
  "num":num
}

if($(this).data("edicion")==1){
  obj["accion"]="editar_trs";
  obj["id"]=$(this).data("id");
  $(this).removeData("edicion").removeData("id");
}if(tipo==""){
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
        setTimeout(function(){ location.reload();}, 3000);
      }else if(data==2){
        
        $("#modal").modal("hide");
        
        Swal.fire(
          'Registro fue actualizado!',
          'Presione el boton!',
          'success'
          
        )
        setTimeout(function(){ location.reload();}, 3000);
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
$(document).on("click", ".editar_trs", function(){
let id=$(this).data("id");
let obj={
  "accion" : "consultar_trs",
  "id" : $(this).data("id")
}
$.post("../includes/_funciones.php", obj, function(data){
  $("#tipo").val(data.cat_id);
  $("#categoria").val(data.tps_id);
  $("#cantidad").val(data.trs_cantidad);
  $("#descripcion").val(data.trs_descripcion);

}, "JSON");

$("#guardar_trs").text("Actualizar").data("edicion", 1).data("id", id);
$(".modal-title").text("Editar transacciones");
$("#modal").modal("show");

});

$("#tipo").change(function(){
  let categoria=$(this).find("option:selected").data("categoria");
 $("#categoria").val(categoria);
});

//Clientes
$(".eliminar_cli").on("click", function(e){
  e.preventDefault();

let id=$(this).data("id");
let obj = {
      "accion" : "eliminar_cli",
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
              'BOOOM!',
              'Registro eliminado',
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

$("#guardar_cli").click(function(){
  let num=$("#num").val();
let nombre=$("#nom").val();
let email=$("#email").val();
let empresa=$("#empresa").val();
let sitio=$("#sitio").val();
let tel=$("#tel").val();
let ubicacion=$("#ubicacion").val();

let obj={
  "accion":"insertar_cli",
  "nombre": nombre,
  "email":email,
  "empresa":empresa,
  "sitio":sitio,
  "tel":tel,
  "ubicacion":ubicacion,
  "num":num
}

  
  if($(this).data("edicion")==1){
    obj["accion"]="editar_cli";
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
          location.reload();
        }else if(data==2){
          
          $("#modal").modal("hide");
          
          Swal.fire(
            'Registro fue actualizado!',
            'Presione el boton!',
            'success'
            
          )
          location.reload();
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
$(document).on("click", ".editar_cli", function(){
  id=$(this).data("id");
  obj={
    "accion" : "consultar_cli",
    "id" : $(this).data("id")
  }
  $.post("../includes/_funciones.php", obj, function(data){
    $("#nom").val(data.cli_nom);
$("#email").val(data.cli_email);
$("#empresa").val(data.cli_empresa);
$("#sitio").val(data.cli_sitio);
$("#ubicacion").val(data.cli_ubicacion);
$("#tel").val(data.cli_numero);
  }, "JSON");

  $("#guardar_cli").text("Actualizar").data("edicion", 1).data("id", id);
  $(".modal-title").text("Editar clientes");
  $("#modal").modal("show");

});

//proyectos
$("#guardar_pro").click(function(){
  let cliente=$("#cliente").val();
  let nom=$("#nom").val();
  let fecha=$("#fecha").val();
  let precio=$("#precio1").val();

let obj={
  "accion":"insertar_pro",
  "nom":nom,
  "cliente":cliente,
  "fecha":fecha,
  "precio":precio
}

if($(this).data("edicion")==1){
  obj["accion"]="editar_pro";
  obj["id"]=$(this).data("id");
  $(this).removeData("edicion").removeData("id");
}if(cliente==""){
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
        setTimeout(function(){ location.reload();}, 3000);
      }else if(data==2){
        
        $("#modal").modal("hide");
        
        Swal.fire(
          'Registro fue actualizado!',
          'Presione el boton!',
          'success'
          
        )
        setTimeout(function(){ location.reload();}, 3000);
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
$(document).on("click", ".editar_pro", function(){
let id=$(this).data("id");

let obj={
  "accion" : "consultar_pro",
  "id" : $(this).data("id")
}
console.log(obj);
$.post("../includes/_funciones.php", obj, function(data){
  $("#cliente").val(data.cli_id);
  $("#nom").val(data.pro_nom);
  $("#fecha").val(data.pro_fecha);
  $("#precio1").val(data.pro_precio);
}, "JSON");

$("#guardar_pro").text("Actualizar").data("edicion", 1).data("id", id);
$(".modal-title").text("Editar proyecto");
$("#modal").modal("show");

});
$(".eliminar_pro").on("click", function(e){
  e.preventDefault();

let id=$(this).data("id");
let obj = {
      "accion" : "eliminar_pro",
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
            
            
            Swal.fire(
              'Boooom!',
              'Registro eliminado.',
              'success'
            )
            setTimeout(function(){ location.reload();}, 3000);
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


//FIN DOCUMENT READY
});
