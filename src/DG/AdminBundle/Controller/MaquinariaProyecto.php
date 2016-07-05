<?php

namespace DG\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\AdminBundle\Entity\Proyecto;
use DG\AdminBundle\Entity\ImagenesDetalleMantenimiento;
use DG\AdminBundle\Entity\DetalleProMaqPer;
use Symfony\Component\HttpKernel\Exception;

/**
 * Maquina controller.
 *
 * @Route("admin/maquinariaProyecto")
 */
class MaquinariaProyecto extends Controller
{
 
    
   
    /**
    * Ajax utilizado para buscar informacion de abogados
    * 
    * @Route("/buscarMaquina/data", name="buscarMaquina",options={"expose"=true})
    */
    public function BuscarTipoEquipoAction(Request $request)
    {
        $busqueda = $request->query->get('q');
        $idMaquinas = $request->query->get('x');

        if ($idMaquinas==null){
            $variable="";
            
        }else{

            $variable="";
            foreach ($idMaquinas as $row){
              
                $variable.=" AND ma.id != ".$row. " ";
            }
            
        }
        
        
        $page = $request->query->get('page');
       
        $em = $this->getDoctrine()->getEntityManager();
        $dql = "SELECT ma.id maquinaid, ma.alias, ma.nombre "
                        . "FROM DGAdminBundle:MaMaquina ma "
                        . "WHERE (upper(ma.alias) LIKE upper(:busqueda) OR upper(ma.nombre) LIKE upper(:busqueda))  "
                        . " AND ma.estado=1 ".$variable
                        . "ORDER BY ma.nombre ASC ";
       
        $maquina['data'] = $em->createQuery($dql)
                ->setParameters(array('busqueda'=>"%".$busqueda."%"))
                ->setMaxResults( 10 )
                ->getResult();
       
        return new Response(json_encode($maquina));
    }
    
       /**
     * @Route("/insertarMaquinaAlquilada/", name="insertarMaquinaAlquilada", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function InsertarMaquinaAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             
            $em = $this->getDoctrine()->getManager();
            
            $numeroSerie = $request->get('numeroSerie');
            $numeroEquipo = $request->get('numeroEquipo');
            $anho = $request->get('anho');
            $alias = $request->get('alias');
            $modelo = $request->get('modelo');
            $tipoEquipo = $request->get('tipoEquipo');
            $color = $request->get('color');
            $tamanho = $request->get('tamanho');
            $marca = $request->get('marca');
            $descripcion = $request->get('descripcion');

            $objeto = new MaMaquina();
            $objeto->setNumeroSerie($numeroSerie);
            $objeto->setNombre($numeroEquipo);
            $objeto->setAnho($anho);
            $objeto->setAlias($alias);
            $objeto->setModelo($modelo);
            
            
            if ($tipoEquipo !=""){
                  $idTipoEquipo = $this->getDoctrine()->getRepository('DGAdminBundle:MaTipoEquipo')->findById($tipoEquipo);
                  $objeto->setTipoEquipo($idTipoEquipo[0]);
             }else{
                 $objeto->setTipoEquipo(null);
             }
             
             $objeto->setVin($vin);
             $objeto->setPlaca($placa);
             $objeto->setColor($color);
             $objeto->setTamaño($tamanho);
             $objeto->setCapacidad($capacidad);
             $objeto->setMarca($marca);
             $objeto->setDecripcion($descripcion);
             $objeto->setEstado(1);
             
             $objeto->setMaIdentificacionAlquiler(0);
            $em->persist($objeto);
            $em->flush();

            $idMaquina = $this->getDoctrine()->getRepository('DGAdminBundle:MaMaquina')->find($objeto->getId());
            $data['estado']=true;
            $data['idMaquina']=$idMaquina->getId();
            
            return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }
    
    
    
    
    
    
    
  }
  