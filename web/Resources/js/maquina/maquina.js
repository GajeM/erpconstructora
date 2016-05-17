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