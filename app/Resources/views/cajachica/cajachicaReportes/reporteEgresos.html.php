<!DOCTYPE HTML>
<html lang="Es">
<head>
    <title>Reporte de egresos en caja chica</title>
	<style type="text/css">
		body{font-size:0.80em;}
		.Cabecera{}
                
                .thClass{
                    height: 20px;
                    width: 120px;
                }
                .tdProductoE{
                     height: 10px;
                    width: 100px;
                     text-align: right; 
                }
                
                .tdC{
                    text-align: right;
                    
                }
                .tdProducto{
                    text-align: left; 
                }
                
                .encabezado{
                   
                    font-size: 15px;
                    
                }
                body {
                    font-family: 'Open Sans', sans-serif;
                }
	</style>


</head>
<body>
    
	
      <div >
    
             <div style="height: 120px; margin-bottom: -20px;">
              <table>
                
                    <tr>
                        <td colspan="5" style="font-size: 18px; font-weight: 600;text-transform: uppercase;"> Reporte de egresos en caja chica</td>
                    </tr>
                    <tr>
                      <td class="tdProductoE"><b>Rango de fechas:</b></td>
                      <td class="tdProducto">
                        <?php 
                      
                            if ($fechaInicio!=0 && $fechaFin!=0 ){

                                 echo ''.$fechaInicio ."  al   ".$fechaFin;

                            }else{
                                echo "No ha seleccionado un rango de fechas";
                                
                            }
                        
                        ?>
                      </td>
                     

                       </tr>
                         
              </table>
                
        </div>
			
			
          <div style="border-top: 2px solid #888888;"></div>   
         <div>
            <p style="font-size: 17px; font-weight: 600;  text-transform: uppercase;">Detalle de ingresos</p>
        </div>  	
    <div style="margin-top: 10px; margin-left: 40px;">
      
        
       <table style="border: 2px solid #3C2D2D; ">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th class="thClass">Codigo</th>
                <th class="thClass">Fecha</th>
                <th class="thClass">Entregó</th>
                <th class="thClass">Recibió</th>
                <th class="thClass">Monto</th>

            </tr>
        </thead>
              <?php
              $dimension = count($datos);
              $total =0;
              
              for ($i=0;$i<$dimension;$i++){
                   $total=$total+ $datos[$i]['monto'];
                    
                    ?>  
                  <tr>
                      <td class="tdProducto">
                            <?php
                            echo $datos[$i]['codigo'];
                             ?>
                        </td>
                          <td class="tdProducto">
                            <?php
                            echo $datos[$i]['fecha'];
                             ?>
                        </td>
                        <td class="tdProducto">
                            <?php
                            echo $datos[$i]['recibe'];
                             ?>
                        </td>
                      
                         <td class="tdProducto">
                            <?php
                            echo $datos[$i]['entrega'];
                             ?>
                        </td>
                         <td class="tdC">
                         <?php
                            echo "$ ". number_format($datos[$i]['monto'],2);
                             ?>
                        </td>
                    
                  </tr>
                             <?php
                             }
                    ?>  
    </table>
        <div style="margin-top: 20px; margin-left: 430px;">
                <table>
                        <tr>
                           <td class="tdProductoE"><b>Total ingresos registrados:</b></td><td class="tdC"><?php echo "$  ".$total ?>     </td>
                       </tr>
                 </table>
          </div>  
    </div>
         
          
          
</div>
</body>
</html> 





