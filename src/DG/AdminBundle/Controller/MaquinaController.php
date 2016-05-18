<?php

namespace DG\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\AdminBundle\Entity\MaMaquina;
use DG\AdminBundle\Form\MaMaquinaType;
use Symfony\Component\HttpKernel\Exception;

/**
 * Maquina controller.
 *
 * @Route("admin/maquina")
 */
class MaquinaController extends Controller
{
    /**
     * Lists all MaMaquina entities.
     *
     * @Route("/", name="admin_maquina_index",options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $maquina = $em->getRepository('DGAdminBundle:MaMaquina')->findAll();

        return $this->render('maquinaria/index.html.twig', array(
            'maquina' => $maquina,
        ));
    }

    /**
     * Lists all MaMaquina entities.
     *
     * @Route("/nuevamaquina", name="nuevamaquina")
     * @Method("GET")
     */
    public function NuevaMaquinaAction()
    {
        
        return $this->render('maquinaria/nuevo.html.twig', array(
            
        ));
    }
    
    
    /**
    * Ajax utilizado para buscar informacion de abogados
    * 
    * @Route("/buscarTipoEquipo", name="buscarTipoEquipo",options={"expose"=true})
    */
    public function BuscarTipoEquipoAction(Request $request)
    {
        $busqueda = $request->query->get('q');
        $page = $request->query->get('page');
       
        $em = $this->getDoctrine()->getEntityManager();
        $dql = "SELECT abo.id abogadoid, abo.nombre  "
                        . "FROM DGAdminBundle:MaTipoEquipo abo "
                        . "WHERE upper(abo.nombre) LIKE upper(:busqueda)"
                        . " AND abo.estado=1 "
                        . "ORDER BY abo.nombre ASC ";
       
        $abogado['data'] = $em->createQuery($dql)
                ->setParameters(array('busqueda'=>"%".$busqueda."%"))
                ->setMaxResults( 10 )
                ->getResult();
       
        return new Response(json_encode($abogado));
    }

    
   /**
     * 
     *
     * @Route("/cliente/data", name="maquina_data")
     */
    public function DataClientePotencialAction(Request $request)
    {
        
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
        $entity = new MaMaquina();
        $start = $request->query->get('start');
        $draw = $request->query->get('draw');
        $longitud = $request->query->get('length');
        $busqueda = $request->query->get('search');
        
        $em = $this->getDoctrine()->getEntityManager();
        $territoriosTotal = $em->getRepository('DGAdminBundle:Cliente')->findAll();
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
        
                    $dql = "SELECT cp.id , cp.nombre as nombre,cp.telefono as telefono, cp.direccion as direccion, concat(concat('<input type=\"checkbox\" class=\"checkbox idCliente\" id=\"',cp.id), '\">' as link "
                            . ", concat('<a class=\"btn btn-success CP\" id=\"',cp.id, '\">Ver mas</a>') as link2 FROM DGAdminBundle:Cliente cp  "
                        . "WHERE upper(cp.nombre)  LIKE upper(:busqueda) AND cp.estado=1 "
                        . "ORDER BY cp.nombre DESC ";
                    
                    //Aqui estas trabjando
                   $territorio['data'] = $em->createQuery($dql)
                            ->setParameters(array('busqueda'=>"%".$busqueda['value']."%"))
                            ->getResult();
                    
                   $territorio['recordsFiltered']= count($territorio['data']);
                    
                    $dql = "SELECT cp.id , cp.nombre as nombre,cp.telefono as telefono, cp.direccion as direccion, concat(concat('<input type=\"checkbox\" class=\"checkbox idCliente\" id=\"',cp.id), '\">' as link"
                            . ", concat('<a class=\"btn btn-success CP \" id=\"',cp.id, '\">Ver mas</a>') as link2 FROM DGAdminBundle:Cliente cp  "
                        . "WHERE upper(cp.nombre)  LIKE upper(:busqueda)  AND cp.estado=1 "
                        . "ORDER BY cp.nombre DESC ";
                   
                   $territorio['data'] = $em->createQuery($dql)
                            ->setParameters(array('busqueda'=>"%".$busqueda['value']."%"))
                            ->setFirstResult($start)
                            ->setMaxResults($longitud)
                            ->getResult();
       
        }
        else{
            $dql = "SELECT cp.id , cp.nombre as nombre,cp.telefono as telefono, cp.direccion as direccion, concat(concat('<input type=\"checkbox\" class=\"checkbox idCliente\" id=\"',cp.id), '\">' as link,"
                    . " concat('<a class=\"btn btn-success CP\" id=\"',cp.id, '\">Ver mas</a>') as link2 FROM DGAdminBundle:Cliente cp  "
                    . " WHERE  cp.estado=1"
                    . " ORDER BY cp.nombre  DESC ";
                    $territorio['data'] = $em->createQuery($dql)
                    ->setFirstResult($start)
                    ->setMaxResults($longitud)
                    ->getResult();
        }
     
        
        return new Response(json_encode($territorio));
    }
    
   
    
 
    
    
    
    
    
    
}
