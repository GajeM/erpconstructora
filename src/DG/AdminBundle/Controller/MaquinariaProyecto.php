<?php

namespace DG\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\AdminBundle\Entity\Proyecto;
use DG\AdminBundle\Entity\MaMaquina;
use DG\AdminBundle\Entity\DetalleArrendamientoMaquina;
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
    
    public function BuscarMaquinaAction(Request $request)
    {
        $busqueda = $request->query->get('q');
        $idMaquinas = $request->query->get('x');

        if ($idMaquinas==null || $idMaquinas==0){
            $variable="";
            
        }else{

            $variable="";
            foreach ($idMaquinas as $row){
              
                $variable.=" AND ma.id != ".$row. " ";
            }
            
        }
        
        
        $page = $request->query->get('page');
       
        $em = $this->getDoctrine()->getEntityManager();

            $sqlAbono = "SELECT ma.id maquinaid, ma.alias, ma.nombre, "
                        . "CASE 
                             WHEN ma.ma_identificacion_alquiler='1' THEN 'ALQ'
                             WHEN ma.ma_identificacion_alquiler='0' THEN ''
                           END  as maIdentificacionAlquiler "
                        . " FROM ma_maquina ma "
                        . "WHERE (ma.alias LIKE '%".$busqueda."%' OR ma.nombre LIKE '%".$busqueda."%') "
                        . " AND ma.estado=1 ".$variable
                        . "ORDER BY ma.nombre ASC";

                $stmt = $em->getConnection()->prepare($sqlAbono);
                $stmt->execute();
                $maquina['data']= $stmt->fetchAll();
        
        
       
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
            
            $tiempoCobro = $request->get('tiempoCobro');
            $proveedorId= $request->get('proveedor');
            $fechaInicioA= $request->get('fechaInicioA');
            $fechaFinA= $request->get('fechaFinA');
            $costoA= $request->get('costoA');

            $numeroSerie = $request->get('numeroSerie');
            $numeroEquipo = $request->get('numeroEquipo');
            $anho = $request->get('anho');
            $alias = $request->get('alias');
            $modelo = $request->get('modelo');
            $tipoEquipo = $request->get('tipoEquipo');
            $color = $request->get('color');
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
             $objeto->setColor($color);
             $objeto->setMarca($marca);
             $objeto->setDecripcion($descripcion);
             $objeto->setEstado(1);
             $objeto->setMaIdentificacionAlquiler(1);
             $em->persist($objeto);
             $em->flush();
            
            
            
            $idMaquina = $this->getDoctrine()->getRepository('DGAdminBundle:MaMaquina')->find($objeto->getId());
            $proveedor = $this->getDoctrine()->getRepository('DGAdminBundle:Proveedor')->find($proveedorId);
            
            $objeto2 = new DetalleArrendamientoMaquina();
            $objeto2->setCosto($costoA);
            $objeto2->setFechaFinal(new \DateTime($fechaFinA));
            $objeto2->setFechaInicio(new \DateTime($fechaInicioA));
            $objeto2->setMaquina($idMaquina);
            $objeto2->setProveedor($proveedor);
            $objeto2->setTiempo($tiempoCobro);
            $em->persist($objeto2);
            $em->flush();
            
            $data['estado']=true;
            $data['idMaquina']=$idMaquina->getId();
            
            return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }
    
    
      /**
     * @Route("/insertarMaquinariaProyecto/data/", name="insertarMaquinariaProyecto", options={"expose"=true})
     * @Method("POST")
     */
       public function InsertarMaquinariaProyectoAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             
            $em = $this->getDoctrine()->getManager();
            
            $maquinas = $request->get('maquinas');
            var_dump($maquinas);
            die();

            
            
            
//      
//             $em->persist();
//             $em->flush();
//            
//            
//            
//            $id = $this->getDoctrine()->getRepository('DGAdminBundle:MaMaquina')->find($objeto->getId());
//           

            
            return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }
    
    
    
    
    
    
    
    
    
    
  }
  