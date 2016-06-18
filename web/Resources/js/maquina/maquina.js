
 
 $(document).ready(function(){
 var idDetalle =0;
  var idDetalleExpeMantenimiento =0;
  var xPermisoTablaDatosMantenimiento =0;
  var xPermisoTablaDatosExpedientesMant=0;
  

  
  
    $("#formularioEdicionExpedienteMaquinaria").hide()
    $("#almacenarInsersion").hide();

     $("#eliminarDatoMantenimiento").hide();
     $("#eliminarDatoExpedienteMantenimiento").hide();
     $("#formularioInsercionExpedienteMaquinaria").hide();
     
     
$('#anhoMaquina').Zebra_DatePicker({
    format: 'Y'
});


$('#fechaDE').Zebra_DatePicker({
     format: 'M d, Y'
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
            
            
 //Select del tipo de mantenimiento
   $('#tipoMantenimiento').select2({
                ajax: {
                    url: Routing.generate('buscarTipoMantenimiento'),
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
 
 
 //Select del proyecto
  $('#proyecto').select2({
                ajax: {
                    url: Routing.generate('buscarProyecto'),
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
 
 //Select del proveedor
  $('#proveedor').select2({
                ajax: {
                    url: Routing.generate('buscarProveedor'),
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
                                                   $("#idMaquinaNuevoExpedienteMantenimiento").val(data.idMaquina);
                                                   $("#idMaquinaInsercionImagen").val(data.idMaquina);
                                                   location.reload();
                                                 
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
  //Pestaña de Datos de Mantenimiento
  
     $(document).on("click","#datosMantenimiento",function() {
            var valor = $("#idMaquina").val();
            
            
            
            if (valor==0){
                 
                 $("#datosGenerales").click();
                 
                    Lobibox.notify("warning", {
                                        size: 'mini',
                                        msg: 'Primero tienes que ingresar los datos generales de la maquina.'
                                    });
                
            }else{
                
                if (xPermisoTablaDatosMantenimiento==0){
                     llamarDataTableDatosMantenimiento();
                     xPermisoTablaDatosMantenimiento=xPermisoTablaDatosMantenimiento+1;
                }
               
                
            }
            
            
            
        });     
        
        //Pestaña de datos del Expediente
      $(document).on("click","#datosExpedienteMantenimiento",function() {
            var valor = $("#idMaquina").val();
            
            
            
            if (valor==0){
                 
                 $("#datosGenerales").click();
                 
                    Lobibox.notify("warning", {
                                        size: 'mini',
                                        msg: 'Primero tienes que ingresar los datos generales de la maquina.'
                                    });
                
            }else{
                
                if (xPermisoTablaDatosExpedientesMant==0){
                     llamarDataTableExpedientesMantenimientos();
                     xPermisoTablaDatosExpedientesMant=xPermisoTablaDatosExpedientesMant+1;
                }
               
                
            }

          
        });     
        
        //Pestaña de Imagenes de las maquinas
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
    
    function llamarDataTableDatosMantenimiento(){
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
                            </div>';
      
      
       $("#contenidoDatosMantenimiento").append(formulario);
       
       $("#almacenarInsersion").show();
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
                              $("#almacenarInsersion").hide();

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
   $(document).on("click","tbody>tr",function() {
       
          

             var identificador =     $(this).attr("role");
       
            if(identificador=="row"){
                    
                    var idTabla = $(this).parent().parent().attr('id');
                  
                    
                    if (idTabla=='listaExpedienteMantenimientos'){
                     var idCliente1 =  $(this).children().html();
                     idDetalleExpeMantenimiento=idCliente1;
                     
                    
                    $("tr").css('background-color', 'white');
                    $("tr").css('border-color', '#262626');
                    $(this).css('background-color', '#E9E6E6');
                    $("#eliminarDatoExpedienteMantenimiento").show();  
                        
                    }else if(idTabla=='listaDatosMantenimientos'){
                        
                    var idCliente =  $(this).children().html();
                     idDetalle=idCliente;
                  
                    $("tr").css('background-color', 'white');
                    $("tr").css('border-color', '#262626');
                    $(this).css('background-color', '#E9E6E6');
                    $("#eliminarDatoMantenimiento").show();  
                    
                    }
                    
                

                    
             }else{
                  $("#eliminarDatoMantenimiento").hide();
                  
             }
          
           
           
                
       });
       
       
       
       
    //Click dentro del boton que me elimina un registro de un detalle de expediente de mantenimiento
    
     $(document).on("click","#eliminarDatoExpedienteMantenimiento",function() {
         
          var url=Routing.generate('eliminarExpedienteMantenimiento');
           
            swal({
                                                    title: "<p style='font-size:16px;'><b>Estas a punto de eliminar un registro de expediente de mantenimiento</b></p> ",
                                                    text: "<br>¿Quieres eliminar el registro?<br> Si aceptas, los datos  no podran ser recuperados.",
                                                    type: "warning",
                                                    html: true,
                                                    showCancelButton: true,
                                                    cancelButtonText: "No",
                                                    confirmButtonText: "Si",
                                                    confirmButtonColor: "#FF4E4E",
                                                     cancelButtonColor: "BLUE",
                                                    closeOnConfirm: true,
                                                    closeOnCancel: true
                                                },
                                                        function (isConfirm) {
                                                            if (isConfirm) {
                                                                     $.ajax({
                                                                            type: 'POST',
                                                                            async: false,
                                                                            dataType: 'json',
                                                                            data: {idDetalleExpeMantenimiento:idDetalleExpeMantenimiento},
                                                                            url: url,
                                                                            success: function (data)
                                                                            {


                                                                                if (data.estado == true) {
                                                                                    
                                                                                    
                                                                                 
                                                                                 
                                                                                 var tableExpedienteM = $('#listaExpedienteMantenimientos').DataTable();
                                                                                var idMaqui = $("#idMaquina").val();
                                                                                var url = Routing.generate('datosexpedientesmantenimientodata', {idMaquina: idMaqui});
                                                                                tableExpedienteM.ajax.url(url).load();
                                                                                limparformulario();
                                                                                    
                                                                                
                                                                                }

                                                                            },
                                                                            error: function (xhr, status)
                                                                            {

                                                                            }
                                                                        });

                                      
                                                            } else {
                                                                   
                                                                   $("#eliminarAbono").hide();
                                                                   

                                                            }
                                                        });
         
       
         
     });
     
     
     
     
   //Construccion del div que me genera las cajas de edicion de un campo.
   
    
   
   
   
   $(document).on("dblclick","tbody>tr",function() {
       
       
       var idTabla = $(this).parent().parent().attr('id');
                  
                    
             if (idTabla=='listaExpedienteMantenimientos'){
              var idRegistro =  $(this).children().html();
                     
            $.ajax({
            type: 'POST',
            async: false,
            dataType: 'json',
            data: {idRegistro: idRegistro},
            url: Routing.generate('seleccionarDatosExpedienteMantenimiento'),
            success: function (data)
            {
                if (data.estado == true) {
                        var imagenVisibilidad= '';
                        if (data.imagen==null){
                            imagenVisibilidad=' display:none; '

                        }
        var formulario = "";
                            formulario=' <div class="row" id="formularioEdicionExpedienteMaquinaria" style="margin-top: 10px;">\n\
                                                    <form action=""  id="formEdicionExpediente" enctype="multipart/form-data" method="POST">\n\
                    <input type="hidden" name="idRegistro" id="idRegistro" value="'+data.registro+'" >\n\
                     <input type="hidden" name="idMaquinaNuevoExpedienteMantenimientoE" id="idMaquinaNuevoExpedienteMantenimientoE" value="'+data.idMaquina+'" >\n\
                    <div class="form-column col-md-4">\n\
                        <div class="form-group required" style="margin-right: 2%;">\n\
                       <label for="tipoMantenimiento" class="control-label">Tipo de Mantenimiento</label>\n\
                        <select id="tipoMantenimientoE" name="tipoMantenimientoE" class="form-control requeridoINEMEn clerSelect" style="width: 100%" >\n\
                            <option selected value="'+data.tipoMantenimientoId+'" selected>'+data.tipoMantenimientoNombre+'</option>\n\
                            </select>\n\
                        </div>\n\
                    </div>\n\
                    <div class="form-column col-md-4" style="padding-top: 0%;">\n\
                         <div class="form-group required" >\n\
                                <label for="fechaDE" class="control-label">Fecha</label>\n\
                                </br><input type="text" name="fechaDEE" id="fechaDEE" class="requeridoINEME cler" value="'+data.fecha+'">\n\
                            </div>\n\
                           </div>\n\
                           <div class="col-md-4"></div>\n\
                     <div class="clearfix"></div>\n\
                     <div class="form-column col-md-4">\n\
                     <div class="form-group required" style="margin-right: 2%;" >\n\
                <div class="form-group">\n\
                        <label for="serie" class="control-label">Serie</label>\n\
                    <div class="input-group">\n\
                    <div class="input-group-addon">#</div>\n\
                    <input type="text" class="form-control requeridoINEME cler" id="serieE"  name="serieE" value="'+data.serie+'">\n\
                    </div>\n\
                    </div>\n\
                  </div>\n\
            </div>\n\
                 <div class="form-column col-md-4">\n\
                    <div class="form-group required" style="margin-right: 2%;" >\n\
                        <div class="form-group">\n\
                        <label for="costo" class="control-label">Costo</label>\n\
                                <div class="input-group">\n\
                                <div class="input-group-addon">$</div>\n\
                               <input type="text" class="form-control requeridoINEM cler" id="costoE"  name="costoE" value="'+data.costo+'">\n\
                                <div class="input-group-addon">.00</div>\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="form-column col-md-4">\n\
                          <div class="form-group required" style="margin-right: 2%;" >\n\
                                <div class="form-group">\n\
                                <label for="numeroFactura" class="control-label ">Numero Factura</label>\n\
                                      <div class="input-group">\n\
                                        <div class="input-group-addon">#</div>\n\
                                      <input type="text   " class="form-control requeridoINEME cler" id="numeroFacturaE"  name="numeroFacturaE" value="'+data.numeroFactura+'">\n\
                                </div>\n\
                           </div>\n\
                        </div>\n\
                        </div><div class="clearfix"></div>\n\
                            <div class="form-column col-md-4">\n\
                                <div class="form-group" style="margin-right: 2%;">\n\
                                    <label for="proyecto" class="control-label">Proyecto</label>\n\
                                        <select id="proyectoE" name="proyectoE" class="form-control cler" style="width: 100%">\n\
                                           <option selected value="'+data.proyectoId+'"  selected>'+data.proyectoNombre+'</option>\n\
                                        </select>\n\
                                     </div>\n\
                             </div>\n\
                                <div class="form-column col-md-4">\n\
                                    <div class="form-group" style="margin-right: 2%;">\n\
                                            <label for="proveedor" class="control-label">Proveedor</label>\n\
                                            <select id="proveedorE" name="proveedorE" class="form-control clerSelect" style="width: 100%" >\n\
                                                <option selected  value="'+data.proveedorId+'" selected>'+data.proveedorNombre+'</option>\n\
                                              </select>\n\
                                     </div>\n\
                                </div>\n\
                                  <div class="form-column col-md-4">\n\
                                            <div class="form-group" style="margin-right: 2%;">\n\
                                            <label for="fotoFactura" class="control-label">Foto de factura</label>\n\
                                            <input type="file" class="clerSelect" id="fotoFacturaE"  name="fotoFacturaE">\n\
                                    </div>\n\
                                  </div> <div class="clearfix"></div>\n\
                                        <div class="form-column col-md-8">\n\
                                            <div class="form-group" >\n\
                                                <label for="descripcionDatoExpediente" class="control-label" >Descripción</label>\n\
                                                <textarea name="descripcionDatoExpedienteE" id="descripcionDatoExpedienteE" class="form-control cler" maxlength="250">'+data.descripcion+'</textarea>\n\
                                            </div>\n\
                                            <div class="form-group" >\n\
                                                <div class="btn-group pull-left"><a class="btn btn-default  btn-sm " style="margin-left: 5px;margin-top: 35px;" id="cancelarInsercionExpeManetenimientoEdicion">Cancelar</a>\n\
                                            </div>\n\
                                            <div class="btn-group pull-left">\n\
                                                    <a  class="btn btn-success  btn-sm " style="margin-left: 5px;margin-top: 35px;" id="guardarExpedienteEdicion">Guardar</a>\n\
                                                 </div>\n\
                                                </div>\n\
                                           </div>\n\
                                    <div class="form-column col-md-4" >\n\
                                            <div class="form-group" >\n\
                                        <img src="/erpconstructora/web/Photos/expediente/'+data.imagen+'"  style="max-height: 300px;max-width: 300px;'+imagenVisibilidad+'" id="prevFacturaE">\n\
                                        <input type="hidden" value='+data.imagenIdRegistro+' name="idRegistroImagen">\n\
                                    </div>\n\
                                    </div>\n\
                                    </form>\n\
                                </div>';
                    
                    
                    
                    $("#contenidoExpedienteMantenimiento").hide();
                    $("#nuevoDestalleExpeMante").hide();
                    $("#formularioInsercionExpedienteMaquinaria").hide();
                    $("#eliminarDatoExpedienteMantenimiento").hide();
                    $("#formularioEdicionExpedienteMaquinaria").append(formulario);

$('#fechaDEE').Zebra_DatePicker({
     format: 'M d, Y'
});


    //Select del tipo de mantenimiento
   $('#tipoMantenimientoE').select2({
                ajax: {
                    url: Routing.generate('buscarTipoMantenimiento'),
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
//                templateSelection: formatRepoSelection,
                formatInputTooShort: function () {
                    return "Ingrese un caracter para la busqueda";
                }
            });
 
 
 //Select del proyecto
  $('#proyectoE').select2({
                ajax: {
                    url: Routing.generate('buscarProyecto'),
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
//                templateSelection: formatRepoSelection,
                formatInputTooShort: function () {
                    return "Ingrese un caracter para la busqueda";
                }
            });
 
 //Select del proveedor
  $('#proveedorE').select2({
                ajax: {
                    url: Routing.generate('buscarProveedor'),
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
//                templateSelection: formatRepoSelection,
                formatInputTooShort: function () {
                    return "Ingrese un caracter para la busqueda";
                }
            });
                    
                    
                    
                  
                        $("#formularioEdicionExpedienteMaquinaria").show();
                
               }


            },
            error: function (xhr, status)
            {



            }
        });
                     

                    }else if(idTabla=='listaDatosMantenimientos'){
                        
                    var idDatoMantenimiento = $(this).children().html();
                    idDetalle = idDatoMantenimiento;
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
                                        var form = "";

                                        form = '<div class="form-column col-md-3"><div class="form-group" >\n\
                                            <label for="nombre" class="control-label">Nombre</label>\n\
                                                <input type="text" class="form-control nombreDatoE" id="nombre" placeholder="Nombre del producto" name="nombre" value="' + data.nombre + '" >\n\
                                                </div>\n\
                                           </div>\n\
                                            <div class="form-column col-md-3"><div class="form-group" >\n\
                                            <label for="numero" class="control-label">Numero</label>\n\
                                                <input type="text" class="form-control numeroDatoE" id="numero" placeholder="# del producto" name="numero" value="' + data.numero + '">\n\
                                                </div>\n\
                                           </div>\n\
                                            <div class="form-column col-md-6"><div class="form-group" >\n\
                                              <label for="descripcion" class="control-label">Descripcion</label>\n\
                                              <textarea class="form-control descripcionDatoE" id="descripcion" placeholder="Descripcion del producto" name="descripcion" >' + data.descripcion + '</textarea>\n\
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
        
                    
        }
     
   
});


$(document).on("click","#cancelarInsercionExpeManetenimientoEdicion",function() {
        
        
       
       $("#formularioEdicionExpedienteMaquinaria div").html("");
       $("#cancelarInsercionExpeManetenimiento").click();
       
                   
        
        
    });




   //Donde se almacenan los valores de la edicion de los datos del mantenimiento    
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
  
  //Eliminacion de los datos del mantenimiento
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
                                
                                swal("Dato eliminado con exito!", "success")
                                
                                

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
                $("#almacenarInsersion").hide();        
                
                limparformulario();
        
        
    });
    
    
//Ajax  que llena el data table de expedientes de mantenimientos
     function llamarDataTableExpedientesMantenimientos(){
            var idMaqui= $("#idMaquina").val();

            var url = Routing.generate('datosexpedientesmantenimientodata',{idMaquina: idMaqui});
            
          $('#listaExpedienteMantenimientos').DataTable({
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
                    {"data": "fecha"},
                    {"data": "tipomantenimiento"},
                    {"data": "serie"},
                    {"data": "costo"},
                    {"data": "proyecto"}
                    
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
    
    
  
  $(document).on("click","#nuevoDestalleExpeMante",function() {
      $("#nuevoDestalleExpeMante").hide();
      $("#contenidoExpedienteMantenimiento").hide();
      $("#formularioInsercionExpedienteMaquinaria").show();
      $("#eliminarDatoExpedienteMantenimiento").hide();
        limparformulario();

      
  });
 
  $(document).on("click","#cancelarInsercionExpeManetenimiento",function() {
      
      $("#nuevoDestalleExpeMante").show();
      $("#contenidoExpedienteMantenimiento").show();
      $("#formularioInsercionExpedienteMaquinaria").hide();
        limparformulario();

      
  });
  
 //Guardar los datos del expediente 
  //Variable global
  
  var flag=true;
  var Extension="";
  
  //Seleccion de imagen
   $(document).on("change","#fotoFactura",function()
    {
        
         //obtenemos un array con los datos del archivo
        var file = $(this)[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        Extension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
      
        if ( Extension == "png" || Extension == "bmp"
                    || Extension == "jpeg" || Extension == "jpg") {
        	flag = true;
                 readURL(this);
                 $("#prevFactura").show();
                 
             
        }else{
        	flag = false;
                  swal("Error!", "Formato de archivo invalido", "error");
                  $(this).val("");
                     $("#prevFactura").hide();
        }
        

        
    });
  
  
  
  
  //Insercion de nuevo expediente de mantenimiento
    $(document).on("click","#guardarExpediente",function() {
        
        
         var num=0;
                $('.requeridoINEM').each( function (){
            
                       var x=$(this).val();
            
                       if(x=="" || x==null){
                           num=num+1;
                       }

                       });
           
        
        
        
        if (num==0){
            
            var costo = $("#costo").val();
            
            if (isNaN(costo)!=true){
                
            
            var frm = new FormData($("#formInsercionExpediente")[0]);
            
           
             $.ajax({
                                                type: 'POST',
                                                async: false,
                                                dataType: 'json',
                                                data: frm,
                                                url: Routing.generate('insertarExpedienteMantenimiento'),
                                                 //necesario para subir archivos via ajax
                                                cache: false,
                                                contentType: false,
                                                processData: false,
                                                //una vez finalizado correctamente
                                                success: function (data)
                                                {
                                                     
                                                
                                                     if (data.estado == true) {
                                                      
                                                    

                                                        swal({
                                                            title: "Datos de mantenimiento ingresados con exito",
                                                            text: "¿Quieres seguir  ingresando datos de expediente de mantenimiento?",
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
                                                                            
                                                                            $("#nuevoDestalleExpeMante").show();
                                                                            $("#contenidoExpedienteMantenimiento").show();
                                                                            $("#formularioInsercionExpedienteMaquinaria").hide();
                                                                            
                                                                            
                                                                            
                                                                                
                                                                                
                                                                            
                                                                                var tableExpedienteM = $('#listaExpedienteMantenimientos').DataTable();
                                                                                var idMaqui = $("#idMaquina").val();
                                                                                var url = Routing.generate('datosexpedientesmantenimientodata', {idMaquina: idMaqui});
                                                                                tableExpedienteM.ajax.url(url).load();
                                                                                
                                                                                limparformulario();
                                                                                
                                                                                
                                                                             
                                                                             
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
       }else{
      
                    swal("Error!", "El costo de la factura no pueden ser letras", "error");
                    
      }   
       
       
      }else{
      
                    swal("Error!", "No debes dejar campos ruqueridos vacios", "error");
                    
      }
      
       
   });
   
 //termina ingresar los datos de expediente
 
 
 
 
 
 //Empieza la insercion de los datos a editar dentro de un expediente
//Variable global
  
  var flag=true;
  var Extension="";
  
  //Seleccion de imagen
   $(document).on("change","#fotoFacturaE",function()
    {
        
        
         //obtenemos un array con los datos del archivo
        var file = $(this)[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        Extension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
      
        if ( Extension == "png" || Extension == "bmp"
                    || Extension == "jpeg" || Extension == "jpg") {
        	flag = true;
                 readURLE(this);
                 $("#prevFacturaE").show();
                 
             
        }else{
        	flag = false;
                  swal("Error!", "Formato de archivo invalido", "error");
                  $(this).val("");
                     $("#prevFacturaE").hide();
        }
        

        
    });
  
  
  
  
  //Insercion de nuevo expediente de mantenimiento
    $(document).on("click","#guardarExpedienteEdicion",function() {
        
        
                 var num=0;
                $('.requeridoINEME').each( function (){
            
                       var x=$(this).val();
            
                       if(x=="" || x==null){
                           num=num+1;
                       }

                       });
           
        
        
        
        if (num==0){
            
            var costo = $("#costoE").val();
            
            if (isNaN(costo)!=true){
                
          

            var frm = new FormData($("#formEdicionExpediente")[0]);
            
           
             $.ajax({
                                                type: 'POST',
                                                async: false,
                                                dataType: 'json',
                                                data: frm,
                                                url: Routing.generate('modificarExpedienteMantenimiento'),
                                                 //necesario para subir archivos via ajax
                                                cache: false,
                                                contentType: false,
                                                processData: false,
                                                //una vez finalizado correctamente
                                                success: function (data)
                                                {
                                                     
                                                
                                                     if (data.estado == true) {
                                                      
                                                    

                                                        swal({
                                                            title: "Datos de mantenimiento modificados con exito",
                                                            text: "¿Quieres seguir  modificando datos de expediente de mantenimiento?",
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
                                                                            
                                                                                $("#formularioEdicionExpedienteMaquinaria div").html("");
                                                                                $("#cancelarInsercionExpeManetenimiento").click();
                                                                                
                                                                                var tableExpedienteM = $('#listaExpedienteMantenimientos').DataTable();
                                                                                var idMaqui = $("#idMaquina").val();
                                                                                var url = Routing.generate('datosexpedientesmantenimientodata', {idMaquina: idMaqui});
                                                                                tableExpedienteM.ajax.url(url).load();
                                                                                
                                                                             
                                                                                
                                                                                
                                                                             
                                                                             
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
                                            
               }else{
                    swal("Error!", "El costo de la factura no puedeb ser letras", "error");
               }                               
                    
      }else{
      
                    swal("Error!", "No debes dejar campos ruqueridos vacios", "error");
                    
      }
      
       
   });
   
   
    //Envio de imagenes de la maquinaria
    
    
 
 var idMaquina=$("#idMaquina").val();
 var correlativoDiv=0; 
    var url = Routing.generate('insertarImagenesMaquinaria', {idMaquina: idMaquina});
    $("#zonaDeImagenes").dropzone({
        url: url,
         success: function(file, response){
          var obj = jQuery.parseJSON(response);
          correlativoDiv=correlativoDiv+1;
            
            var formulario='<div class="col-md-4">\n\
                                                <img src="" style="max-height: 300px;max-width: 300px;margin-top:10px;" id="imgPrueba-'+correlativoDiv+'">\n\
                                            </div>'
              $("#mostrarImagenes").append(formulario);
             $("#imgPrueba-"+correlativoDiv).attr("src","/erpconstructora/web/Photos/maquinaria/"+obj.nombreImagen);
           
               

    }

    });


   
  
  //Fin del document Ready
 });
 
 function formatRepo (data) {
            if(data.nombre){
                var markup = "<div class='select2-result-repository clearfix'>" +
                             "<div class='select2-result-repository__meta'>" +
                             "<div class='select2-result-repository__title'>" + data.nombre+ "</div>" +
                             "</div></div>";
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
        
     function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#prevFactura').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function limparformulario(){
        
        $("#tipoMantenimiento").val(0).change();
        $("#fechaDE").val("");
        $("#serie").val("");
        $("#costo").val("");
        $("#numeroFactura").val("");
        $("#proyecto").val(0).change();
        $("#proveedor").val(0).change();
        $("#fotoFactura").val("");
        $("#descripcionDatoExpediente").val("");
        $("#prevFactura").hide();
        $("#eliminarDatoExpedienteMantenimiento").hide();

        
    }
    
      function readURLE(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#prevFacturaE').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }