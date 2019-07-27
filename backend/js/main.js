
(function ($) {
    "use strict";

    
    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');
    

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    
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

        let obj={
            "accion": "registrar",
            "nombre": nom,
            "email": email,
            "password": password
        }
        if(email.length==0 || password.length==0){
            
        }else{
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
                      $.notify("Ocurrio un error intentelo de nuevo","error");
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
                  setTimeout(function(){ location.href='../index.html'; }, 10000);
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
    
})(jQuery);