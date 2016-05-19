<?php

namespace DG\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\AdminBundle\Entity\Contacto;
use DG\AdminBundle\Form\ContactioType;
use Symfony\Component\HttpKernel\Exception;

/**
 * Contacto controller.
 *
 * @Route("admin/contacto")
 */
class ContactoController extends Controller
{
    /**
     * Lists all ClientePotencial entities.
     *
     * @Route("/", name="admin_contacto_index",options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contactos = $em->getRepository('DGAdminBundle:Contacto')->findAll();

        return $this->render('contactos/index.html.twig', array(
            'contactos' => $contactos,
        ));
    }

    /**
     * Lists all ClientePotencial entities.
     *
     * @Route("/nuevocontacto", name="nuevocontacto")
     * @Method("GET")
     */
    public function NuevoContactoAction()
    {
        
        return $this->render('contactos/nuevo.html.twig', array(
            
        ));
    }
 
    /**
     * @Route("/admin/{id}", name="editarContacto", options={"expose"=true})
     * @Method("GET")
     */
    public function EditarContactosAction($id)
    {
        
      
        
        $em = $this->getDoctrine()->getManager();
        $contacto = $em->getRepository('DGAdminBundle:Contacto')->findById($id);
     
     
        return $this->render('contactos/editar.html.twig', array(
            'contacto' => $contacto,
        ));
    }
    

   
   /**
     * 
     *
     * @Route("/contacto/data", name="contacto_data")
     */
    public function DataContactoAction(Request $request)
    {
        
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
        $entity = new Contacto();
        
        $start = $request->query->get('start');
        $draw = $request->query->get('draw');
        $longitud = $request->query->get('length');
        $busqueda = $request->query->get('search');
        
        $em = $this->getDoctrine()->getEntityManager();
        $territoriosTotal = $em->getRepository('DGAdminBundle:Contacto')->findAll();
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
          $value = $busqueda['value'];  
           
          $sql = "SELECT cp.id as id, cp.nombre as nombre,cp.telefono as telefono, cp.correoelectronico as contacto FROM contacto cp "
                    . "WHERE upper(cp.nombre)  LIKE '%".strtoupper($value)."%' AND cp.estado=1 "
                    . "ORDER BY cp.nombre ASC";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();
                 
       
        }
        else{
              $sql = "SELECT cp.id as id, cp.nombre as nombre,cp.telefono as telefono, cp.correoelectronico as contacto FROM contacto cp "
                    . "WHERE cp.estado=1 "
                    . "ORDER BY cp.nombre ASC";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();


//            $dql = "SELECT cp.id as id, cp.nombre as nombre,cp.telefono as telefono, contac.nombre as contacto, concat(concat('<input type=\"checkbox\" class=\"checkbox idCliente\" id=\"',cp.id), '\">' as link,"
//                    . " concat('<a class=\"btn btn-success CP\" id=\"',cp.id, '\">Ver mas</a>') as link2 FROM DGAdminBundle:Cliente cp  "
//                    . " JOIN cp.contactoId contac "
//                    . "WHERE  cp.estado=1"
//                    . " ORDER BY cp.nombre  ASC ";
//                    $territorio['data'] = $em->createQuery($dql)
//                    ->setFirstResult($start)
//                    ->setMaxResults($longitud)
//                    ->getResult();
        }
        
        return new Response(json_encode($territorio));
    }
    
    
    /**
     * @Route("/insertarcontacto/", name="insertarcontacto", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function InsertarContactoAction(Request $request) {
        
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

              
            $objeto = new Contacto();
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
     * @Route("/editarcontacto/", name="editarcontacto", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function EditarContactoAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             $id= $request->get('idContacto');
   
             $em = $this->getDoctrine()->getManager();
             
            $objeto = $em->getRepository('DGAdminBundle:Contacto')->findById($id);
            
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
     * @Route("/admin/eliminarcontacto", name="eliminarcontacto")
     */
    public function EliminarContactoAction()
    {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        $response = new JsonResponse();
        
            $idcliente = $this->get('request')->request->get('idcontacto');
     
            foreach($idcliente as $row){
                $em = $this->getDoctrine()->getManager();
                $cliente = $em->getRepository('DGAdminBundle:Contacto')->find($row);    
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
