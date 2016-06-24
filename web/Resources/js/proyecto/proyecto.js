 $(document).ready(function(){
     
     
     //Select2 para clientes y contactos dentro de un nuevo proyecto
     
     
       $('#contactoDirecto').select2({
                ajax: {
                    url: Routing.generate('buscarContacto'),
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
                },
                
                language: {
             noResults: function() {
                 return "<a href='#' id='addNewContacto'>Agregar Nuevo Contacto</a>";
                    }
                }, 
            });


       $('#idcliente').select2({
                ajax: {
                    url: Routing.generate('buscarCliente'),
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
                            obj.id = obj.clienteid;
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
                templateResult: formatRepoC,
                templateSelection: formatRepoSelectionC,
                formatInputTooShort: function () {
                    return "Ingrese un caracter para la busqueda";
                },
                
                language: {
             noResults: function() {
                 return "<a href='#' id='addNewCliente'>Agregar Nuevo Cliente</a>";
                    }
                }
                    
                
            });



             $('#estadoProyecto').select2({
                ajax: {
                    url: Routing.generate('buscarEstadoProyecto'),
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
                            obj.id = obj.estadoId;
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
                templateResult: formatRepoEP,
                templateSelection: formatRepoSelectionEP,
                formatInputTooShort: function () {
                    return "Ingrese un caracter para la busqueda";
                }
            });


 $('#tipoProyecto').select2({
                ajax: {
                    url: Routing.generate('buscarTipoProyecto'),
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
                            obj.id = obj.estadoId;
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
                templateResult: formatRepoTP,
                templateSelection: formatRepoSelectionTP,
                formatInputTooShort: function () {
                    return "Ingrese un caracter para la busqueda";
                }
            });
            
            
            $('#encargadoProyecto').select2({
                ajax: {
                    url: Routing.generate('buscarEncargadoProyecto'),
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
                            obj.id = obj.estadoId;
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
                templateResult: formatRepoENP,
                templateSelection: formatRepoSelectionENP,
                formatInputTooShort: function () {
                    return "Ingrese un caracter para la busqueda";
                }
            });
    
 //Click dentro de agregar los nuevos dentro de los select2
 
  $(document).on("click","#addNewContacto",function() {
      
        var url = Routing.generate('nuevocontacto');
        window.open(url, "_self");

      
      
      
  });
  
  
  
  $(document).on("click","#addNewCliente",function() {
      
        var url = Routing.generate('nuevocliente');
        window.open(url, "_self");

      
      
      
  });
 
 
            
//Inicializacion de fechas      

$('#fechaInicio').Zebra_DatePicker({
     format: 'd-m-Y',
     direction: true,
               pair: $('#fechaFin')
});            
            
 $('#fechaFin').Zebra_DatePicker({
      format: 'd-m-Y',
      direction: true
});            
                    

  



//Terminacion de inicializacion de los select2 que sirven para el ingreso de datos generales de una empresa
//Insercion de datos generales de un proyecto

     
       $(document).on("click","#guardarDatosGeneralesProyecto",function() {
           
            var idPrincipal = $("#idProyecto").val();
             if (idPrincipal==0){
                 
                  var num=0;

                    $('.requerido').each(function () {

                   var x = $(this).val();

                   if (x == "" || x == null) {
                       num = num + 1;
                   }

               });

            if (num == 0) {
                
                
                
                var nombreProyecto,idcliente, contactoDirecto,direccionProyecto, estadoProyecto, tipoProyecto, fechaInicio,
                        fechaFin, encargadoProyecto, observacionesProyecto;

                nombreProyecto = $("#nombreProyecto").val();
                idcliente  = $("#idcliente").val();
                contactoDirecto  = $("#contactoDirecto").val();
                direccionProyecto  = $("#us3-address").val();
                estadoProyecto  = $("#estadoProyecto").val();
                tipoProyecto = $("#tipoProyecto").val();
                fechaInicio = $("#fechaInicio").val();
                fechaFin = $("#fechaFin").val();
                encargadoProyecto = $("#encargadoProyecto").val();
                observacionesProyecto = $("#observacionesProyecto").val();
                
                
                $.ajax({
                                    type: 'POST',
                                    async: false,
                                    dataType: 'json',
                                    data: {nombreProyecto:nombreProyecto},
                                    url: Routing.generate('validarNombreProyecto'),
                                    success: function (data)
                                    {
                                         if (data.estado==true){
                                             
                                                $.ajax({
                                                 type: 'POST',
                                                 async: false,
                                                 dataType: 'json',
                                                 data: {nombreProyecto: nombreProyecto, idcliente: idcliente, contactoDirecto: contactoDirecto, direccionProyecto: direccionProyecto, estadoProyecto: estadoProyecto,
                                                     tipoProyecto: tipoProyecto, fechaInicio: fechaInicio, fechaFin: fechaFin, encargadoProyecto: encargadoProyecto, observacionesProyecto: observacionesProyecto},
                                                 url: Routing.generate('insertarDatosGeneralesProyecto'),
                                                 success: function (data)
                                                 {
                                                     if (data.estado == true) {

                                                         swal("Exito!", "Datos ingresados con exito", "success");

                                                     }


                                                 },
                                                 error: function (xhr, status)
                                                 {

                                                 }
                                             });
          
                                         }else{
                                             
                                             swal("Error!", "Nombre de proyecto ya existe, intenta con otro", "error");
                                             $("#nombreProyecto").val("");
                                             $("#nombreProyecto").hover();
                                             
                                         }
                                         

                                    },
                                    error: function (xhr, status)
                                    {
                      
                    }
            });
                
                
                
                
                        
                
                
               
            }else{
                 swal("Error!", "No debes dejar datos requeridos vacios", "error");
                
                
                
            }




        }
           
           
           

           
       });
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
 });


//Contacto
function formatRepo (data) {
            if(data.nombre){
                var markup = "<div class='select2-result-repository clearfix'>" +
                             "<div class='select2-result-repository__meta'>" +
                             "<div class='select2-result-repository__title'>" + data.nombre+ "</div>" +
                             "</div></div>";
            } else {
                var markup = "Seleccione un contacto";
            }

            return markup;
        }

        function formatRepoSelection (data) {
            if(data.nombre){
                return  data.nombre;
            } else {
                return "Seleccione un contacto";
            }   
        }

//Cliente
function formatRepoC (data) {
            if(data.nombre){
                var markup = "<div class='select2-result-repository clearfix'>" +
                             "<div class='select2-result-repository__meta'>" +
                             "<div class='select2-result-repository__title'>" + data.nombre+ "</div>" +
                             "</div></div>";
            } else {
                var markup = "Seleccione un cliente";
            }

            return markup;
        }

        function formatRepoSelectionC (data) {
            if(data.nombre){
                return  data.nombre;
            } else {
                return "Seleccione un cliente";
            }   
        }

//Estado de proyecto
function formatRepoEP (data) {
            if(data.nombre){
                var markup = "<div class='select2-result-repository clearfix'>" +
                             "<div class='select2-result-repository__meta'>" +
                             "<div class='select2-result-repository__title'>" + data.nombre+ "</div>" +
                             "</div></div>";
            } else {
                var markup = "Seleccione estado";
            }

            return markup;
        }

        function formatRepoSelectionEP (data) {
            if(data.nombre){
                return  data.nombre;
            } else {
                return "Seleccione estado";
            }   
        }
//Tipo de proyecto
function formatRepoTP (data) {
            if(data.nombre){
                var markup = "<div class='select2-result-repository clearfix'>" +
                             "<div class='select2-result-repository__meta'>" +
                             "<div class='select2-result-repository__title'>" + data.nombre+ "</div>" +
                             "</div></div>";
            } else {
                var markup = "Tipo proyecto";
            }

            return markup;
        }

        function formatRepoSelectionTP (data) {
            if(data.nombre){
                return  data.nombre;
            } else {
                return "Tipo proyecto";
            }   
        }

//Encargado de proyecto
function formatRepoENP (data) {
            if(data.nombre){
                var markup = "<div class='select2-result-repository clearfix'>" +
                             "<div class='select2-result-repository__meta'>" +
                             "<div class='select2-result-repository__title'>" + data.nombre+ "</div>" +
                             "</div></div>";
            } else {
                var markup = "Encargado proyecto";
            }

            return markup;
        }

        function formatRepoSelectionENP (data) {
            if(data.nombre){
                return  data.nombre;
            } else {
                return "Encargado proyecto";
            }   
        }