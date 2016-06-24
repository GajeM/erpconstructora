<?php

namespace DG\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\AdminBundle\Entity\Proyecto;
use Symfony\Component\HttpKernel\Exception;

/**
 * Maquina controller.
 *
 * @Route("admin/proyectos")
 */
class ProyectoController extends Controller
{
    /**
     * Lists all Proyecto entities.
     *
     * @Route("/", name="admin_proyecto_index",options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {


        return $this->render('proyectos/index.html.twig', array(
           
        ));
    }
    
    
    
     /**
     * 
     *
     * @Route("/proyectos/data", name="proyecto_data")
     */
    public function DataProyectoAction(Request $request)
    {
        
        /** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * Easy set variables
         */
        /* Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        $entity = new Proyecto();
        
        $start = $request->query->get('start');
        $draw = $request->query->get('draw');
        $longitud = $request->query->get('length');
        $busqueda = $request->query->get('search');
        
        $em = $this->getDoctrine()->getEntityManager();
        $territoriosTotal = $em->getRepository('DGAdminBundle:Proyecto')->findAll();
        $territorio['draw']=$draw++;  
        $territorio['recordsTotal'] = count($territoriosTotal);
        $territorio['recordsFiltered']= count($territoriosTotal);
        
        $territorio['data']= array();

        $arrayFiltro = explode(' ',$busqueda['value']);
        
        
        //echo count($arrayFiltro);
        $busqueda['value'] = str_replace(' ', '%', $busqueda['value']);
        
        //SQL Nativo
        
        
         $ordenamientoVariable = $request->query->get('order');
        
//        var_dump($ordenamientoVariable);
//        die();
        
        $columna = $ordenamientoVariable[0]['column'];
        $tipoOrdenamiento = $ordenamientoVariable[0]['dir'];
        
        if ($columna=='0'){
            
          
             $x='codigo';
            
        }else if ($columna=='2'){
             $x="cliente_id";
            
            
        }else  if ($columna=='5'){
            
            $x='fecha_inicio';
        
            
        }else  if ($columna=='6'){
            
            $x='fecha_final';
  
        }

        if($busqueda['value']!=''){
          $value = $busqueda['value'];  
           
          $sql = "SELECT pro.codigo, pro.nombre, cli.nombre as nombreCliente, cont.nombre as nombreContacto, pro.direccion, DATE_FORMAT(pro.fecha_inicio,'%d-%m-%Y') as fechaInicio, "
                    . "DATE_FORMAT(pro.fecha_final,'%d-%m-%Y') as fechaFinal"
                    . "  FROM proyecto pro"
                    . " LEFT OUTER JOIN cliente cli ON pro.cliente_id = cli.id "
                    . " LEFT OUTER JOIN contacto  cont ON pro.contacto_id = cont.id "
                    . "WHERE upper(pro.codigo)  LIKE '%".strtoupper($value)."%'  "
                    . "ORDER BY pro.".$x." ".$tipoOrdenamiento;

            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();
            $territorio['recordsFiltered']= count($territorio['data']);
                 
       
        }
        else{
               $sql = "SELECT pro.codigo, pro.nombre, cli.nombre as nombreCliente, cont.nombre as nombreContacto, pro.direccion, DATE_FORMAT(pro.fecha_inicio,'%d-%m-%Y') as fechaInicio, "
                    . "DATE_FORMAT(pro.fecha_final,'%d-%m-%Y') as fechaFinal"
                    . "  FROM proyecto pro"
                    . " LEFT OUTER JOIN cliente cli ON pro.cliente_id = cli.id "
                    . " LEFT OUTER JOIN contacto  cont ON pro.contacto_id = cont.id "
                   . "ORDER BY pro.".$x." ".$tipoOrdenamiento;
               
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();
            $territorio['recordsFiltered']= count($territorio['data']);


        }
     
        
        return new Response(json_encode($territorio));
    }
    
    
    
      /**
     * Lists all Proyecto entities.
     *
     * @Route("nuevoProyecto/", name="nuevoProyecto",options={"expose"=true})
     * @Method("GET")
     */
    public function NuevoProyectoAction()
    {


        return $this->render('proyectos/nuevo.html.twig', array(
           
        ));
    }
    
    
    
    
    
    /**
    * Ajax utilizado para buscar informacion de contactos
    * 
    * @Route("/buscarCliente", name="buscarCliente",options={"expose"=true})
    */
    public function BuscarClienteAction(Request $request)
    {
        $busqueda = $request->query->get('q');
        $page = $request->query->get('page');
       
        $em = $this->getDoctrine()->getEntityManager();
        $dql = "SELECT cli.id clienteid, cli.nombre  "
                        . "FROM DGAdminBundle:Cliente cli "
                        . "WHERE upper(cli.nombre) LIKE upper(:busqueda)"
                        . " AND cli.estado=1 "
                        . "ORDER BY cli.nombre ASC ";
       
        $abogado['data'] = $em->createQuery($dql)
                ->setParameters(array('busqueda'=>"%".$busqueda."%"))
                ->setMaxResults( 10 )
                ->getResult();
       
        return new Response(json_encode($abogado));
    }
    
    
     
    /**
    * Ajax utilizado para buscar informacion de contactos
    * 
    * @Route("/buscarEstadoProyecto", name="buscarEstadoProyecto",options={"expose"=true})
    */
    public function BuscarEstadoProyectoAction(Request $request)
    {
        $busqueda = $request->query->get('q');
        $page = $request->query->get('page');
       
        $em = $this->getDoctrine()->getEntityManager();
        $dql = "SELECT est.id estadoId, est.nombre  "
                        . "FROM DGAdminBundle:EstadoProyecto est "
                        . "WHERE upper(est.nombre) LIKE upper(:busqueda)"
                        . " AND est.estado=1 "
                        . "ORDER BY est.nombre ASC ";
       
        $abogado['data'] = $em->createQuery($dql)
                ->setParameters(array('busqueda'=>"%".$busqueda."%"))
                ->setMaxResults( 10 )
                ->getResult();
       
        return new Response(json_encode($abogado));
    }
    
    
     /**
    * Ajax utilizado para buscar informacion de contactos
    * 
    * @Route("/buscarTipoProyecto", name="buscarTipoProyecto",options={"expose"=true})
    */
    public function BuscarTipoProyectoAction(Request $request)
    {
        $busqueda = $request->query->get('q');
        $page = $request->query->get('page');
       
        $em = $this->getDoctrine()->getEntityManager();
        $dql = "SELECT est.id estadoId, est.nombre  "
                        . "FROM DGAdminBundle:TipoProyecto est "
                        . "WHERE upper(est.nombre) LIKE upper(:busqueda)"
                        . " AND est.estado=1 "
                        . "ORDER BY est.nombre ASC ";
       
        $abogado['data'] = $em->createQuery($dql)
                ->setParameters(array('busqueda'=>"%".$busqueda."%"))
                ->setMaxResults( 10 )
                ->getResult();
       
        return new Response(json_encode($abogado));
    }
    
    
    
      /**
    * Ajax utilizado para buscar informacion de contactos
    * 
    * @Route("/buscarEncargadoProyecto", name="buscarEncargadoProyecto",options={"expose"=true})
    */
    public function BuscarEncargadoProyectoAction(Request $request)
    {
        $busqueda = $request->query->get('q');
        $page = $request->query->get('page');
       
        $em = $this->getDoctrine()->getEntityManager();
        $dql = "SELECT est.id estadoId, est.nombre  "
                        . "FROM DGAdminBundle:EncargadoProyecto est "
                        . "WHERE upper(est.nombre) LIKE upper(:busqueda)"
                        . " AND est.estado=1 "
                        . "ORDER BY est.nombre ASC ";
       
        $abogado['data'] = $em->createQuery($dql)
                ->setParameters(array('busqueda'=>"%".$busqueda."%"))
                ->setMaxResults( 10 )
                ->getResult();
       
        return new Response(json_encode($abogado));
    }
    
    
    
    
    
     /**
     * @Route("/insertarDatosGeneralesProyecto/", name="insertarDatosGeneralesProyecto", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function InsertarDatosGeneralesProyectoAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             
            $em = $this->getDoctrine()->getManager();

            $nombreProyecto = $request->get('nombreProyecto');
            $idcliente = $request->get('idcliente');
            $contactoDirecto = $request->get('contactoDirecto');
            $direccionProyecto = $request->get('direccionProyecto');
            $estadoProyecto = $request->get('estadoProyecto');
            $tipoProyecto = $request->get('tipoProyecto');
            $fechaInicio = $request->get('fechaInicio');
            $fechaFin = $request->get('fechaFin');
            $encargadoProyecto = $request->get('encargadoProyecto');
            $observacionesProyecto = $request->get('observacionesProyecto');
            
            if ($contactoDirecto!=null){
                $objContacto = $this->getDoctrine()->getRepository('DGAdminBundle:Contacto')->findById($contactoDirecto);

            }else{
                $objContacto=null;
            }
      
             $objCliente =$this->getDoctrine()->getRepository('DGAdminBundle:Cliente')->findById($idcliente);
             $objEstadoProyecto =$this->getDoctrine()->getRepository('DGAdminBundle:EstadoProyecto')->findById($estadoProyecto);
             $objTipoProyecto =$this->getDoctrine()->getRepository('DGAdminBundle:TipoProyecto')->findById($tipoProyecto);
             $objEncargadoProyecto =$this->getDoctrine()->getRepository('DGAdminBundle:EncargadoProyecto')->findById($encargadoProyecto);
             
            $fecha = explode('-', $fechaInicio);
            $fechaInicios = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0];

            $fecha2 = explode('-', $fechaFin);
            $fechaFinal = $fecha2[2] . '-' . $fecha2[1] . '-' . $fecha2[0];
            $codigo = $this->generarCorrelativoProyecto();
            
            $objeto = new Proyecto();
            $objeto->setNombre($nombreProyecto);
            $objeto->setCodigo($codigo);
            $objeto->setFechaInicio(new \DateTime($fechaInicios));
            $objeto->setFechaFinal(new \DateTime($fechaFinal));
            $objeto->setContacto($objContacto[0]);
            $objeto->setCliente($objCliente[0]);
            $objeto->setDireccion($direccionProyecto);
            $objeto->setEncargadoProyecto($objEncargadoProyecto[0]);
            $objeto->setTipoProyecto($objTipoProyecto[0]);
            $objeto->setObservaciones($observacionesProyecto);
            $objeto->setEstadoProyecto($objEstadoProyecto[0]);
            $em->persist($objeto);
            $em->flush();
            $data['estado'] = true;

            return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }
    
    
    
    
    
    public function generarCorrelativoProyecto(){
    
       
        $em = $this->getDoctrine()->getManager();
        $dqlNumerocorrelativo = "SELECT COUNT(u.id) as numero FROM DGAdminBundle:Proyecto u"
                . " WHERE u.codigo like '%CVP%' ";
        $resultCorrelativo = $em->createQuery($dqlNumerocorrelativo)->getArrayResult();
        $numero_base = $resultCorrelativo[0]['numero'];
        
        
       $primerLetras="CVP"; 
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
     
    
    
     /**
     * @Route("/validarNombreProyecto/", name="validarNombreProyecto", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function ValidarNombreProyectoAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             
            $em = $this->getDoctrine()->getManager();
            $nombreProyecto = $request->get('nombreProyecto');
            
            $dql = "SELECT COUNT(u.id) as numero FROM DGAdminBundle:Proyecto u"
                    . " WHERE u.nombre = '".$nombreProyecto."'";
            
            $valor = $em->createQuery($dql)->getArrayResult();
            $numero = $valor[0]['numero'];

            if ($numero==0){
                            $data['estado'] = true;

            }else{
                $data['estado']=false;
            }
            

            return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
  }
  