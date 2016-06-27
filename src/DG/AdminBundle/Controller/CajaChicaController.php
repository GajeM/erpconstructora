<?php

namespace DG\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\AdminBundle\Entity\CajaChica;
use Symfony\Component\HttpKernel\Exception;

/**
 * CajaChica controller.
 *
 * @Route("admin/cajachica")
 */
class CajaChicaController extends Controller
{
    /**
     * Lists all ClientePotencial entities.
     *
     * @Route("/", name="caja_chica_index",options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {

        return $this->render('cajachica/dashboardcajachica.html.twig', array(
            
        ));
    }
    
    /**
     * Lists all ClientePotencial entities.
     *
     * @Route("/nuevo/salida", name="caja_salida_index",options={"expose"=true})
     * @Method("GET")
     */
    public function indexSalidaAction()
    {
        
        $saldo = $this->llamarSaldoActual();
        return $this->render('cajachica/salidas.html.twig', array(
             'saldo'=>$saldo
            
        ));
    }
    
    
      
    /**
     * Lists all ClientePotencial entities.
     *
     * @Route("/nuevo/ingreso", name="caja_ingresos_index",options={"expose"=true})
     * @Method("GET")
     */
    public function indexIngresoAction()
    {
        $saldo = $this->llamarSaldoActual();
        
        return $this->render('cajachica/ingresos.html.twig', array(
            'saldo'=>$saldo
            
        ));
    }
    
    
    function llamarSaldoActual(){
          $em = $this->getDoctrine()->getEntityManager();
          
          $sql = "SELECT sum(caj.cantidad_por)-(SELECT sum(caj.cantidad_por) as retiros FROM caja_chica caj
                        WHERE caj.estado=1 AND caj.tipo_ingreso=2) as saldo FROM caja_chica caj
                        WHERE caj.estado=1 AND caj.tipo_ingreso=1";
          
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $numero =  $stmt->fetchAll();
            $valor = $numero[0]['saldo'];
            return $valor;
        
    }


    /**
     * 
     *
     * @Route("/cliente/data", name="caja_chica_data")
     */
    public function DataClientePotencialAction(Request $request)
    {
        
        /*         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * Easy set variables
         */
        /* Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        $entity = new CajaChica();
        
        $start = $request->query->get('start');
        $draw = $request->query->get('draw');
        $longitud = $request->query->get('length');
        $busqueda = $request->query->get('search');
        
        $em = $this->getDoctrine()->getEntityManager();
        $territoriosTotal = $em->getRepository('DGAdminBundle:CajaChica')->findAll();
        $territorio['draw']=$draw++;  
        $territorio['recordsTotal'] = count($territoriosTotal);
        $territorio['recordsFiltered']= count($territoriosTotal);
        
        $territorio['data']= array();
        //var_dump($busqueda);
        //die();
        $arrayFiltro = explode(' ',$busqueda['value']);
        
        
        //echo count($arrayFiltro);
        $busqueda['value'] = str_replace(' ', '%', $busqueda['value']);
        
        //SQL Nativo
       


        if($busqueda['value']!=''){
          $value = $busqueda['value'];  
           
          $sql = "SELECT cch.codigo, date_format(cch.fecha,'%d-%m-%Y') as fecha, cch.concepto, per.nombres as nombre, cch.cantidad_por as cantidad, cch.valor, cch.persona_que_recibe as recibio  FROM caja_chica cch"
                    . " LEFT OUTER JOIN empleado per on cch.empleado_id=per.id "
                    . "WHERE upper(per.nombres)  LIKE '%".strtoupper($value)."%' AND cch.tipo_ingreso = 2 AND cch.estado=1 "
                    . "ORDER BY cch.fecha ASC";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();
                 
       
        }
        else{
            
              $sql = "SELECT cch.codigo, date_format(cch.fecha,'%d-%m-%Y') as fecha, cch.concepto, per.nombres as nombre, cch.cantidad_por as cantidad, cch.valor, cch.persona_que_recibe as recibio  FROM caja_chica cch"
                    . " LEFT OUTER JOIN empleado per on cch.empleado_id=per.id WHERE cch.tipo_ingreso = 2 AND cch.estado=1 "
                    . "ORDER BY cch.fecha ASC";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();

        }
     
        
        return new Response(json_encode($territorio));
    }
    

     /**
    * Ajax utilizado para buscar informacion de abogados
    * 
    * @Route("/buscarEmpleado", name="buscarEmpleado",options={"expose"=true})
    */
    public function BuscarEmpleadoAction(Request $request)
    {
        $busqueda = $request->query->get('q');
        $page = $request->query->get('page');
       
        $em = $this->getDoctrine()->getEntityManager();
        $dql = "SELECT abo.id abogadoid, abo.nombres "
                        . "FROM DGAdminBundle:Empleado abo "
                        . "WHERE upper(abo.nombres) LIKE upper(:busqueda) "
                        . "ORDER BY abo.nombres ASC ";
       
        $abogado['data'] = $em->createQuery($dql)
                ->setParameters(array('busqueda'=>"%".$busqueda."%"))
                ->setMaxResults( 10 )
                ->getResult();
       
        return new Response(json_encode($abogado));
    }
    
       //Salidas de dinero registro de salidas de dinero
    

      /**
     * @Route("/insertarRegistroCCH/", name="insertarRegistroCCH", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function InsertarRegistroSalidaCCHAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             
            $em = $this->getDoctrine()->getManager();
            $identificador=1;
            $fechaRCCH = $request->get('fechaRCCH');
            
            $fecha = explode('-', $fechaRCCH);
            $fecha2= $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
            
            $personaEntrega = $request->get('personaEntrega');
            $valor = $request->get('valor');
            $personaRecibe = $request->get('personaRecibe');
            $cantidadPor = $request->get('cantidadPor');
            $descripcionRCCH = $request->get('descripcionRCCH');
            
            
            $codigo= $this->generarCorrelativo($identificador);
            $objeto = new CajaChica();
            $objeto->setConcepto($descripcionRCCH);
            $objeto->setFecha(new \DateTime($fecha2));
            $objeto->setValor($valor);
            $objeto->setPersonaQueRecibe($personaRecibe);
            $objeto->setNombre($personaEntrega);
            $objeto->setCantidadPor($cantidadPor);
            $objeto->setTipoIngreso(2);
            $objeto->setCodigo($codigo);
            $objeto->setEstado(1);
            $em->persist($objeto);
            $em->flush();
            

            
            $data['estado']=true;
            $data['saldo']=  $this->llamarSaldoActual();
            
            return new Response(json_encode($data)); 

         }
        
        
        
    }
    
     /**
     * @Route("/validarRegistroCCH/", name="validarRegistroCCH", options={"expose"=true})
     * @Method("POST")
     */
    
    function validarMonto (Request $request)
    {
          $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
              $cantidadPor = $request->get('cantidadPor');
              $saldo = $this->llamarSaldoActual();
             
              if ($saldo<$cantidadPor){
                 
                     $data['estado']=false;
                     $data['saldo']=$saldo;
             }else{
                   $data['estado']=true;
             }
             
            
            
            return new Response(json_encode($data)); 
              
              
              
              
              
         }
        
        
        
        
    }


    
    
    
    
    
     /**
     * @Route("/eliminarRegistroCCH/", name="eliminarRegistroCCH", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function EliminarRegistroCCHAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             
            $em = $this->getDoctrine()->getManager();
            
            $idRegistro = $request->get('idEliminar');
            $objeto=  $this->getDoctrine()->getRepository('DGAdminBundle:CajaChica')->findById($idRegistro);
            $em->remove($objeto[0]);
            $em->flush();
            $data['estado']=true;
                       
            
            
            
            
             return new Response(json_encode($data)); 
            
            
         }
    
        
        
    } 
    
  
    
      /**
     * @Route("/llamarRegistrosRegistroCCH/", name="llamarRegistrosRegistroCCH", options={"expose"=true})
     * @Method("POST")
     */
      public function LlamarRegistrosRegistroCCHAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             
            $em = $this->getDoctrine()->getManager();
            
            $idRegistro = $request->get('idRegistro');
            $objeto = $this->getDoctrine()->getRepository('DGAdminBundle:CajaChica')->findByCodigo($idRegistro);
            $n = $objeto[0]->getFecha();
            $i = (DATE_FORMAT($n, 'd-m-Y'));
            
            $data['valor'] = $objeto[0]->getValor();
            $data['fecha'] = $i;
            $data['concepto'] = $objeto[0]->getConcepto();
            $data['nombre'] = $objeto[0]->getNombre();
            $data['cantidadPor'] = $objeto[0]->getCantidadPor();
            $data['empleadoId'] = $objeto[0]->getEmpleadoId()->getId();
            $data['empleadoNombre'] = $objeto[0]->getEmpleadoId()->getNombres();
            $data['idRegistro']=$objeto[0]->getId();

            $data['estado'] = true;





            return new Response(json_encode($data)); 
            
            
         }
    
        
    }
 
   /**
     * @Route("/editarRegistroCCH/", name="editarRegistroCCH", options={"expose"=true})
     * @Method("POST")
     */
      public function EditarRegistroCCHAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             
            $em = $this->getDoctrine()->getManager();
            
            $fechaRCCH = $request->get('fechaRCCH');
            
            $fecha = explode('-', $fechaRCCH);
            $fecha2= $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
            
            $idRegistro= $request->get('idRegistro');
            
            $valor = $request->get('valor');
            $empleado = $request->get('empleado');
            $cantidadPor = $request->get('cantidadPor');
            $descripcionRCCH = $request->get('descripcionRCCH');


            $objeto = $this->getDoctrine()->getRepository('DGAdminBundle:CajaChica')->findById($idRegistro);
            $objeto[0]->setConcepto($descripcionRCCH);
            $objeto[0]->setFecha(new \DateTime($fecha2));
            $objeto[0]->setValor($valor);
            
            $empleados = $this->getDoctrine()->getRepository('DGAdminBundle:Empleado')->findById($empleado);
            $objeto[0]->setEmpleadoId($empleados[0]);
            $objeto[0]->setCantidadPor($cantidadPor);
            $em->merge($objeto[0]);
            $em->flush();
          
            
            $data['estado']=true;
              $data['saldo']=  $this->llamarSaldoActual();         
            
            
            
            
             return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }   
    
    
    
     
     public function generarCorrelativo($identificador){
    
       
        $em = $this->getDoctrine()->getManager();
        // 1 para retiro,
        //2 para reintegro
        
        
         if ($identificador==1){
            $dqlNumerocorrelativo = "SELECT COUNT(u.id) as numero FROM DGAdminBundle:CajaChica u"
            . " WHERE u.codigo like '%NRR%' AND u.tipoIngreso =2";
            $resultCorrelativo = $em->createQuery($dqlNumerocorrelativo)->getArrayResult();
            $numero_base = $resultCorrelativo[0]['numero'];
            
            $primerLetras="NRR"; 
         }else{
             
              $dqlNumerocorrelativo = "SELECT COUNT(u.id) as numero FROM DGAdminBundle:CajaChica u"
            . " WHERE u.codigo like '%NRI%' AND u.tipoIngreso =1";
            $resultCorrelativo = $em->createQuery($dqlNumerocorrelativo)->getArrayResult();
            $numero_base = $resultCorrelativo[0]['numero'];
            
            $primerLetras="NRI"; 
             
         }
        
        

       $valor ="";
        
       $numero = $numero_base+1;
        switch (strlen($numero_base)){
            case 1:
                $valor=$primerLetras.="0000".$numero;
            break;
            case 2:    
                $valor=$primerLetras.="000".$numero;
            break;
            case 3:    
                 $valor=$primerLetras.="00".$numero;
            break;
            case 4:    
                $valor=$primerLetras.="0".$numero;
            break;
            case 5:    
                  $valor=$primerLetras.=$numero;
            break;
        }
        return $valor;
     }
    
    
    //Ingresos de efectivos
     
      /**
     * 
     *
     * @Route("/cajachica/ingresos/data", name="caja_chica_data_ingresos")
     */
    public function DataCajaChicaIngresosAction(Request $request)
    {
        
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * Easy set variables
         */

        /* Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        $entity = new CajaChica();
        
        $start = $request->query->get('start');
        $draw = $request->query->get('draw');
        $longitud = $request->query->get('length');
        $busqueda = $request->query->get('search');
        
        $em = $this->getDoctrine()->getEntityManager();
        $territoriosTotal = $em->getRepository('DGAdminBundle:CajaChica')->findAll();
        $territorio['draw']=$draw++;  
        $territorio['recordsTotal'] = count($territoriosTotal);
        $territorio['recordsFiltered']= count($territoriosTotal);
        
        $territorio['data']= array();
        //var_dump($busqueda);
        //die();
        $arrayFiltro = explode(' ',$busqueda['value']);
        
        
        //echo count($arrayFiltro);
        $busqueda['value'] = str_replace(' ', '%', $busqueda['value']);
        
        //SQL Nativo
       


        if($busqueda['value']!=''){
          $value = $busqueda['value'];  
           
          $sql = "SELECT cch.codigo, date_format(cch.fecha,'%d-%m-%Y') as fecha,cch.nombre, cch.concepto, cch.persona_que_recibe as recibio, cch.cantidad_por as cantidad, cch.valor  FROM caja_chica cch "
                    . "WHERE upper(cch.codigo)  LIKE '%".strtoupper($value)."%' AND cch.tipo_ingreso = 1 AND cch.estado=1 "
                    . "ORDER BY cch.fecha ASC";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();
                 
       
        }
        else{
            
              $sql = "SELECT cch.codigo, date_format(cch.fecha,'%d-%m-%Y') as fecha, cch.concepto,cch.nombre,  cch.persona_que_recibe as recibio,  cch.cantidad_por as cantidad, cch.valor  FROM caja_chica cch"
                    . " WHERE cch.tipo_ingreso = 1 AND cch.estado=1 "
                    . "ORDER BY cch.fecha ASC";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();

        }
     
        
        return new Response(json_encode($territorio));
    }
      
       
      /**
     * @Route("/insertarRegistroCCHIngresos/", name="insertarRegistroCCHIngresos", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function InsertarRegistroSalidaCCHIngresosAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             
            $em = $this->getDoctrine()->getManager();
            $identificador=2;
            $fechaRCCH = $request->get('fechaRCCH');
            
            $fecha = explode('-', $fechaRCCH);
            $fecha2= $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
            
            $personaEntrega = $request->get('personaEntrega');
            $personaRecibeIngresos=$request->get('personaRecibeIngresos');
            $valor = $request->get('valor');
            $cantidadPor = $request->get('cantidadPor');
            $descripcionRCCH = $request->get('descripcionRCCH');
            
            
            $codigo= $this->generarCorrelativo($identificador);
            $objeto = new CajaChica();
            $objeto->setConcepto($descripcionRCCH);
            $objeto->setFecha(new \DateTime($fecha2));
            $objeto->setValor($valor);
            $objeto->setPersonaQueRecibe($personaRecibeIngresos);
            $objeto->setNombre($personaEntrega);
            $objeto->setCantidadPor($cantidadPor);
            $objeto->setTipoIngreso(1);
            $objeto->setCodigo($codigo);
            $objeto->setEstado(1);
            $em->persist($objeto);
            $em->flush();
            
            
            $data['estado']=true;
            $data['saldo']=  $this->llamarSaldoActual();
            
            
            
             return new Response(json_encode($data)); 

         }
        
        
        
    }
     
     
     
       /**
     * @Route("/llamarRegistrosRegistroCCHIngresos/", name="llamarRegistrosRegistroCCHIngresos", options={"expose"=true})
     * @Method("POST")
     */
      public function LlamarRegistrosRegistroCCHIngresosAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             
            $em = $this->getDoctrine()->getManager();
            
            $idRegistro = $request->get('idRegistro');
          
            $objeto = $this->getDoctrine()->getRepository('DGAdminBundle:CajaChica')->findByCodigo($idRegistro);
            $n = $objeto[0]->getFecha();
            $i = (DATE_FORMAT($n, 'd-m-Y'));
            
            $data['valor'] = $objeto[0]->getValor();
            $data['fecha'] = $i;
            $data['concepto'] = $objeto[0]->getConcepto();
            $data['nombre'] = $objeto[0]->getNombre();
            $data['cantidadPor'] = $objeto[0]->getCantidadPor();
           $data['pesonaQueRecibe'] =$objeto[0]->getPersonaQueRecibe();
            $data['idRegistro']=$objeto[0]->getId();
         
            $data['estado'] = true;





            return new Response(json_encode($data)); 
            
            
         }
    
        
    }
    
      
   /**
     * @Route("/editarRegistroCCHEIngresos/", name="editarRegistroCCHEIngresos", options={"expose"=true})
     * @Method("POST")
     */
      public function EditarRegistroCCHAEIngresosAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             
            $em = $this->getDoctrine()->getManager();
            
            $fechaRCCH = $request->get('fechaRCCH');
            
            $fecha = explode('-', $fechaRCCH);
            $fecha2= $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
            
            $idRegistro= $request->get('idRegistro');

            $valor = $request->get('valor');
            $personaEntreEgaIngresos = $request->get('personaEntreEgaIngresos');
            $cantidadPor = $request->get('cantidadPor');
            $descripcionRCCH = $request->get('descripcionRCCH');
            $personaRecibeEIngresos= $request->get('personaRecibeEIngresos');


            $objeto = $this->getDoctrine()->getRepository('DGAdminBundle:CajaChica')->findById($idRegistro);
            $objeto[0]->setConcepto($descripcionRCCH);
            $objeto[0]->setFecha(new \DateTime($fecha2));
            $objeto[0]->setValor($valor);
            $objeto[0]->setCantidadPor($cantidadPor);
            $objeto[0]->setNombre($personaEntreEgaIngresos);
            $objeto[0]->setPersonaQueRecibe($personaRecibeEIngresos);
            $em->merge($objeto[0]);
            $em->flush();
          
             $data['saldo']=  $this->llamarSaldoActual();
             $data['estado']=true;
                       
            
            
            
            
             return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }   
    
    
    
    
    
    
    
    
    
    
}
