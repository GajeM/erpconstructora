<?php

namespace DG\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\AdminBundle\Entity\ClientePotencial;
use DG\AdminBundle\Form\ClientePotencialType;
use Symfony\Component\HttpKernel\Exception;

/**
 * ClientePotencial controller.
 *
 * @Route("admin/clientepotencial")
 */
class ClientePotencialController extends Controller
{
    /**
     * Lists all ClientePotencial entities.
     *
     * @Route("/", name="admin_clientepotencial_index",options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clientePotencials = $em->getRepository('DGAdminBundle:ClientePotencial')->findAll();

        return $this->render('clientepotencial/index.html.twig', array(
            'clientePotencials' => $clientePotencials,
        ));
    }

    /**
     * Lists all ClientePotencial entities.
     *
     * @Route("/nuevoclientepotencial", name="nuevoclientepotencial")
     * @Method("GET")
     */
    public function NuevoClientePotencialAction()
    {
        
        return $this->render('clientepotencial/nuevo.html.twig', array(
            
        ));
    }
 
    /**
     * @Route("/admin/{id}", name="editarClientePotencial", options={"expose"=true})
     * @Method("GET")
     */
    public function EditarClientePotencialAction($id)
    {
        
      
        
        $em = $this->getDoctrine()->getManager();
        $clientePotencials = $em->getRepository('DGAdminBundle:ClientePotencial')->findById($id);
     
     
        return $this->render('clientepotencial/editar.html.twig', array(
            'clientePotencial' => $clientePotencials,
        ));
    }
    
    
    
    
    
    
    
   
   /**
     * 
     *
     * @Route("/clientepotencial/data", name="clientepotencial_data")
     */
    public function DataClientePotencialAction(Request $request)
    {
        
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
        $entity = new ClientePotencial();
        
        $start = $request->query->get('start');
        $draw = $request->query->get('draw');
        $longitud = $request->query->get('length');
        $busqueda = $request->query->get('search');
        
        $em = $this->getDoctrine()->getEntityManager();
        $territoriosTotal = $em->getRepository('DGAdminBundle:ClientePotencial')->findAll();
        $territorio['draw']=$draw++;  
        $territorio['recordsTotal'] = count($territoriosTotal);
        $territorio['recordsFiltered']= count($territoriosTotal);
        
        $territorio['data']= array();
        //var_dump($busqueda);
        //die();
        $arrayFiltro = explode(' ',$busqueda['value']);
        
        
        //echo count($arrayFiltro);
        $busqueda['value'] = str_replace(' ', '%', $busqueda['value']);
        if($busqueda['value']!=''){
        
                    $dql = "SELECT cp.id as id, cp.nombre as nombre,cp.telefono as telefono, cp.direccion as direccion, concat(concat('<input type=\"checkbox\" class=\"checkbox idClientePotencial\" id=\"',cp.id), '\">' as link "
                            . ", concat('<a class=\"btn btn-success CP\" id=\"',cp.id, '\">Ver mas</a>') as link2 FROM DGAdminBundle:ClientePotencial cp  "
                        . "WHERE upper(cp.nombre)  LIKE upper(:busqueda) AND cp.estado=1 "
                        . "ORDER BY cp.nombre DESC ";
                    
                    //Aqui estas trabjando
                   $territorio['data'] = $em->createQuery($dql)
                            ->setParameters(array('busqueda'=>"%".$busqueda['value']."%"))
                            ->getResult();
                    
                   $territorio['recordsFiltered']= count($territorio['data']);
                    
                    $dql = "SELECT cp.id as id , cp.nombre as nombre,cp.telefono as telefono, cp.direccion as direccion, concat(concat('<input type=\"checkbox\" class=\"checkbox idClientePotencial\" id=\"',cp.id), '\">' as link"
                            . ", concat('<a class=\"btn btn-success CP \" id=\"',cp.id, '\">Ver mas</a>') as link2 FROM DGAdminBundle:ClientePotencial cp  "
                        . "WHERE upper(cp.nombre)  LIKE upper(:busqueda)  AND cp.estado=1 "
                        . "ORDER BY cp.nombre DESC ";
                   
                   $territorio['data'] = $em->createQuery($dql)
                            ->setParameters(array('busqueda'=>"%".$busqueda['value']."%"))
                            ->setFirstResult($start)
                            ->setMaxResults($longitud)
                            ->getResult();
       
        }
        else{
            $dql = "SELECT cp.id as id , cp.nombre as nombre,cp.telefono as telefono, cp.direccion as direccion, concat(concat('<input type=\"checkbox\" class=\"checkbox idClientePotencial\" id=\"',cp.id), '\">' as link,"
                    . " concat('<a class=\"btn btn-success CP\" id=\"',cp.id, '\">Ver mas</a>') as link2 FROM DGAdminBundle:ClientePotencial cp  "
                    . " WHERE  cp.estado=1"
                    . " ORDER BY cp.nombre  DESC ";
                    $territorio['data'] = $em->createQuery($dql)
                    ->setFirstResult($start)
                    ->setMaxResults($longitud)
                    ->getResult();
        }
     
        
        return new Response(json_encode($territorio));
    }
    
    
    /**
     * @Route("/insertarCp/", name="insertarCp", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function InsertarCpAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             
            $em = $this->getDoctrine()->getManager();
            
            $nombre = $request->get('nombre'); 
            $direccion = $request->get('direccion'); 
            $telefono = $request->get('telefono'); 
            $telefonoM = $request->get('telefonoM'); 
            $nrc = $request->get('nrc'); 
            $nit = $request->get('nit'); 
            $correoElectronico = $request->get('correoElectronico');
            $paginaWeb = $request->get('paginaWeb');
            $descripcion = $request->get('descripcion');
            $referidoPor = $request->get('referidoPor'); 

              
            $objeto = new ClientePotencial();
            $objeto->setNombre($nombre);
            $objeto->setDireccion($direccion);
            $objeto->setTelefono($telefono);
            $objeto->setMovil($telefonoM);
            $objeto->setNrc($nrc);
            $objeto->setNit($nit);
            $objeto->setCorreoelectronico($correoElectronico);
            $objeto->setPaginaWeb($paginaWeb);
            $objeto->setReferidoPor($referidoPor);
            $objeto->setDescripcion($descripcion);
            $objeto->setEstado(1);
            $em->persist($objeto);
            $em->flush();
          
            
            $data['estado']=true;
                       
            
            
            
            
             return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }
   /**
     * @Route("/editarCp/", name="editarCp", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function EditarCpAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
               $id= $request->get('idClienteP');
             $em = $this->getDoctrine()->getManager();
             
            $objeto = $em->getRepository('DGAdminBundle:ClientePotencial')->findById($id);
            
            $nombre = $request->get('nombre');
            $direccion = $request->get('direccion'); 
            $telefono = $request->get('telefono'); 
            $telefonoM = $request->get('telefonoM'); 
            $nrc = $request->get('nrc'); 
            $nit = $request->get('nit'); 
            $correoElectronico = $request->get('correoElectronico');
            $paginaWeb = $request->get('paginaWeb');
            $descripcion = $request->get('descripcion');
        
            $referidoPor = $request->get('referidoPor'); 

            $objeto[0]->setNombre($nombre);
            $objeto[0]->setDireccion($direccion);
            $objeto[0]->setTelefono($telefono);
            $objeto[0]->setMovil($telefonoM);
            $objeto[0]->setNrc($nrc);
            $objeto[0]->setNit($nit);
            $objeto[0]->setCorreoelectronico($correoElectronico);
            $objeto[0]->setPaginaWeb($paginaWeb);
            $objeto[0]->setReferidoPor($referidoPor);
            $objeto[0]->setDescripcion($descripcion);
            $em->merge($objeto[0]);
            $em->flush();
            
            $data['estado']=true;
                       
            
            
            
            
             return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }
    
 /**
     * Displays a form to edit an existing Orden entity.
     *
     * @Route("/admin/eliminarclientePotencial", name="eliminarclientePotencial")
     */
    public function EliminarClienteAction()
    {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        $response = new JsonResponse();
        
            $idcliente = $this->get('request')->request->get('idclientepotencial');
     
            foreach($idcliente as $row){
                $em = $this->getDoctrine()->getManager();
                $cliente = $em->getRepository('DGAdminBundle:ClientePotencial')->find($row);    
                $cliente->setEstado(0);
                $em->persist($cliente);
                $em->flush();
                
            }
   
            $response->setData(array(
                            'flag' => 0,
                            
                    ));    
            return $response; 
       
        
        
        
    }   
    
    
    
    
    
    
    
}
