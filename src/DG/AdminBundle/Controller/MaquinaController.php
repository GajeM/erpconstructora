<?php

namespace DG\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\AdminBundle\Entity\MaMaquina;
use DG\AdminBundle\Entity\MaDatosMantenimiento;
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
     * @Route("/insertarMaquina/", name="insertarMaquina", options={"expose"=true})
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
            $vin = $request->get('vin');
            $placa = $request->get('placa');
            $color = $request->get('color');
            $tamanho = $request->get('tamanho');
            $capacidad = $request->get('capacidad');
            $marca = $request->get('marca');
            $descripcion = $request->get('descripcion');

            $objeto = new MaMaquina();
            $objeto->setNumeroSerie($numeroSerie);
            $objeto->setNombre($numeroEquipo);
            $objeto->setAnho(new \DateTime($anho));
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

            $em->persist($objeto);
            $em->flush();

            $idMaquina = $this->getDoctrine()->getRepository('DGAdminBundle:MaMaquina')->find($objeto->getId());
            $data['estado']=true;
            $data['idMaquina']=$idMaquina->getId();
            
            return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }
    
    
    
     /**
     * @Route("/validarMaquina/", name="validarMaquina", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function ValidarMaquinaAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
            $em = $this->getDoctrine()->getManager();
           
          
            $numeroSerie = $request->get('numeroSerie');
            $numeroEquipo = $request->get('numeroEquipo');
            $placa = $request->get('placa');
            

            $dqlPlaca = "SELECT COUNT(ma.id) AS resP FROM DGAdminBundle:MaMaquina ma WHERE"
                   . " ma.placa = :placa ";

            $resultadoPlaca = $em->createQuery($dqlPlaca)
                        ->setParameters(array('placa'=>$placa))
                        ->getResult();
            $rPlaca=$resultadoPlaca[0]['resP'];
            
             $dqlEquipo = "SELECT COUNT(ma.id) AS resE FROM DGAdminBundle:MaMaquina ma WHERE"
                   . " ma.nombre = :numeroEquipo ";

            $resultadoEquipo = $em->createQuery($dqlEquipo)
                        ->setParameters(array('numeroEquipo'=>$numeroEquipo))
                        ->getResult();
            
            
            $rEquipo=$resultadoEquipo[0]['resE'];
            
             $dqlSerie = "SELECT COUNT(ma.id) AS resS FROM DGAdminBundle:MaMaquina ma WHERE"
                   . " ma.numeroSerie = :numeroSerie ";

            $resultadoSerie = $em->createQuery($dqlSerie)
                        ->setParameters(array('numeroSerie'=>$numeroSerie))
                        ->getResult();
            $rSerie=$resultadoSerie[0]['resS'];
            
            $suma= $rEquipo+$rPlaca+$rSerie;
            if ($suma==0){
                
                $data['estado']=true;
                
            }else if($rEquipo!=0){
                $data['estado']="equipo";
            }else if($rPlaca!=0){
                $data['estado']="placa";
            }else if($rSerie!=0){
                $data['estado']="serie";
            }
            
            
            
    
                
             return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }
    
    /**
     * @Route("/modificarMaquina/", name="modificarMaquina", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function ModificarMaquinaAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             
            $em = $this->getDoctrine()->getManager();
            
            $numeroSerie = $request->get('numeroSerie');
            $numeroEquipo = $request->get('numeroEquipo');
            $anho = $request->get('anho');
            $alias = $request->get('alias');
            $modelo = $request->get('modelo');
            $tipoEquipo = $request->get('tipoEquipo');
            $vin = $request->get('vin');
            $placa = $request->get('placa');
            $color = $request->get('color');
            $tamanho = $request->get('tamanho');
            $capacidad = $request->get('capacidad');
            $marca = $request->get('marca');
            $descripcion = $request->get('descripcion');
            $idMaquina = $request->get('idMaquina');

            $objeto= $em->getRepository('DGAdminBundle:MaMaquina')->findById($idMaquina);
          
            
            $objeto[0]->setNumeroSerie($numeroSerie);
            $objeto[0]->setNombre($numeroEquipo);
            $objeto[0]->setAnho(new \DateTime($anho));
            $objeto[0]->setAlias($alias);
            $objeto[0]->setModelo($modelo);
            
            
            
            if ($tipoEquipo !=""){
                  $idTipoEquipo = $this->getDoctrine()->getRepository('DGAdminBundle:MaTipoEquipo')->findById($tipoEquipo);
                  $objeto[0]->setTipoEquipo($idTipoEquipo[0]);
             }else{
                 $objeto[0]->setTipoEquipo(null);
             }
             
             $objeto[0]->setVin($vin);
             $objeto[0]->setPlaca($placa);
             $objeto[0]->setColor($color);
             $objeto[0]->setTamaño($tamanho);
             $objeto[0]->setCapacidad($capacidad);
             $objeto[0]->setMarca($marca);
             $objeto[0]->setDecripcion($descripcion);

            $em->merge($objeto[0]);
            $em->flush();

            $idMaquina = $this->getDoctrine()->getRepository('DGAdminBundle:MaMaquina')->find($objeto[0]->getId());
            $data['estado']=true;
            $data['idMaquina']=$idMaquina->getId();
            
            return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }
    
    
    /**
     * 
     * @Route("/datosmantenimientodata/{idMaquina}", name="datosmantenimientodata", options={"expose"=true})
     * @Method("GET")
     */
    public function DatosMantinimientoDataAction(Request $request,$idMaquina)
    {
        
         /** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * Easy set variables
         */

        /* Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        

        if ($idMaquina!=0){
            
            $idMa=$idMaquina;
            
        }else{
            $idMa=0;
        }    
       
     
        $entity = new MaDatosMantenimiento();
        
        $start = $request->query->get('start');
        $draw = $request->query->get('draw');
        $longitud = $request->query->get('length');
        $busqueda = $request->query->get('search');
        
        $em = $this->getDoctrine()->getEntityManager();
        $territoriosTotal = $em->getRepository('DGAdminBundle:MaDatosMantenimiento')->findAll();
        $territorio['draw']=$draw++;  
        $territorio['recordsTotal'] = count($territoriosTotal);
        $territorio['recordsFiltered']= count($territoriosTotal);
        
        $territorio['data']= array();
       
        $arrayFiltro = explode(' ',$busqueda['value']);
        
        
        //echo count($arrayFiltro);
        $busqueda['value'] = str_replace(' ', '%', $busqueda['value']);
        
        
        //SQL Nativo

        if($busqueda['value']!=''){
          $value = $busqueda['value'];  
           
          $sql = "SELECT da.id as id ,da.numero as numero, da.descripcion as descripcion, da.nombre as nombre FROM ma_datos_mantenimiento da " 
                    ."WHERE  da.ma_maquina_id=".$idMa
                    ." AND (da.descripcion like '%".$value."%' or da.numero like '%".$value."%') ORDER BY da.descripcion limit 1";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();
            $territorio['recordsFiltered']= count($territorio['data']);
                          
       
        }
        else{
            
            
              $sql = "SELECT da.id as id, da.numero as numero, da.descripcion as descripcion, da.nombre as nombre FROM ma_datos_mantenimiento da "
                     . "WHERE da.ma_maquina_id=" . $idMa
                    . " ORDER BY da.descripcion ASC";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();
            $territorio['recordsFiltered']= count($territorio['data']);


        }
     
        
        return new Response(json_encode($territorio));
    }
    
    
    
     /**
     * @Route("/insertarDatosMantenimiento/", name="insertarDatosMantenimiento", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function InsertarDatosMantenimientoAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
            $em = $this->getDoctrine()->getManager();
            
            $idMaquina = $request->get('idMaquina');
            $numeros = $request->get('numeros');
            $nombres = $request->get('nombres');
            $descripciones = $request->get('descripciones');
            $maquina = $this->getDoctrine()->getRepository('DGAdminBundle:MaMaquina')->findById($idMaquina);
            $n=count($nombres);
    
        
            for ($i=0;$i<$n;$i++){
                
              $objeto = new MaDatosMantenimiento();
              $objeto->setNombre($nombres[$i]);
              $objeto->setNumero($numeros[$i]);
              $objeto->setDescripcion($descripciones[$i]);
              $objeto->setMaMaquina($maquina[0]);
              $em->persist($objeto);
              $em->flush();
              
              
            }
           
            $data['estado']=true;
            
            return new Response(json_encode($data)); 
            
            
         }
        
        
        
    } 
    
    
    
    
     /**
     * @Route("/seleccionarDatosMantenimientoEdicion/", name="seleccionarDatosMantenimientoEdicion", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function SeleccionarDatosMantenimientoEdicionAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
            $em = $this->getDoctrine()->getManager();
            $idDatoMantenimiento = $request->get('idDatoMantenimiento');
            
            $detalleDatoMantenimiento = $this->getDoctrine()->getRepository('DGAdminBundle:MaDatosMantenimiento')->findById($idDatoMantenimiento);
            
            $nombre=$detalleDatoMantenimiento[0]->getNombre();
            $numero =$detalleDatoMantenimiento[0]->getNumero();
            $descripcion =$detalleDatoMantenimiento[0]->getDescripcion();
            
            $data['estado']=true;
            $data['nombre']=$nombre;
            $data['numero']=$numero;
            $data['descripcion']=$descripcion;
            
            
            
        
          
            return new Response(json_encode($data)); 
            
            
         }
        
        
        
    } 
    
      /**
     * @Route("/editarDatosMantenimientoEdicion/", name="editarDatosMantenimientoEdicion", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function EditarDatosMantenimientoEdicionAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
            $em = $this->getDoctrine()->getManager();
            $idDatoMantenimiento = $request->get('idDatoMantenimiento');
            $nombres = $request->get('nombres');
            $numeros = $request->get('numeros');
            $descripciones = $request->get('descripciones');
            
            
    
            $objeto = $this->getDoctrine()->getRepository('DGAdminBundle:MaDatosMantenimiento')->findById($idDatoMantenimiento);
            $objeto[0]->setNombre($nombres[0]);
            $objeto[0]->setNumero($numeros[0]);
            $objeto[0]->setDescripcion($descripciones[0]);
            
            $em->merge($objeto[0]);
            $em->flush();

            $data['estado']=true;


            return new Response(json_encode($data)); 
            
            
         }
        
        
        
    } 
    
     /**
     * @Route("/eliminarDatosMantenimientoEdicion/", name="eliminarDatosMantenimientoEdicion", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function EliminarDatosMantenimientoEdicionAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
            $em = $this->getDoctrine()->getManager();
            $idDatoMantenimiento = $request->get('idDatoMantenimiento');
            $objeto = $this->getDoctrine()->getRepository('DGAdminBundle:MaDatosMantenimiento')->findById($idDatoMantenimiento);
            
            $em->remove($objeto[0]);
            $em->flush();

            $data['estado']=true;


            return new Response(json_encode($data)); 
            
            
         }
        
        
        
    } 
    
    
    
    
    
    
    
    
    
    
    
   
    
}
