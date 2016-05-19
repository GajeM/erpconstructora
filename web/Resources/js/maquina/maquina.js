 $(document).ready(function(){
     
     
$('#anhoMaquina').Zebra_DatePicker({
    format: 'Y'
});
     
    $("#colorMaquina").select2({
         placeholder: 'Seleccione un color',
        
    });
    
     
     
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
      
        
        if (idPrincipal==""){
        
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
                                                   
                                                    if (data.estado == true) {
                                                            $("#idMaquina").val(data.idMaquina);
                                                             Lobibox.notify("success", {
                                                                size: 'mini',
                                                                msg: 'Registro exitoso, espere un momento'
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
                                                    
                                                    if (data.estado == true) {
                                                            $("#idMaquina").val(data.idMaquina);
                                                             Lobibox.notify("success", {
                                                                size: 'mini',
                                                                msg: 'Datos modificados con  exito!'
                                                            });
                                                       
                                                       

                                                    }

                                                },
                                                error: function (xhr, status)
                                                {

                                                }
                                            });
                                         
                  
                                     }

     });    
  
  
  
  
  
     $(document).on("click","#datosMantenimiento",function() {
            var valor = $("#idMaquina").val();
            
            
            
            if (valor==""){
                 
                 $("#datosGenerales").click();
                 
                    Lobibox.notify("warning", {
                                        size: 'mini',
                                        msg: 'Ingrese los datos generales de la maquina, por favor.'
                                    });
                
            }
            
            
            
        });     
      $(document).on("click","#datosExpedienteMantenimiento",function() {
            var valor = $("#idMaquina").val();
            
            
            
            if (valor==""){
                 
                 $("#datosGenerales").click();
                 
                    Lobibox.notify("warning", {
                                        size: 'mini',
                                        msg: 'Ingrese los datos generales de la maquina, por favor.'
                                    });
                
            }
            
            
            
        });     
        
        $(document).on("click","#imagenesMaquinas",function() {
            var valor = $("#idMaquina").val();
            
            
            
            if (valor==""){
                 
                 $("#datosGenerales").click();
                 
                    Lobibox.notify("warning", {
                                        size: 'mini',
                                        msg: 'Ingrese los datos generales de la maquina, por favor.'
                                    });
                
            }
            
            
            
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
        
       