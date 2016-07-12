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
use DG\AdminBundle\Entity\DetalleExpedienteMantenimiento;
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
     * @Route("/nuevamaquina", name="nuevamaquina",options={"expose"=true})
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
                   . " ma.placa = :placa AND  ma.placa !='' ";

            $resultadoPlaca = $em->createQuery($dqlPlaca)
                        ->setParameters(array('placa'=>$placa))
                        ->getResult();
            $rPlaca=$resultadoPlaca[0]['resP'];
            
             $dqlEquipo = "SELECT COUNT(ma.id) AS resE FROM DGAdminBundle:MaMaquina ma WHERE"
                   . " ma.nombre = :numeroEquipo AND  ma.nombre !='' ";

            $resultadoEquipo = $em->createQuery($dqlEquipo)
                        ->setParameters(array('numeroEquipo'=>$numeroEquipo))
                        ->getResult();
            
            
            $rEquipo=$resultadoEquipo[0]['resE'];
            
             $dqlSerie = "SELECT COUNT(ma.id) AS resS FROM DGAdminBundle:MaMaquina ma WHERE"
                   . " ma.numeroSerie = :numeroSerie AND  ma.numeroSerie !='' ";

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
            $data['nombre']=$idMaquina->getAlias();
            $data['marca']=$idMaquina->getMarca();
         $data['serie']=$idMaquina->getNumeroSerie();
            $data['modelo']=$idMaquina->getModelo();
            
            return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }
    
    
    //Seccion de datos de mantenimiento

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
           
          $sql = "SELECT da.id as id, da.codigo ,da.numero_original as numeroOriginal, da.numero_comercial as numeroComercial,  da.descripcion as descripcion, da.nombre as nombre FROM ma_datos_mantenimiento da " 
                    ."WHERE  da.ma_maquina_id=".$idMa
                    ." AND da.estado=1 AND (da.descripcion like '%".$value."%' or da.numero like '%".$value."%'   or da.codigo like '%".$value."%'  or da.nombre like '%".$value."%') ORDER BY da.codigo limit 5";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();
            $territorio['recordsFiltered']= count($territorio['data']);
                          
       
        }
        else{
            
            
              $sql = "SELECT da.id as id, da.codigo, da.numero_original as numeroOriginal, da.numero_comercial as numeroComercial, da.descripcion as descripcion, da.nombre as nombre FROM ma_datos_mantenimiento da "
                     . "WHERE da.ma_maquina_id=" . $idMa
                    . " AND da.estado=1 ORDER BY da.codigo ASC";
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
            $numerosOriginal = $request->get('numerosOriginal');
            $numerosComercial= $request->get('numerosComercial');
            
            $nombres = $request->get('nombres');
            $descripciones = $request->get('descripciones');
            $marcas = $request->get('marcas');
            
            $maquina = $this->getDoctrine()->getRepository('DGAdminBundle:MaMaquina')->findById($idMaquina);
            $n=count($nombres);
    
            $identificador =1;
          for ($i=0;$i<$n;$i++){
              
              $codigo = $this->generarCorrelativos($identificador);
              $objeto = new MaDatosMantenimiento();
              $objeto->setNombre($nombres[$i]);
              $objeto->setNumeroComercial($numerosComercial[$i]);
              $objeto->setNumeroOriginal($numerosOriginal[$i]);
              $objeto->setDescripcion($descripciones[$i]);
              $objeto->setMarca($marcas[$i]);
              $objeto->setMaMaquina($maquina[0]);
              $objeto->setCodigo($codigo);
              $objeto->setEstado(1);
              $em->persist($objeto);
              $em->flush();

            }
           
            $data['estado']=true;
            
            return new Response(json_encode($data)); 
            
            
         }

        
    } 
    
    
     public function generarCorrelativos($identificador){
    
       
        $em = $this->getDoctrine()->getManager();
        // 1 para correlativo de datos de  mantenimientos
        //2 Para correlativos de Expedientes de mantenimientos
        

         if ($identificador==1){
            $dqlNumerocorrelativo = "SELECT COUNT(u.id) as numero FROM DGAdminBundle:MaDatosMantenimiento u"
            . " WHERE u.codigo like '%NRM%' ";
            $resultCorrelativo = $em->createQuery($dqlNumerocorrelativo)->getArrayResult();
            $numero_base = $resultCorrelativo[0]['numero'];
            
            $primerLetras="NRM"; 
         }else if($identificador==2){
                $dqlNumerocorrelativo = "SELECT COUNT(u.id) as numero FROM DGAdminBundle:MaExpedienteMantenimiento u"
            . " WHERE u.codigo like '%NRE%' ";
            $resultCorrelativo = $em->createQuery($dqlNumerocorrelativo)->getArrayResult();
            $numero_base = $resultCorrelativo[0]['numero'];
            
             $primerLetras="NRE"; 
             
         }
        
        

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
     * @Route("/seleccionarDatosMantenimientoEdicion/", name="seleccionarDatosMantenimientoEdicion", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function SeleccionarDatosMantenimientoEdicionAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
            $em = $this->getDoctrine()->getManager();
            $idDatoMantenimiento = $request->get('idDatoMantenimiento');
            
            $detalleDatoMantenimiento = $this->getDoctrine()->getRepository('DGAdminBundle:MaDatosMantenimiento')->findByCodigo($idDatoMantenimiento);
            
            $nombre=$detalleDatoMantenimiento[0]->getNombre();
            $numeroOriginal =$detalleDatoMantenimiento[0]->getNumeroOriginal();
            $numeroComercial =$detalleDatoMantenimiento[0]->getNumeroComercial();
            $descripcion =$detalleDatoMantenimiento[0]->getDescripcion();
             $marca=$detalleDatoMantenimiento[0]->getMarca();

            
            $data['estado']=true;
            $data['nombre']=$nombre;
            $data['numeroOriginal']=$numeroOriginal;
            $data['numeroComercial']=$numeroComercial;
            $data['descripcion']=$descripcion;
            $data['marca']=$marca;
            
            
            
        
          
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
            $numerosOriginal = $request->get('numerosOriginal');
            $numerosComercial = $request->get('numerosComercial');
            
            $descripciones = $request->get('descripciones');
            $marcas = $request->get('marcas');
            
            
    
            $objeto = $this->getDoctrine()->getRepository('DGAdminBundle:MaDatosMantenimiento')->findByCodigo($idDatoMantenimiento);
            $objeto[0]->setNombre($nombres[0]);
            $objeto[0]->setNumeroOriginal($numerosOriginal[0]);
            $objeto[0]->setNumeroComercial($numerosComercial[0]);
            $objeto[0]->setDescripcion($descripciones[0]);
            $objeto[0]->setMarca($marcas[0]);
            
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

            $objeto = $this->getDoctrine()->getRepository('DGAdminBundle:MaDatosMantenimiento')->findByCodigo($idDatoMantenimiento);
            
            $em->merge($objeto[0]->setEstado(0));
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
           
          $sql = "SELECT cp.id as id, cp.alias as nombreMaquina, cp.nombre as numeroMaquina,cp.numero_serie as numeroSerie, cp.marca as marca FROM ma_maquina cp"
                    . " WHERE (upper(cp.alias)  LIKE '%" . strtoupper($value) . "%' OR  upper(cp.nombre)  LIKE '%" . strtoupper($value) . "%'  or cp.numero_serie like '%" . $value . "%'  "
                     . "OR upper(cp.marca)  LIKE '%" . strtoupper($value) . "%')  AND cp.estado=1  AND cp.ma_identificacion_alquiler= 0 "
                    . "ORDER BY cp.nombre ASC";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $territorio['data'] = $stmt->fetchAll();
            $territorio['recordsFiltered'] = count($territorio['data']);
        }
        else{
              $sql = "SELECT cp.id as id, cp.alias as nombreMaquina,cp.nombre as numeroMaquina,cp.numero_serie as numeroSerie, cp.marca as marca FROM ma_maquina cp"
                      . " WHERE cp.estado=1"
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
           
          $sql = "SELECT ma.codigo as id, ma.fecha as fecha, ma.serie as serie, ma.costo as costo, pro.nombre as proyecto, tm.nombre as tipomantenimiento FROM ma_expediente_mantenimiento ma "
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
            $sql = "SELECT ma.codigo as id, ma.fecha as fecha, ma.serie as serie, ma.costo as costo, pro.nombre as proyecto, tm.nombre as tipomantenimiento FROM ma_expediente_mantenimiento ma "
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
        $tipoMantenimiento = $_POST["tipoMantenimiento"];

        $fechaDE = $_POST["fechaDE"];
        $costoTotal =$_POST["totalCosto"];

        $numeroFactura = $_POST["numeroFactura"];
        $descripcionDatoExpediente = $_POST["descripcionDatoExpediente"];

        if (isset($_POST["proyecto"])) {
            $proyecto = $_POST["proyecto"];
        } else {
            $proyecto = NULL;
        }
        
        
        $idMaquinaria = $this->getDoctrine()->getRepository('DGAdminBundle:MaMaquina')->findById($idMaquina);
        $tipoMantenimientoObj = $this->getDoctrine()->getRepository('DGAdminBundle:MaTipoMantenimiento')->findById($tipoMantenimiento);
        
        $objetoM = new MaExpedienteMantenimiento();
        $objetoM->setMaMantenimiento($tipoMantenimientoObj[0]);
        $objetoM->setFecha(new \DateTime($fechaDE));

        $objetoM->setCosto($costoTotal);
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
         
          $codigo = $this->generarCorrelativos(2);
          $objetoM->setCodigo($codigo);
          $em->persist($objetoM);
          $em->flush();

        //Insercion de la imagen
          $nombreimagen=$_FILES['fotoFactura']['name'];    
          

          if ($nombreimagen!=""){
          $tipo = $_FILES['fotoFactura']['type']; 
          $extension= explode('/',$tipo);
        
          $fecha = date('Y-m-d His');
          $nombreArchivo =$fecha.".".$extension[1];
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
         $data['idExpediente']=$objetoM->getId();

         
         return new Response(json_encode($data)); 
            

    } 
    
    
    
    //Funcion que llena el registro de un detalle de expediente de mantenimiento
    
     /**
     * @Route("/insertarDetalleExpediente/", name="insertarDetalleExpediente", options={"expose"=true})
     * @Method("POST")
     */
    
    function llenarDetalleExpedienteMantenimiento(Request $request){
        
             $em = $this->getDoctrine()->getEntityManager();
             $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
             
             $em = $this->getDoctrine()->getManager();
             $idExpediente= $request->get('idExpediente');

  
             $costos = $request->get('costos');
             $nombres = $request->get('nombres');
             $proveedores = $request->get('proveedores');

             
             $dimension = count($costos);
             for ($i=0;$i<$dimension;$i++){
                    $objeto = new DetalleExpedienteMantenimiento();
                    $objeto->setCosto($costos[$i]);
                    $objeto->setNombre($nombres[$i]);
                    $objeto->setEstado(1);
                    if ($proveedores[$i]!=0){
                        $proveedor = $this->getDoctrine()->getRepository('DGAdminBundle:Proveedor')->findById($proveedores[$i]);
                        $objeto->setProveedor($proveedor[0]);

                    }else{
                        $objeto->setProveedor(null);
                    }
                 $objExpediente = $this->getDoctrine()->getRepository('DGAdminBundle:MaExpedienteMantenimiento')->findById($idExpediente);
                 $objeto->setIdExpedienteMantenimiento($objExpediente[0]);
 
               $em->persist($objeto);
               $em->flush();
                 
                 
                 
             }
             
             $data['estado']=true;
            
           
         }
          return new Response(json_encode($data)); 
        
    }



    
    //Funcion que llena el registro de un detalle de expediente de mantenimiento
    
     /**
     * @Route("/modificarDetalleExpediente/", name="modificarDetalleExpediente", options={"expose"=true})
     * @Method("POST")
     */
    
    function ModificarDetalleExpedienteMantenimiento(Request $request){
        
             $em = $this->getDoctrine()->getEntityManager();
             $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
             
             $em = $this->getDoctrine()->getManager();
             $idExpediente= $request->get('idExpediente');
             
             $costos = $request->get('costos');
             $nombres = $request->get('nombres');
             $proveedores = $request->get('proveedores');
             $idRegistros = $request->get('idRegistros');

             
             
             $costosNuevosE =$request->get('costosNuevosE');
             $nombresNuevosE =$request->get('nombresNuevosE');
             $proveedoresNuevosE =$request->get('proveedoresNuevosE');
             

             
             $dimensionE = count($costos);
             
             for ($i=0;$i<$dimensionE;$i++){
                    $objeto= $this->getDoctrine()->getRepository('DGAdminBundle:DetalleExpedienteMantenimiento')->findById($idRegistros[$i]);
                    
                    $objeto[0]->setCosto($costos[$i]);
                    $objeto[0]->setNombre($nombres[$i]);
                    $objeto[0]->setEstado(1);
                    if ($proveedores[$i]!=0){
                        $proveedor = $this->getDoctrine()->getRepository('DGAdminBundle:Proveedor')->findById($proveedores[$i]);
                        $objeto[0]->setProveedor($proveedor[0]);

                    }else{
                        $objeto[0]->setProveedor(null);
                    }
                 
               $em->merge($objeto[0]);
               $em->flush();
                 
                 
                 
             }
             
             
            $dimensionEN = count($costosNuevosE);
            
   
            if ($dimensionEN!=0){
                
           
            for ($i = 0; $i < $dimensionEN; $i++) {
                $objeto2 = new DetalleExpedienteMantenimiento();
                $objeto2->setCosto($costosNuevosE[$i]);
                $objeto2->setNombre($nombresNuevosE[$i]);
                $objeto2->setEstado(1);
                
                if ($proveedoresNuevosE[$i] != 0) {
                    $proveedor = $this->getDoctrine()->getRepository('DGAdminBundle:Proveedor')->findById($proveedoresNuevosE[$i]);
                    $objeto2->setProveedor($proveedor[0]);
                } else {
                    $objeto2->setProveedor(null);
                }
                $objExpediente = $this->getDoctrine()->getRepository('DGAdminBundle:MaExpedienteMantenimiento')->findById($idExpediente);
                $objeto2->setIdExpedienteMantenimiento($objExpediente[0]);

                $em->persist($objeto2);
                $em->flush();
            }
            
           }

            $data['estado']=true;
            
           
         }
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
            $codigo = $request->get('idRegistro');
            $detalleDatoExpedienteMantenimiento = $this->getDoctrine()->getRepository('DGAdminBundle:MaExpedienteMantenimiento')->findByCodigo($codigo);
            $idRegistro= $detalleDatoExpedienteMantenimiento[0]->getId();
            
            
            $imagen = $this->getDoctrine()->getRepository('DGAdminBundle:ImagenesDetalleMantenimiento')->findByMaExpedienteMantenimiento($idRegistro);
             
             $data['registro']=$idRegistro;
             $data['total']=$detalleDatoExpedienteMantenimiento[0]->getCosto();
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
             $detalle = $this->llamarDetalleEspedienteMantenimiento($idRegistro);
             $data['detalle']=  $detalle;
             

            return new Response(json_encode($data)); 
            
            
         }
        

    }
    
        function llamarDetalleEspedienteMantenimiento($idRegistro){
                    
            $em = $this->getDoctrine()->getManager();
            
            $sql = "SELECT  det.id as id, det.nombre as nombreDet, det.costo as costo, prov.nombre as provNombre, prov.id as idProv  FROM detalle_ma_expediente_mantenimiento det"
                    . " LEFT OUTER JOIN proveedor prov ON det.proveedor = prov.id "
                    . "WHERE det.id_expediente_mantenimiento=".$idRegistro;
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
           $data = $stmt->fetchAll();
           
           return $data;
           
        }
        
     /**
     * @Route("/eliminarRegistroDetalleEspediente/", name="eliminarRegistroDetalleEspediente", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function EliminarRegistroDetalleExpedienteAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
            $em = $this->getDoctrine()->getManager();
            $idRegistro = $request->get('idRegistro');
            
            $detalle = $this->getDoctrine()->getRepository('DGAdminBundle:DetalleExpedienteMantenimiento')->findById($idRegistro);
            
            $costoRegistroEliminar = $detalle[0]->getCosto();
            $idExpediente = $detalle[0]->getIdExpedienteMantenimiento();
            
            $expediente = $this->getDoctrine()->getRepository('DGAdminBundle:MaExpedienteMantenimiento')->findById($idExpediente);
            $costoExpedienteActual = $expediente[0]->getCosto();
            
            $costoExpedienteNuevo = $costoExpedienteActual-$costoRegistroEliminar;
            
            $expediente[0]->setCosto($costoExpedienteNuevo);
            
            $em->merge($expediente[0]);
            $em->flush();
            
            $em->remove($detalle[0]);
            $em->flush();

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

        $costo=$_POST["totalCostoE"];
        $numeroFactura=$_POST["numeroFacturaE"];
        $descripcionDatoExpediente=$_POST["descripcionDatoExpedienteE"];
        $proyecto=$_POST["proyectoE"];


     
      

        $idMaquinaria = $this->getDoctrine()->getRepository('DGAdminBundle:MaMaquina')->findById($idMaquina);
        $tipoMantenimientoObj = $this->getDoctrine()->getRepository('DGAdminBundle:MaTipoMantenimiento')->findById($tipoMantenimiento);
        
        $objetoM = $this->getDoctrine()->getRepository('DGAdminBundle:MaExpedienteMantenimiento')->findById($idRegistro);
        
        $objetoM[0]->setMaMantenimiento($tipoMantenimientoObj[0]);
        $objetoM[0]->setFecha(new \DateTime($fechaDE));
        $objetoM[0]->setNumeroFactura($numeroFactura);
        $objetoM[0]->setDescripcion($descripcionDatoExpediente);
        $objetoM[0]->setMaMaquina($idMaquinaria[0]);
        $objetoM[0]->setEstado(1);
        $objetoM[0]->setCosto($costo);
        
        
         if ($proyecto!='null'){
             $proyectoObj = $this->getDoctrine()->getRepository('DGAdminBundle:Proyecto')->findById($proyecto);
             $objetoM[0]->setProyecto($proyectoObj[0]);
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
        $data["idExpediente"]=$idRegistro;

         
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
    
      
       /**
     * @Route("/eliminarMaquina/", name="eliminarMaquina", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function EliminarMaquinaAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
            $em = $this->getDoctrine()->getManager();
            $idEliminar = $request->get('idEliminar');
            $objeto = $this->getDoctrine()->getRepository('DGAdminBundle:MaMaquina')->findByNombre($idEliminar);
            $objeto[0]->setEstado(0);
            $em->merge($objeto[0]);
            $em->flush();

            $data['estado']=true;


            return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }   
      
      
       /**
     * @Route("/copiarRegistrosDeMantenimiento/data", name="copiarRegistrosDeMantenimiento", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function CopiarRegistrosDatosMantenimientoAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
            $em = $this->getDoctrine()->getManager();
            $idMaquinaCopiarRegistros = $request->get('idMaquinaCopiarRegistros');
            $idMaquinaNueva = $request->get('idMaquinaNueva');
            
            
              $em = $this->getDoctrine()->getManager();
            
               $sql = "SELECT dat.nombre,dat.marca,dat.descripcion,dat.numero_comercial,dat.numero_original from ma_datos_mantenimiento dat
                        INNER JOIN ma_maquina ma ON
                        dat.ma_maquina_id=ma.id
                        WHERE ma.id=".$idMaquinaCopiarRegistros
                       . " AND dat.estado=1";
               
               $stmt = $em->getConnection()->prepare($sql);
               $stmt->execute();
               $data = $stmt->fetchAll();
               $dimension = count($data);
               
               $objMaquina = $this->getDoctrine()->getRepository('DGAdminBundle:MaMaquina')->findById($idMaquinaNueva);
                
               for ($i=0;$i<$dimension;$i++){
                   $codigo = $this->generarCorrelativos(1);
                   $objDatoMantenimiento = new MaDatosMantenimiento();
                   $objDatoMantenimiento->setNombre($data[$i]['nombre']);
                   $objDatoMantenimiento->setDescripcion($data[$i]['descripcion']);
                   $objDatoMantenimiento->setMarca($data[$i]['marca']);
                   $objDatoMantenimiento->setEstado(1);
                   $objDatoMantenimiento->setNumeroComercial($data[$i]['numero_comercial']);
                   $objDatoMantenimiento->setNumeroOriginal($data[$i]['numero_original']);
                   $objDatoMantenimiento->setMaMaquina($objMaquina[0]);
                   $objDatoMantenimiento->setCodigo($codigo);
                    $em->persist($objDatoMantenimiento);
                    $em->flush();
               }
                         
              

            $data['estado']=true;


            return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }    
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
    
    
    

    
}
