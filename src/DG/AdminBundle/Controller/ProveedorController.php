<?php

namespace DG\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\AdminBundle\Entity\Proveedor;
use DG\AdminBundle\Form\ProveedorType;
use Symfony\Component\HttpKernel\Exception;

/**
 * Cliente controller.
 *
 * @Route("admin/proveedor")
 */
class ProveedorController extends Controller
{
    /**
     * Lists all Proveedor entities.
     *
     * @Route("/", name="admin_proveedor_index",options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $proveedor = $em->getRepository('DGAdminBundle:Proveedor')->findAll();

        return $this->render('proveedor/index.html.twig', array(
            'proveedor' => $proveedor,
        ));
    }

    /**
     * Lists all Proveedor entities.
     *
     * @Route("/nuevoproveedor", name="nuevoproveedor")
     * @Method("GET")
     */
    public function NuevoProveedorAction()
    {
        
        return $this->render('proveedor/nuevo.html.twig', array(
            
        ));
    }
 
    /**
     * @Route("/admin/{id}", name="editarProveedor", options={"expose"=true})
     * @Method("GET")
     */
    public function EditarProveedoresAction($id)
    {
        
      
        
        $em = $this->getDoctrine()->getManager();
        $proveedor = $em->getRepository('DGAdminBundle:Proveedor')->findById($id);
     
     
        return $this->render('proveedor/editar.html.twig', array(
            'proveedor' => $proveedor,
        ));
    }
    

   
   /**
     * 
     *
     * @Route("/proveedor/data", name="proveedor_data")
     */
    public function DataProveedorAction(Request $request)
    {
        
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
        $entity = new Proveedor();
        
        $start = $request->query->get('start');
        $draw = $request->query->get('draw');
        $longitud = $request->query->get('length');
        $busqueda = $request->query->get('search');
        
        $em = $this->getDoctrine()->getEntityManager();
        $territoriosTotal = $em->getRepository('DGAdminBundle:Proveedor')->findAll();
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
           
          $sql = "SELECT cp.id as id, cp.nombre as nombre,cp.telefono as telefono, contac.nombre as contacto FROM proveedor cp"
                    . " LEFT OUTER JOIN contacto contac on cp.contacto_id=contac.id "
                    . "WHERE upper(cp.nombre)  LIKE '%".strtoupper($value)."%' AND cp.estado=1 "
                    . "ORDER BY cp.nombre ASC";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();
                 
       
        }
        else{
              $sql = "SELECT cp.id as id, cp.nombre as nombre,cp.telefono as telefono, contac.nombre as contacto FROM proveedor cp"
                    . " LEFT OUTER JOIN contacto contac on cp.contacto_id=contac.id "
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
     * @Route("/insertarproveedor/", name="insertarproveedor", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function InsertarProveedorAction(Request $request) {
        
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
            $contactoId = $request->get('contactoId');
             
            $objeto = new Proveedor();
              if ($contactoId !=""){
                  $idContacto = $this->getDoctrine()->getRepository('DGAdminBundle:Contacto')->findById($contactoId);
                  $objeto->setContactoId($idContacto[0]);
             }else{
                 $objeto->setContactoId(null);
             }
            
         
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
     * @Route("/editarproveedor/", name="editarproveedor", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function EditarProveedorAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             $id= $request->get('idProveedor');
           
             $em = $this->getDoctrine()->getManager();
             
            $objeto = $em->getRepository('DGAdminBundle:Proveedor')->findById($id);
            
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
            
              $contactoId = $request->get('contactoId');
   
              if ($contactoId !=""){
                  $idContacto = $this->getDoctrine()->getRepository('DGAdminBundle:Contacto')->findById($contactoId);
                  $objeto[0]->setContactoId($idContacto[0]);
             }else{
                 $objeto[0]->setContactoId(null);
             }

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
     * @Route("/admin/eliminarproveedor", name="eliminarproveedor")
     */
    public function EliminarProveedorAction()
    {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        $response = new JsonResponse();
        
            $idcliente = $this->get('request')->request->get('idproveedor');
     
            foreach($idcliente as $row){
                $em = $this->getDoctrine()->getManager();
                $cliente = $em->getRepository('DGAdminBundle:Proveedor')->find($row);    
                $cliente->setEstado(0);
                $em->persist($cliente);
                $em->flush();
                
            }
   
            $response->setData(array(
                            'flag' => 0,
                            
                    ));    
            return $response; 
       
        
        
        
    }   
    
    
     /**
    * Ajax utilizado para buscar informacion de abogados
    * 
    * @Route("/buscarProveedor", name="buscarProveedor",options={"expose"=true})
    */
    public function BuscarProveedorAction(Request $request)
    {
        $busqueda = $request->query->get('q');
        $page = $request->query->get('page');
       
        $em = $this->getDoctrine()->getEntityManager();
        $dql = "SELECT abo.id abogadoid, abo.nombre  "
                        . "FROM DGAdminBundle:Proveedor abo "
                        . "WHERE upper(abo.nombre) LIKE upper(:busqueda)"
                        . " AND abo.estado=1 "
                        . "ORDER BY abo.nombre ASC ";
       
        $abogado['data'] = $em->createQuery($dql)
                ->setParameters(array('busqueda'=>"%".$busqueda."%"))
                ->setMaxResults( 10 )
                ->getResult();
       
        return new Response(json_encode($abogado));
    }
       
    
    
    
    
    
    
}
