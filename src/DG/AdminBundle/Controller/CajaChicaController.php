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

//        $em = $this->getDoctrine()->getManager();
//
//        $cliente = $em->getRepository('DGAdminBundle:Cliente')->findAll();
        
        return $this->render('cajachica/index.html.twig', array(
            
        ));
    }

     /**
     * 
     *
     * @Route("/cliente/data", name="caja_chica_data")
     */
    public function DataClientePotencialAction(Request $request)
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
           
          $sql = "SELECT cch.id, date_format(cch.fecha,'%d-%m-%Y') as fecha, cch.concepto, per.nombres as nombre, cch.cantidad_por as cantidad, cch.valor  FROM caja_chica cch"
                    . " LEFT OUTER JOIN empleado per on cch.empleado_id=per.id "
                    . "WHERE upper(per.nombres)  LIKE '%".strtoupper($value)."%' "
                    . "ORDER BY cch.fecha ASC";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();
                 
       
        }
        else{
            
              $sql = "SELECT cch.id, date_format(cch.fecha,'%d-%m-%Y') as fecha, cch.concepto, per.nombres as nombre, cch.cantidad_por as cantidad, cch.valor  FROM caja_chica cch"
                    . " LEFT OUTER JOIN empleado per on cch.empleado_id=per.id "
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
    
    
      /**
     * @Route("/insertarRegistroCCH/", name="insertarRegistroCCH", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function InsertarCpAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             
            $em = $this->getDoctrine()->getManager();
            
            $fechaRCCH = $request->get('fechaRCCH');
            
            $fecha = explode('-', $fechaRCCH);
            $fecha2= $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
            
            
            $valor = $request->get('valor');
            $empleado = $request->get('empleado');
            $cantidadPor = $request->get('cantidadPor');
            $descripcionRCCH = $request->get('descripcionRCCH');


            $objeto = new CajaChica();
            $objeto->setConcepto($descripcionRCCH);
            $objeto->setFecha(new \DateTime($fecha2));
            $objeto->setValor($valor);
            
            $empleados = $this->getDoctrine()->getRepository('DGAdminBundle:Empleado')->findById($empleado);
            $objeto->setEmpleadoId($empleados[0]);
            $objeto->setCantidadPor($cantidadPor);
            $em->persist($objeto);
            $em->flush();
          
            
            $data['estado']=true;
                       
            
            
            
            
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
            $objeto = $this->getDoctrine()->getRepository('DGAdminBundle:CajaChica')->findById($idRegistro);
            $n = $objeto[0]->getFecha();
            $i = (DATE_FORMAT($n, 'd-m-Y'));
            
            $data['valor'] = $objeto[0]->getValor();
            $data['fecha'] = $i;
            $data['concepto'] = $objeto[0]->getConcepto();
            $data['nombre'] = $objeto[0]->getNombre();
            $data['cantidadPor'] = $objeto[0]->getCantidadPor();
            $data['empleadoId'] = $objeto[0]->getEmpleadoId()->getId();
            $data['empleadoNombre'] = $objeto[0]->getEmpleadoId()->getNombres();
            $data['idRegistro']=$idRegistro;

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
                       
            
            
            
            
             return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
