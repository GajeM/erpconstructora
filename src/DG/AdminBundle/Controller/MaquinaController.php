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
use DG\AdminBundle\Entity\MaExpedienteMantenimiento;
use DG\AdminBundle\Entity\ImagenesDetalleMantenimiento;
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
            
            
            $identificador = $request->get('n');
              $suma= $rEquipo+$rPlaca+$rSerie;
            if ($identificador==0){

          
            
            if ($suma==0){
                
                $data['estado'] = true;
                } else if ($rEquipo != 0) {
                    $data['estado'] = "equipo";
                } else if ($rPlaca != 0) {
                    $data['estado'] = "placa";
                } else if ($rSerie != 0) {
                    $data['estado'] = "serie";
                }
                
            }else if ($suma <=3) {

                    $data['estado'] = true;
                } else if ($rEquipo != 0) {
                    $data['estado'] = "equipo";
                } else if ($rPlaca != 0) {
                    $data['estado'] = "placa";
                } else if ($rSerie != 0) {
                    $data['estado'] = "serie";
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
            $objeto[0]->setAnho($anho);
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
             
               if ($descripcion!=""){
                  $objeto[0]->setDecripcion($descripcion);
            }else{
                
                 $objeto[0]->setDecripcion("");
            }
           

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
    
  /**
     * 
     *
     * @Route("/maquina/data", name="maquina_data")
     */
    public function DataMaquinalAction(Request $request)
    {
        
        /** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
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
        $territoriosTotal = $em->getRepository('DGAdminBundle:MaMaquina')->findAll();
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
           
          $sql = "SELECT cp.id as id, cp.nombre as numeroMaquina,cp.numero_serie as numeroSerie, cp.marca as marca FROM ma_maquina cp"
                    . " WHERE upper(cp.nombre)  LIKE '%" . strtoupper($value) . "%'  or cp.numero_serie like '%" . $value . "%' "
                    . "ORDER BY cp.nombre ASC";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();
            $territorio['recordsFiltered'] = count($territorio['data']);
        }
        else{
              $sql = "SELECT cp.id as id, cp.nombre as numeroMaquina,cp.numero_serie as numeroSerie, cp.marca as marca FROM ma_maquina cp"
                    . " ORDER BY cp.nombre ASC";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();
            $territorio['recordsFiltered'] = count($territorio['data']);
        }
     
        
        return new Response(json_encode($territorio));
    }   
    
     /**
     * 
     *
     * @Route("/datosexpedientesmantenimientodata/{idMaquina}", name="datosexpedientesmantenimientodata", options={"expose"=true})
     */
    public function DatosExpedientesMantenimientoAction(Request $request, $idMaquina)
    {
        
        /*         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
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
       
        
        $entity = new MaExpedienteMantenimiento();
        
        $start = $request->query->get('start');
        $draw = $request->query->get('draw');
        $longitud = $request->query->get('length');
        $busqueda = $request->query->get('search');
        
        $em = $this->getDoctrine()->getEntityManager();
        $territoriosTotal = $em->getRepository('DGAdminBundle:MaExpedienteMantenimiento')->findAll();
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
           
          $sql = "SELECT ma.id as id, ma.fecha as fecha, ma.serie as serie, ma.costo as costo, pro.nombre as proyecto, tm.nombre as tipomantenimiento FROM ma_expediente_mantenimiento ma "
                    . "INNER JOIN ma_tipo_mantenimiento tm on ma.ma_mantenimiento_id=tm.id"  
                    . " LEFT OUTER JOIN proyecto pro on ma.proyecto_id=pro.id "
                    ." WHERE ma.ma_maquina_id=".$idMa
                    ." AND (ma.fecha like '%".$value."%' or ma.serie like '%".$value."%') AND ma.estado=1 ORDER BY ma.fecha ";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();
              $territorio['recordsFiltered']= count($territorio['data']);
                 
       
        }
        else{
            $sql = "SELECT ma.id as id, ma.fecha as fecha, ma.serie as serie, ma.costo as costo, pro.nombre as proyecto, tm.nombre as tipomantenimiento FROM ma_expediente_mantenimiento ma "
                     . "INNER JOIN ma_tipo_mantenimiento tm on ma.ma_mantenimiento_id=tm.id"
                    . " LEFT OUTER JOIN proyecto pro on ma.proyecto_id=pro.id "
                    . "WHERE ma.ma_maquina_id=" . $idMa
                    . " AND ma.estado=1 ORDER BY ma.fecha ";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();
            $territorio['recordsFiltered'] = count($territorio['data']);
        }
     
        
        return new Response(json_encode($territorio));
    }
    
    /**
    * Ajax utilizado para buscar informacion de abogados
    * 
    * @Route("/buscarTipoMantenimiento", name="buscarTipoMantenimiento",options={"expose"=true})
    */
    public function BuscarTipoMantenimientoAction(Request $request)
    {
        $busqueda = $request->query->get('q');
        $page = $request->query->get('page');
       
        $em = $this->getDoctrine()->getEntityManager();
        $dql = "SELECT abo.id abogadoid, abo.nombre  "
                        . "FROM DGAdminBundle:MaTipoMantenimiento abo "
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
    * Ajax utilizado para buscar informacion de abogados
    * 
    * @Route("/buscarProyecto", name="buscarProyecto",options={"expose"=true})
    */
    public function BuscarProyectoAction(Request $request)
    {
        $busqueda = $request->query->get('q');
        $page = $request->query->get('page');
       
        $em = $this->getDoctrine()->getEntityManager();
        $dql = "SELECT abo.id abogadoid, abo.nombre  "
                        . "FROM DGAdminBundle:Proyecto abo "
                        . "WHERE upper(abo.nombre) LIKE upper(:busqueda)"
                        . " AND abo.estadoProyecto=1 "
                        . "ORDER BY abo.nombre ASC ";
       
        $abogado['data'] = $em->createQuery($dql)
                ->setParameters(array('busqueda'=>"%".$busqueda."%"))
                ->setMaxResults( 10 )
                ->getResult();
       
        return new Response(json_encode($abogado));
    }
         
    
    //Insercion de nuevo expediente datos de mantenimiento
    
      /**
     * @Route("/insertarExpedienteMantenimiento/", name="insertarExpedienteMantenimiento", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function InsertarExpedienteMantenimientoAction(Request $request) {
           $em = $this->getDoctrine()->getEntityManager();
           $pathContenedor = $this->container->getParameter('photo.expediente');

        $idMaquina = $_POST["idMaquinaNuevoExpedienteMantenimiento"]; 
        $tipoMantenimiento=$_POST["tipoMantenimiento"];
        
        $fechaDE=$_POST["fechaDE"];
        $serie =$_POST["serie"];
        $costo=$_POST["costo"];
        $numeroFactura=$_POST["numeroFactura"];
        $descripcionDatoExpediente=$_POST["descripcionDatoExpediente"];
        
        if(isset($_POST["proyecto"])){
            $proyecto=$_POST["proyecto"];
         
        }else{
            $proyecto = NULL;
        }
        
        if(isset($_POST["proveedor"])){
             $proveedor=$_POST["proveedor"];
             
        }else{
            $proveedor = NULL;
        }

        $idMaquinaria = $this->getDoctrine()->getRepository('DGAdminBundle:MaMaquina')->findById($idMaquina);
        $tipoMantenimientoObj = $this->getDoctrine()->getRepository('DGAdminBundle:MaTipoMantenimiento')->findById($tipoMantenimiento);
        
        $objetoM = new MaExpedienteMantenimiento();
        $objetoM->setMaMantenimiento($tipoMantenimientoObj[0]);
        $objetoM->setFecha(new \DateTime($fechaDE));
        $objetoM->setSerie($serie);
        $objetoM->setCosto($costo);
        $objetoM->setNumeroFactura($numeroFactura);
        $objetoM->setDescripcion($descripcionDatoExpediente);
        $objetoM->setMaMaquina($idMaquinaria[0]);
        $objetoM->setEstado(1);
        
        
         if ($proyecto!=NULL){
             $proyectoObj = $this->getDoctrine()->getRepository('DGAdminBundle:Proyecto')->findById($proyecto);
            
             $objetoM->setProyecto($proyectoObj[0]);
        }else{
             $objetoM->setProyecto($proyecto);

        }
         
            
        
          if ($proveedor!=NULL){
             $proveedorObj = $this->getDoctrine()->getRepository('DGAdminBundle:Proveedor')->findById($proveedor);
             $objetoM->setProveedor($proveedorObj[0]);

        }else{
             $objetoM->setProyecto($proveedor);

        }

          $em->persist($objetoM);
          $em->flush();

        //Insercion de la imagen
          $nombreimagen=$_FILES['fotoFactura']['name'];    
          

          if ($nombreimagen!=""){
          $tipo = $_FILES['fotoFactura']['type']; 
          $extension= explode('/',$tipo);
        
          $fecha = date('Y-m-d His');
          $nombreArchivo =$fecha.".".$extension[1];;
          $nombreArchivo =str_replace(" ","", $nombreArchivo);
          
       
          
          $resultados = move_uploaded_file($_FILES["fotoFactura"]["tmp_name"], $pathContenedor.$nombreArchivo);
       
          if ($resultados){
              
              chmod($pathContenedor.$nombreArchivo, 777);
               $idExpedienteMantenimiento = $this->getDoctrine()->getRepository('DGAdminBundle:MaExpedienteMantenimiento')->find($objetoM->getId());
               
               $objetoImagen = new ImagenesDetalleMantenimiento();
               $objetoImagen->setTipo(1);
               $objetoImagen->setSrc($nombreArchivo);
               $objetoImagen->setMaExpedienteMantenimiento($idExpedienteMantenimiento);
               $em->persist($objetoImagen);
               $em->flush();
               
          }
          
              
              
          }

         $data["estado"]=true;

         
         return new Response(json_encode($data)); 
            

    } 
    
    //Eliminar un registro de expediente de mantenimiento
    
    
    
       /**
     * @Route("/eliminarExpedienteMantenimiento/", name="eliminarExpedienteMantenimiento", options={"expose"=true})
     * @Method("POST")
     */

      public function EliminarExpedienteMantenimientoAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
            $em = $this->getDoctrine()->getManager();
            $idDetalleExpeMantenimiento = $request->get('idDetalleExpeMantenimiento');
            $objeto = $this->getDoctrine()->getRepository('DGAdminBundle:MaExpedienteMantenimiento')->findById($idDetalleExpeMantenimiento);
            $objeto[0]->setEstado(0);
            
            $em->merge($objeto[0]);
            $em->flush();

            $data['estado']=true;


            return new Response(json_encode($data)); 
            
            
         }
        
        
        
    } 
    
      
     /**
     * @Route("/seleccionarDatosExpedienteMantenimiento/", name="seleccionarDatosExpedienteMantenimiento", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function SeleccionarDatosExpedienteMantenimientoAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
            $em = $this->getDoctrine()->getManager();
            $idRegistro = $request->get('idRegistro');
            $imagen = $this->getDoctrine()->getRepository('DGAdminBundle:ImagenesDetalleMantenimiento')->findByMaExpedienteMantenimiento($idRegistro);
       
            
            $detalleDatoExpedienteMantenimiento = $this->getDoctrine()->getRepository('DGAdminBundle:MaExpedienteMantenimiento')->findById($idRegistro);
            $data['registro']=$idRegistro;
             $data['tipoMantenimientoId']=$detalleDatoExpedienteMantenimiento[0]->getMaMantenimiento()->getId();
             $data['tipoMantenimientoNombre']=$detalleDatoExpedienteMantenimiento[0]->getMaMantenimiento()->getNombre();
             $data['idMaquina']=$detalleDatoExpedienteMantenimiento[0]->getMaMaquina()->getId();
             
             
             
             
             $data['fecha']=(date_format($detalleDatoExpedienteMantenimiento[0]->getFecha(),'Y-m-d'));
             
             $data['serie']=$detalleDatoExpedienteMantenimiento[0]->getSerie();
             $data['costo']=$detalleDatoExpedienteMantenimiento[0]->getCosto();
             $data['numeroFactura']=$detalleDatoExpedienteMantenimiento[0]->getNumeroFactura();
             
             if ($detalleDatoExpedienteMantenimiento[0]->getProyecto() != NULL) {

                $data['proyectoId'] = $detalleDatoExpedienteMantenimiento[0]->getProyecto()->getId();
                $data['proyectoNombre'] = $detalleDatoExpedienteMantenimiento[0]->getProyecto()->getNombre();
            } else {

                $data['proyectoId'] =NULL;
                $data['proyectoNombre'] = 'Seleccione un proyecto';
            }




            if ($detalleDatoExpedienteMantenimiento[0]->getProveedor() != NULL) {
                
                $data['proveedorId'] = $detalleDatoExpedienteMantenimiento[0]->getProveedor()->getId();
                $data['proveedorNombre'] = $detalleDatoExpedienteMantenimiento[0]->getProveedor()->getNombre();
                
            }else{
            $data['proveedorId'] = NULL;
                $data['proveedorNombre'] = 'Seleccione un proveedor';

            }


            if ((count($imagen))!=0){
                 $data['imagen']=$imagen[0]->getSrc();
                 $data['imagenIdRegistro']=$imagen[0]->getId();
              }else{
                  $data['imagen']=null;
                  $data['imagenIdRegistro']=null;
              }

             $data['descripcion']=$detalleDatoExpedienteMantenimiento[0]->getDescripcion();
             $data['estado']=true;

            return new Response(json_encode($data)); 
            
            
         }
        

    }
    
    
    
       /**
     * @Route("/modificarExpedienteMantenimiento/", name="modificarExpedienteMantenimiento", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function ModificarExpedienteMantenimientoAction(Request $request) {
          
         $em = $this->getDoctrine()->getEntityManager();
         $pathContenedor = $this->container->getParameter('photo.expediente');
         $idRegistro=$_POST['idRegistro'];
         $idMaquina = $_POST["idMaquinaNuevoExpedienteMantenimientoE"]; 
         $tipoMantenimiento=$_POST["tipoMantenimientoE"];
        
        $fechaDE=$_POST["fechaDEE"];
        $serie =$_POST["serieE"];
        $costo=$_POST["costoE"];
        $numeroFactura=$_POST["numeroFacturaE"];
        $descripcionDatoExpediente=$_POST["descripcionDatoExpedienteE"];
        $proyecto=$_POST["proyectoE"];
        $proveedor=$_POST["proveedorE"];

     
      

        $idMaquinaria = $this->getDoctrine()->getRepository('DGAdminBundle:MaMaquina')->findById($idMaquina);
        $tipoMantenimientoObj = $this->getDoctrine()->getRepository('DGAdminBundle:MaTipoMantenimiento')->findById($tipoMantenimiento);
        
        $objetoM = $this->getDoctrine()->getRepository('DGAdminBundle:MaExpedienteMantenimiento')->findById($idRegistro);
        $objetoM[0]->setMaMantenimiento($tipoMantenimientoObj[0]);
        $objetoM[0]->setFecha(new \DateTime($fechaDE));
        $objetoM[0]->setSerie($serie);
        $objetoM[0]->setCosto($costo);
        $objetoM[0]->setNumeroFactura($numeroFactura);
        $objetoM[0]->setDescripcion($descripcionDatoExpediente);
        $objetoM[0]->setMaMaquina($idMaquinaria[0]);
        $objetoM[0]->setEstado(1);
        
        
         if ($proyecto!='null'){
             $proyectoObj = $this->getDoctrine()->getRepository('DGAdminBundle:Proyecto')->findById($proyecto);
             $objetoM[0]->setProyecto($proyectoObj[0]);
        }else{
             $objetoM[0]->setProyecto(NULL);
        }
         
            
        
          if ($proveedor!='null'){
             $proveedorObj = $this->getDoctrine()->getRepository('DGAdminBundle:Proveedor')->findById($proveedor);
             $objetoM[0]->setProveedor($proveedorObj[0]);

        }else{
             $objetoM[0]->setProyecto(NULL);

        }

          $em->merge($objetoM[0]);
          $em->flush();

        //Insercion de la imagen
          $nombreimagen=$_FILES['fotoFacturaE']['name'];    
          $idRegistroImagen=$_POST['idRegistroImagen'];

          
       if ($nombreimagen!=""){
                        $tipo = $_FILES['fotoFacturaE']['type']; 
                        $extension= explode('/',$tipo);

                        $fecha = date('Y-m-d His');
                        $nombreArchivo =$fecha.".".$extension[1];;
                        $nombreArchivo =str_replace(" ","", $nombreArchivo);

            if ($idRegistroImagen!=NULL){
                        $imagen = $this->getDoctrine()->getRepository('DGAdminBundle:ImagenesDetalleMantenimiento')->findById($idRegistroImagen);
                        $rutaImagenvieja=$imagen[0]->getSrc();

                        $resultadoEliminacion =unlink($pathContenedor.$rutaImagenvieja);
                        
                 if ($resultadoEliminacion){

                             $resultados = move_uploaded_file($_FILES["fotoFacturaE"]["tmp_name"], $pathContenedor.$nombreArchivo);

                        if ($resultados){

                                  chmod($pathContenedor.$nombreArchivo, 777);


                                   $imagen[0]->setSrc($nombreArchivo);

                                   $em->merge($imagen[0]);
                                   $em->flush();

                          }
              
                 }
            }else{
                
                
                     $resultadosNuevoIngresoEdicion = move_uploaded_file($_FILES["fotoFactura"]["tmp_name"], $pathContenedor.$nombreArchivo);
       
                    if ($resultadosNuevoIngresoEdicion){

                        chmod($pathContenedor.$nombreArchivo, 777);
                       

                         $objetoImagen = new ImagenesDetalleMantenimiento();
                         $objetoImagen->setTipo(1);
                         $objetoImagen->setSrc($nombreArchivo);
                         $objetoImagen->setMaExpedienteMantenimiento($objetoM[0]);
                         $em->persist($objetoImagen);
                         $em->flush();

                    }
                
            }
            
        }

        $data["estado"]=true;

         
         return new Response(json_encode($data)); 
            

    } 
    
    
    
    
     //Insercion de la imagen
    
    
       /**
     * @Route("/insertarImagenesMaquinaria/{idMaquina}", name="insertarImagenesMaquinaria", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function InsertarImagenesMaquinariaAction(Request $request,$idMaquina) {
          $em = $this->getDoctrine()->getEntityManager();
          $nombreimagen=$_FILES['file']['name'];
          $pathContenedor = $this->container->getParameter('photo.maquinaria');
     
          if ($nombreimagen!=""){
          $tipo = $_FILES['file']['type']; 
          $extension= explode('/',$tipo);
        
          $fecha = date('Y-m-d His');
          $nombreArchivo =$fecha.".".$extension[1];;
          $nombreArchivo =str_replace(" ","", $nombreArchivo);
          
       
          
          $resultados = move_uploaded_file($_FILES["file"]["tmp_name"], $pathContenedor.$nombreArchivo);
       
          if ($resultados){
              
               chmod($pathContenedor.$nombreArchivo, 777);

               
               $objMaquina = $this->getDoctrine()->getRepository('DGAdminBundle:MaMaquina')->findById($idMaquina);
               
               $objetoImagen = new ImagenesDetalleMantenimiento();
               $objetoImagen->setTipo(2);
               $objetoImagen->setSrc($nombreArchivo);
               $objetoImagen->setMaExpedienteMantenimiento(null);
               $objetoImagen->setMaMaquina($objMaquina[0]);
               $em->persist($objetoImagen);
               $em->flush();
               
               
               $nombreImagen=$objetoImagen->getSrc();
               $data['nombreImagen']=$nombreImagen;
               $data['estado']=true;
               
                 }

          }
            return new Response(json_encode($data)); 
    
      }
      
      
      
     //Aqui inicia la parte de la edcion de los datos de una maquinaria
      
      
      
     /**
     * Lists all MaMaquina entities.
     *
     * @Route("/editarMaquina/{id}", name="editarmaquina", options={"expose"=true})
     * @Method("GET")
     */
    public function EditarMaquinaAction($id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $datosGenerales = $em->getRepository('DGAdminBundle:MaMaquina')->findByNombre($id);
        
        $idMaquina = $datosGenerales[0]->getId();
        
  
        
          $dql = "SELECT img.src "
                    . "FROM DGAdminBundle:ImagenesDetalleMantenimiento img"
                    . " WHERE  img.maMaquina= :id AND img.tipo=2";

        $imagenes= $em->createQuery($dql) ->setParameters(array('id'=>$idMaquina))->getResult();
               
               
 
        
       
        return $this->render('maquinaria/edicion.html.twig', array(
            
            'datosGenerales'=>$datosGenerales,
            'imagenes'=>$imagenes
                
            
        ));
    }
    
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
    
    
    

    
}
