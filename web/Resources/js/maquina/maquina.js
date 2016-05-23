 $(document).ready(function(){
 var idDetalle =0;
     $("#eliminarDatoMantenimiento").hide();
     
     
     
$('#anhoMaquina').Zebra_DatePicker({
    format: 'Y'
});
     
    $("#colorMaquina").select2({
         placeholder: 'Seleccione un color',
        
    });
    
     
 //Select2 del tipo de empresa    
     $('#tipoEquipo').select2({
                ajax: {
                    url: Routing.generate('buscarTipoEquipo'),
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        var select2Data = $.map(data.data, function (obj) {
                            obj.id = obj.abogadoid;
                            obj.text = obj.nombre;

                            return obj;
                        });

                        return {
                            results: select2Data
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) { return markup; },
                minimumInputLength: 1,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection,
                formatInputTooShort: function () {
                    return "Ingrese un caracter para la busqueda";
                }
            });

       $(document).on("click","#guargarDatosGeneralesMaquina",function() {
           
           
           
           
           
       }); 
     
    $(document).on("click","#guargarDatosGeneralesMaquina",function() {
       var idPrincipal = $("#idMaquina").val();
    
        
        
        if (idPrincipal==0){
        
    //Insercion de los datos generales de la empresa
        var numeroSerie, numeroEquipo, anho, alias, modelo, tipoEquipo,
                vin, placa, color, tamanho, capacidad, marca, descripcion;
      
            numeroSerie=$("#numeroSerie").val();
            numeroEquipo=$("#numeroEquipo").val();
            anho=$("#anhoMaquina").val();
            alias=$("#alias").val();
            modelo=$("#modelo").val();
            tipoEquipo=$("#tipoEquipo").val();
            vin=$("#vin").val();
            placa=$("#placa").val();
            color=$("#color").val();
            tamanho=$("#tamanho").val();
            capacidad=$("#capacidad").val();
            marca=$("#marca").val();
            descripcion=$("#descripcionMaquina").val();
             
       $.ajax({
                                    type: 'POST',
                                    async: false,
                                    dataType: 'json',
                                    data: {numeroSerie:numeroSerie,numeroEquipo:numeroEquipo,
                                        placa:placa},
                                    url: Routing.generate('validarMaquina'),
                                    success: function (data)
                                    {
                                    
                                     if (data.estado==true){
                                         

                                            $.ajax({
                                                type: 'POST',
                                                async: false,
                                                dataType: 'json',
                                                data: {numeroSerie: numeroSerie, numeroEquipo: numeroEquipo, anho: anho, alias: alias, modelo: modelo, tipoEquipo: tipoEquipo,
                                                    vin: vin, placa: placa, color: color, tamanho: tamanho, capacidad: capacidad, marca: marca, descripcion: descripcion},
                                                url: Routing.generate('insertarMaquina'),
                                                success: function (data)
                                                {
                                                   $("#idMaquina").val(data.idMaquina);
                                                   
                                                    if (data.estado == true) {
                                                   
                                                       
                                                        
                                                swal({
                                                    title: "Datos  ingresados con exito",
                                                    text: "¿Quieres seguir completando los datos de la maquina ingresada?",
                                                    type: "success",
                                                    showCancelButton: true,
                                                    cancelButtonText: "Despues",
                                                    confirmButtonText: "Seguir",
                                                    confirmButtonColor: "#00A59D",
                                                    closeOnConfirm: true,
                                                    closeOnCancel: false
                                                },
                                                        function (isConfirm) {
                                                            if (isConfirm) {
                                                                    
                                                     
                            
                                      
                                                            } else {
                                                                    var url=Routing.generate('dashboard_index');
                                                                window.open(url,"_self"); 

                                                            }
                                                        });

                                                   }

                                                },
                                                error: function (xhr, status)
                                                {

                                                }
                                            });
                                         
                  
                                     }
                                     else if(data.estado=="equipo"){
                                           Lobibox.notify("info", {
                                        size: 'mini',
                                        msg: 'Registro de numero de equipo ya existente, intente con otro.'
                                    });
                                     }
                                     else if(data.estado=="placa"){
                                           Lobibox.notify("info", {
                                        size: 'mini',
                                        msg: 'Registro de numero de pĺaca ya existente, intente con otro.'
                                    });
                                     }
                                     else if(data.estado=="serie"){
                                           Lobibox.notify("info", {
                                        size: 'mini',
                                        msg: 'Registro de numero de serie ya existente, intente con otro.'
                                    });
                                     }
                                       
                                             
                                    },
                                    error: function (xhr, status)
                                    {
                      
                    }
            });
      

              
        }else{
            var idMaquina = $("#idMaquina").val();
//Edicion de los datos generales de la empresa desde el formulario de insercion
             var numeroSerie, numeroEquipo, anho, alias, modelo, tipoEquipo,
                vin, placa, color, tamanho, capacidad, marca, descripcion;
      
            numeroSerie=$("#numeroSerie").val();
            numeroEquipo=$("#numeroEquipo").val();
            anho=$("#anhoMaquina").val();
            alias=$("#alias").val();
            modelo=$("#modelo").val();
            tipoEquipo=$("#tipoEquipo").val();
            vin=$("#vin").val();
            placa=$("#placa").val();
            color=$("#color").val();
            tamanho=$("#tamanho").val();
            capacidad=$("#capacidad").val();
            marca=$("#marca").val();
            descripcion=$("#descripcionMaquina").val();
             
 

                                            $.ajax({
                                                type: 'POST',
                                                async: false,
                                                dataType: 'json',
                                                data: {numeroSerie: numeroSerie, numeroEquipo: numeroEquipo, anho: anho, alias: alias, modelo: modelo, tipoEquipo: tipoEquipo,
                                                    vin: vin, placa: placa, color: color, tamanho: tamanho, capacidad: capacidad, marca: marca, descripcion: descripcion,idMaquina:idMaquina},
                                                url: Routing.generate('modificarMaquina'),
                                                success: function (data)
                                                {
                                                     $("#idMaquina").val(data.idMaquina);
                                                     llamarDataTable();
                                                    if (data.estado == true) {
                                                        
                                                swal({
                                                    title: "Datos  modificados con exito",
                                                    text: "¿Quieres seguir completando los datos de la maquina ingresada?",
                                                    type: "success",
                                                    showCancelButton: true,
                                                    cancelButtonText: "Despues",
                                                    confirmButtonText: "Seguir",
                                                    confirmButtonColor: "#00A59D",
                                                    closeOnConfirm: true,
                                                    closeOnCancel: false
                                                },
                                                        function (isConfirm) {
                                                            if (isConfirm) {
                                                                    
                                                                    
                                      
                                                            } else {
                                                                    var url=Routing.generate('dashboard_index');
                                                                window.open(url,"_self"); 

                                                            }
                                                        });
                                                       
                                                       

                                                    }

                                                },
                                                error: function (xhr, status)
                                                {
                                                    
                                                }
                                            });
                                         
                  
                                     }
                                     
                                     

     });    
  
  
  
  
  //Validacion para que tenga que completar los datos en un orden en especifico
     $(document).on("click","#datosMantenimiento",function() {
            var valor = $("#idMaquina").val();
            
            
            
            if (valor==0){
                 
                 $("#datosGenerales").click();
                 
                    Lobibox.notify("warning", {
                                        size: 'mini',
                                        msg: 'Primero tienes que ingresar los datos generales de la maquina.'
                                    });
                
            }else{
                llamarDataTable();
            }
            
            
            
        });     
        
      $(document).on("click","#datosExpedienteMantenimiento",function() {
            var valor = $("#idMaquina").val();
            
            
            
            if (valor==0){
                 
                 $("#datosGenerales").click();
                 
                    Lobibox.notify("warning", {
                                        size: 'mini',
                                        msg: 'Ingrese los datos generales de la maquina, por favor.'
                                    });
                
            }

          
        });     
        
        $(document).on("click","#imagenesMaquinas",function() {
            var valor = $("#idMaquina").val();

            if (valor==0){
                 
                 $("#datosGenerales").click();
                 
                    Lobibox.notify("warning", {
                                        size: 'mini',
                                        msg: 'Ingrese los datos generales de la maquina, por favor.'
                                    });
                
            }
 
     });
  
     
     
   //Donde se llena el data table que contiene los datos de mantenimientos
    
    function llamarDataTable(){
            var idMaqui= $("#idMaquina").val();

            var url = Routing.generate('datosmantenimientodata',{idMaquina: idMaqui});
            
            $('#listaDatosMantenimientos').DataTable({
                columnDefs: [
                    {
                        targets: [0, 1, 2],
                        className: 'mdl-data-table__cell--non-numeric'
                    }
                ],
                "pageLength": 10,
                "lengthMenu": [20],
                "dom": "ftp",
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": url,
                    "type": 'GET'
                  
                },
                "columns": [
                    {"data": "id"},
                    {"data": "nombre"},
                    {"data": "numero"},
                    {"data": "descripcion"}
                ],
                "language": {
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "",
                    "emptyTable": "<center>No se encontraron registros</center>",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "processing": "<p>Procesando petición...</p>",
                    "search": "<p>Buscar registros:</p>",
                    "lengthMenu": "Mostrar _MENU_ registros"
                }


            });

    }
          
          
//Donde se me crean los campos que llenan el detalle de Datos de Mantenimiento          

  $("#almacenarFormularioDatosMantenimieto").hide();
  
  $(document).on("click",".addDatosMantenimiento",function() {
      
      var formulario="";
      
        formulario = '<div class="form-column col-md-3"><div class="form-group" >\n\
                            <label for="nombre" class="control-label">Nombre</label>\n\
                                <input type="text" class="form-control nombreDato" id="nombre" placeholder="Nombre del producto" name="nombre" >\n\
                                </div>\n\
                           </div>\n\
                            <div class="form-column col-md-3"><div class="form-group" >\n\
                            <label for="numero" class="control-label">Numero</label>\n\
                                <input type="text" class="form-control numeroDato" id="numero" placeholder="# del producto" name="numero" >\n\
                                </div>\n\
                           </div>\n\
                            <div class="form-column col-md-6"><div class="form-group" >\n\
                              <label for="descripcion" class="control-label">Descripcion</label>\n\
                              <textarea class="form-control descripcionDato" id="descripcion" placeholder="Descripcion del producto" name="descripcion" ></textarea>\n\
                             </div>\n\
                            </div><hr style="color:black;"><div class="clearfix"></di>\n\
                              <div id="almacenarEdicion">\n\
                                    <div class="form-column col-md-4" style="margin-left: -120px;"><div class="form-group" >\n\
                                <div class="btn-group pull-right">\n\
                                    <a class="btn btn-default  btn-sm " style="margin-left: 5px;margin-top: 35px;" id="cancelarFormularioDatoManetenimiento">Cancelar</a>\n\
                                </div>\n\
                                <div class="btn-group pull-right"><button class="btn btn-success  btn-sm " style="margin-left: 5px;margin-top: 35px;" id="guardarFormularioDatoManetenimiento">Guardar</button>\n\
                                </div></div>\n\
                                </div> </div>';
      
      
       $("#contenidoDatosMantenimiento").append(formulario);
       
       $("#almacenarFormularioDatosMantenimieto").show();
      $("#nombre").focus();
      
  });
  
 
  //Donde se envian los valores de que se quieren registrar
   $(document).on("click","#guardarFormularioDatoManetenimiento",function() {
        var nombres = new Array();
        var numeros = new Array();
        var descripciones = new Array();
            
            $(".nombreDato").each(function(k, va) {
                     nombres.push($(this).val());
             });
             
              $(".numeroDato").each(function(k, va) {
                     numeros.push($(this).val());
             });
             
            $(".descripcionDato").each(function(k, va) {
                     descripciones.push($(this).val());
             });
             
        var idMaquina = $("#idMaquina").val();       
             
       $.ajax({
            type: 'POST',
            async: false,
            dataType: 'json',
            data: {nombres:nombres,numeros:numeros,descripciones:descripciones,idMaquina:idMaquina},
            url: Routing.generate('insertarDatosMantenimiento'),
            success: function (data)
            {
                if (data.estado==true){
                              $("#almacenarFormularioDatosMantenimieto").hide();

                                        $('#contenidoDatosMantenimiento').html('');
                                        
                                        var table = $('#listaDatosMantenimientos').DataTable();
                                        
                                                table.ajax.reload(function (json) {

                                                });
                            
                  swal({
                        title: "Datos de mantenimiento ingresados con exito",
                        text: "¿Quieres seguir inrgesando  datos de mantenimiento?",
                        type: "success",
                        showCancelButton: true,
                        cancelButtonText: "Despues",
                        confirmButtonText: "Seguir",
                        confirmButtonColor: "#00A59D",
                        closeOnConfirm: true,
                        closeOnCancel: false
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                

                                } else {
                                    var url = Routing.generate('dashboard_index');
                                    window.open(url, "_self");

                                }
                            });

                }


            },
            error: function (xhr, status)
            {
               
               
               
            }
        });
               
   });
   
   
  //seleccion de un Tr para una eliminacion
   $(document).on("click","tr",function() {
       
             var idCliente =  $(this).children().html();
             idDetalle=idCliente;
     
             if (idCliente!="ID Mantenimiento"){
                    $("tr").css('background-color', 'white');
                    $(this).css('background-color', '#E9E6E6');

                    $("#eliminarDatoMantenimiento").show();   
             }
          
           
           
                
       });
       
   //Construccion del div que me genera las cajas de edicion de un campo.
   
   $(document).on("dblclick","tr",function() {
             var idDatoMantenimiento =  $(this).children().html();
             idDetalle =idDatoMantenimiento;
             $("#eliminarDatoMantenimiento").hide();   
             
             
          $.ajax({
            type: 'POST',
            async: false,
            dataType: 'json',
            data: {idDatoMantenimiento: idDatoMantenimiento},
            url: Routing.generate('seleccionarDatosMantenimientoEdicion'),
            success: function (data)
            {
                if (data.estado == true) {
                     var form="";
      
        form = '<div class="form-column col-md-3"><div class="form-group" >\n\
                            <label for="nombre" class="control-label">Nombre</label>\n\
                                <input type="text" class="form-control nombreDatoE" id="nombre" placeholder="Nombre del producto" name="nombre" value="'+data.nombre+'" >\n\
                                </div>\n\
                           </div>\n\
                            <div class="form-column col-md-3"><div class="form-group" >\n\
                            <label for="numero" class="control-label">Numero</label>\n\
                                <input type="text" class="form-control numeroDatoE" id="numero" placeholder="# del producto" name="numero" value="'+data.numero+'">\n\
                                </div>\n\
                           </div>\n\
                            <div class="form-column col-md-6"><div class="form-group" >\n\
                              <label for="descripcion" class="control-label">Descripcion</label>\n\
                              <textarea class="form-control descripcionDatoE" id="descripcion" placeholder="Descripcion del producto" name="descripcion" >'+data.descripcion+'</textarea>\n\
                             </div>\n\
                            </div><hr style="color:black;"><div class="clearfix"></di>\n\
                                  <div id="almacenarEdicion">\n\
                                    <div class="form-column col-md-4" style="margin-left: -120px;"><div class="form-group" >\n\
                                <div class="btn-group pull-right">\n\
                                    <a class="btn btn-default  btn-sm " style="margin-left: 5px;margin-top: 35px;" id="cancelarEdicionDatoManetenimiento">Cancelar</a>\n\
                                </div>\n\
                                <div class="btn-group pull-right"><button class="btn btn-success  btn-sm " style="margin-left: 5px;margin-top: 35px;" id="guardarEdicionDatoManetenimiento">Guardar</button>\n\
                                </div></div>\n\
                                </div> </div>';
      
      
       $("#edicionDatosMantenimiento").append(form);
     
     
                }


            },
            error: function (xhr, status)
            {



            }
        });
             
   
});     
       
  $(document).on("click","#guardarEdicionDatoManetenimiento",function() {
           
            var nombres = new Array();
        var numeros = new Array();
        var descripciones = new Array();

        $(".nombreDatoE").each(function (k, va) {
            nombres.push($(this).val());
        });

        $(".numeroDatoE").each(function (k, va) {
            numeros.push($(this).val());
        });

        $(".descripcionDatoE").each(function (k, va) {
            descripciones.push($(this).val());
        });
      
      
      
      $.ajax({
            type: 'POST',
            async: false,
            dataType: 'json',
            data: {idDatoMantenimiento: idDetalle,nombres:nombres,numeros:numeros,descripciones:descripciones},
            url: Routing.generate('editarDatosMantenimientoEdicion'),
            success: function (data)
            {
                if (data.estado == true) {

                          

                                        $('#edicionDatosMantenimiento').html('');
                                        
                                        var table = $('#listaDatosMantenimientos').DataTable();
                                        
                                                table.ajax.reload(function (json) {

                                                });
                            
                  swal({
                        title: "Datos de mantenimiento ingresados con exito",
                        text: "¿Quieres seguir gestionando  datos de mantenimiento?",
                        type: "success",
                        showCancelButton: true,
                        cancelButtonText: "Despues",
                        confirmButtonText: "Seguir",
                        confirmButtonColor: "#00A59D",
                        closeOnConfirm: true,
                        closeOnCancel: false
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                

                                } else {
                                    var url = Routing.generate('dashboard_index');
                                    window.open(url, "_self");

                                }
                            });
                    


                }


            },
            error: function (xhr, status)
            {



            }
        });



    });  
  
  
   $(document).on("click","#eliminarDatoMantenimiento",function() {
       
            $.ajax({
            type: 'POST',
            async: false,
            dataType: 'json',
            data: {idDatoMantenimiento: idDetalle},
            url: Routing.generate('eliminarDatosMantenimientoEdicion'),
            success: function (data)
            {
                if (data.estado == true) {
                                        $("#eliminarDatoMantenimiento").hide();
                                        var table = $('#listaDatosMantenimientos').DataTable();
                                        
                                                table.ajax.reload(function (json) {

                                                });
                            
                  swal({
                        title: "Datos de mantenimiento eliminados con exito",
                        text: "¿Quieres seguir  gestionando datos de mantenimiento?",
                        type: "success",
                        showCancelButton: true,
                        cancelButtonText: "Despues",
                        confirmButtonText: "Seguir",
                        confirmButtonColor: "#00A59D",
                        closeOnConfirm: true,
                        closeOnCancel: false
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                

                                } else {
                                    var url = Routing.generate('dashboard_index');
                                    window.open(url, "_self");

                                }
                            });
                    


                }


            },
            error: function (xhr, status)
            {



            }
        });
                        
   });
  
    $(document).on("click","#cancelarFormularioDatoManetenimiento",function() {
        
            $('#contenidoDatosMantenimiento').html('');
                                     
        
        
    });

  

 });
 
 function formatRepo (data) {
            if(data.nombre){
                var markup = "<div class='select2-result-repository clearfix'>" +
                             "<div class='select2-result-repository__meta'>" +
                             "<div class='select2-result-repository__title'>" + data.nombre+ "</div>" +
                             "</div></div>";
            } else {
                var markup = "Seleccione un tipo de equipo";
            }

            return markup;
        }

        function formatRepoSelection (data) {
            if(data.nombre){
                return  data.nombre;
            } else {
                return "Seleccione un tipo de equipo";
            }   
        }
        
       