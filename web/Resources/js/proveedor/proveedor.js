 $(document).ready(function(){
            
         $('.telefono').mask('0000-0000', {placeholder: "0000-0000"});
         $('#nitCP').mask('0000-000000-000-0', {placeholder: "0000-000000-000-0"});
         $('#nrcCP').mask('000000-0', {placeholder: "000000-0"});
     
     
     
         $(document).on("click","#nuevoCp",function() {
             var nombre, direccion,telefono,telefonoM,nrc,nit,correoElectronico,paginaWeb,descripcion,referidoPor;
               nombre=$("#nombreCp").val();
        
               direccion=$("#direccionCp").val();
               telefono=$("#telefonoCp").val();
               telefonoM=$("#telefonoMCp").val();
               nrc=$("#nrcCP").val();
               nit=$("#nitCP").val();
               correoElectronico=$("#correoCp").val();
               paginaWeb=$("#paginaWebCp").val();
               descripcion=$("#descripcionCp").val();
               referidoPor=$("#referidoPor").val();
               
                      $.ajax({
                                    type: 'POST',
                                    async: false,
                                    dataType: 'json',
                                    data: {nombre:nombre,direccion:direccion,telefono:telefono,telefonoM:telefonoM,nrc:nrc,
                                     nit:nit,correoElectronico:correoElectronico,paginaWeb:paginaWeb,descipcion:descripcion,referidoPor:referidoPor},
                                    url: Routing.generate('insertarproveedor'),
                                    success: function (data)
                                    {
                                         if (data.estado==true){
                                             
                                         var url=Routing.generate('admin_proveedor_index');
                                        window.open(url,"_self"); 
                                        
                                                         
                                            
                                             
                                         }
                                         else{
                                             
                                                Lobibox.notify("error", {
                                          size: 'mini',
                                          msg: 'Error al insertar los datos, espere un momento'
                                      });
                                            location.reload();
                                            
                                             
                                         }
                                        
                                             
                    
                                         
                                          
                                    },
                                    error: function (xhr, status)
                                    {
                      
                    }
            });

 });
     
 $(document).on("click","#editarCp",function() {
      var idProveedor,nombre, direccion,telefono,telefonoM,nrc,nit,correoElectronico,paginaWeb,descripcion,referidoPor;
              
               idProveedor=$("#idProveedor").val();
               nombre=$("#nombreCp").val();
               direccion=$("#direccionCp").val();
               telefono=$("#telefonoCp").val();
               telefonoM=$("#telefonoMCp").val();
               nrc=$("#nrcCP").val();
               nit=$("#nitCP").val();
               correoElectronico=$("#correoCp").val();
               paginaWeb=$("#paginaWebCp").val();
               descripcion=$("#descripcionCp").val();
               referidoPor=$("#referidoPor").val();
        
          $.ajax({
                                    type: 'POST',
                                    async: false,
                                    dataType: 'json',
                                    data: {idProveedor:idProveedor,nombre:nombre,direccion:direccion,telefono:telefono,telefonoM:telefonoM,nrc:nrc,
                                     nit:nit,correoElectronico:correoElectronico,paginaWeb:paginaWeb,descripcion:descripcion,referidoPor:referidoPor},
                                    url: Routing.generate('editarproveedor'),
                                    success: function (data)
                                    {
                                         if (data.estado==true){
                                             
                                         var url=Routing.generate('admin_proveedor_index');
                                            window.open(url,"_self"); 
                                        
                                                         
                                            
                                             
                                         }
                                         else{
                                             
                                                Lobibox.notify("error", {
                                          size: 'mini',
                                          msg: 'Error al insertar los datos, espere un momento'
                                      });
                                            location.reload();
                                            
                                             
                                         }
                                        
                                             
                    
                                         
                                          
                                    },
                                    error: function (xhr, status)
                                    {
                      
                    }
            });

        
        
         
	
  });
  $(document).on("click","#cancelarEdicionCp",function() {
      
       var url=Routing.generate('admin_proveedor_index');
                                            window.open(url,"_self"); 
      
  });    
     
   $(document).on("click","#cancelarNuevoCp",function() {
      
       var url=Routing.generate('admin_proveedor_index');
                                            window.open(url,"_self"); 
      
  });    
  
  


      
    
 });


