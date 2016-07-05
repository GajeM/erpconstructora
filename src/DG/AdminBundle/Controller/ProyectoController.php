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
     * @Route("/{parametro}", name="admin_proyecto_index",options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction($parametro)
    {


        return $this->render('proyectos/index.html.twig', array(
           'parametro'=>$parametro
        ));
    }
    
    
    /**
     * Lists all Proyecto entities.
     *
     * @Route("/captura/mapa", name="admin_captura",options={"expose"=true})
     * @Method("GET")
     */
    public function indexCapturaAction()
    {


        return $this->render('proyectos/screenshot.html.twig', array(
          
        ));
    }
    
     /**
     * 
     *
     * @Route("/proyectos/{tipoContrato}", name="proyecto_data",options={"expose"=true})
     */
    public function DataProyectoAction(Request $request, $tipoContrato)
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
        

         $ordenamientoVariable = $request->query->get('order');
        

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
                    . "WHERE upper(pro.codigo)  LIKE '%".strtoupper($value)."%' AND pro.estado =1 AND pro.tipo_contrato=".$tipoContrato
                    . " ORDER BY pro.".$x." ".$tipoOrdenamiento;

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
                    . " LEFT OUTER JOIN contacto  cont ON pro.contacto_id = cont.id WHERE pro.estado =1  AND pro.tipo_contrato=".$tipoContrato
                   . " ORDER BY pro.".$x." ".$tipoOrdenamiento;
               
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
     * @Route("/nuevoProyecto/{parametro}", name="nuevoProyecto",options={"expose"=true})
     * @Method("GET")
     */
    public function NuevoProyectoAction($parametro)
    {

        $em = $this->getDoctrine()->getManager();
        $tipoProyecto = $em->getRepository('DGAdminBundle:TipoProyecto')->findAll();
         $estadoProyecto = $em->getRepository('DGAdminBundle:EstadoProyecto')->findAll();
        return $this->render('proyectos/nuevo.html.twig', array(
            'tipoProyecto'=>$tipoProyecto,
            'estadoProyecto'=>$estadoProyecto,
            'parametro'=>$parametro
           
        ));
    }
    
    
    
    
    
    /**
    * Ajax utilizado para buscar informacion de contactos
    * 
    * @Route("/buscarCliente/data", name="buscarCliente",options={"expose"=true})
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
    * @Route("/buscarEncargadoProyecto/data", name="buscarEncargadoProyecto",options={"expose"=true})
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
            $tipoContrato = $request->get('tipoContrato');
            $longitud = $request->get('longitud');
            $latitud = $request->get('latitud');
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
            $objeto->setLongitude($longitud);
            $objeto->setLatitude($latitud);
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
            $objeto->setEstado(1);
            $objeto->setTipoContrato($tipoContrato);
            $em->persist($objeto);
            $em->flush();
            
            $dataImagen = $request->get('dataImagen');
            
             if ($dataImagen!=""){
            
            $path = $this->container->getParameter('photo.direccionesproyectos');
            $horaFecha = date('Y-m-d His');
            
            $nombre = $horaFecha;
            $nombre=str_replace(" ", "", $nombre);
            
            define('UPLOAD_DIR', $path);
            $img = $dataImagen;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            
            $nombre.= '.jpg';
            $data = base64_decode($img);
            $file = UPLOAD_DIR .$nombre;
            $success = file_put_contents($file, $data);
            
            
                if ($success){
                    
                    $objetoProyecto = $this->getDoctrine()->getRepository('DGAdminBundle:Proyecto')->findById($objeto->getId());
                    $objetoImagen = new ImagenesDetalleMantenimiento();
                    $objetoImagen->setSrc($nombre);
                    $objetoImagen->setTipo(3);
                    $objetoImagen->setProyecto($objetoProyecto[0]);
                    $em->persist($objetoImagen);
                    $em->flush();

                 }
            
             }
       
            
            $dato['estado'] = true;
            $dato['idProyecto']=$objeto->getId();
            return new Response(json_encode($dato)); 
            
            
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
            $parametro = $request->get('i');
            $nombreProyecto = $request->get('nombreProyecto');
            
              $dql = "SELECT COUNT(u.id) as numero FROM DGAdminBundle:Proyecto u"
              . " WHERE u.nombre = '".$nombreProyecto."'";
            
            $valor = $em->createQuery($dql)->getArrayResult();
            $numero = $valor[0]['numero'];

            
            if ($parametro==0){
                
                if ($numero==0){
                     $data['estado'] = true;

                 }else{
                     $data['estado']=false;
                 }
   
            }else if($parametro==1){
                
                if ($numero<=1){
                     $data['estado'] = true;

                 }else{
                     $data['estado']=false;
                 }
                
                
            }
            
            return new Response(json_encode($data)); 
            
            
         }
        
        
        
    }
    //Edicion de los datos Generales del proyecto
    
      /**
     * @Route("/modificarDatosGeneralesProyecto/", name="modificarDatosGeneralesProyecto", options={"expose"=true})
     * @Method("POST")
     */
    
    
      public function ModificarDatosGeneralesProyectoAction(Request $request) {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();

         if($isAjax){
            
             
            $em = $this->getDoctrine()->getManager();
            
            $idProyecto= $request->get('idProyecto');
            
            $tipoContrato = $request->get('tipoContrato');
            $longitud = $request->get('longitud');
            $latitud = $request->get('latitud');
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
            
            $objeto =  $this->getDoctrine()->getRepository('DGAdminBundle:Proyecto')->findById($idProyecto);
            $objeto[0]->setLongitude($longitud);
            $objeto[0]->setLatitude($latitud);
            $objeto[0]->setNombre($nombreProyecto);
            $objeto[0]->setCodigo($codigo);
            $objeto[0]->setFechaInicio(new \DateTime($fechaInicios));
            $objeto[0]->setFechaFinal(new \DateTime($fechaFinal));
            $objeto[0]->setContacto($objContacto[0]);
            $objeto[0]->setCliente($objCliente[0]);
            $objeto[0]->setDireccion($direccionProyecto);
            $objeto[0]->setEncargadoProyecto($objEncargadoProyecto[0]);
            $objeto[0]->setTipoProyecto($objTipoProyecto[0]);
            $objeto[0]->setObservaciones($observacionesProyecto);
            $objeto[0]->setEstadoProyecto($objEstadoProyecto[0]);
            $objeto[0]->setEstado(1);
            $objeto[0]->setTipoContrato($tipoContrato);
            $em->persist($objeto[0]);
            $em->flush();
            
            $dataImagen = $request->get('dataImagen');
            
             if ($dataImagen!=""){
            
            $path = $this->container->getParameter('photo.direccionesproyectos');
            $horaFecha = date('Y-m-d His');
            
            $nombre = $horaFecha;
            $nombre=str_replace(" ", "", $nombre);
            
            define('UPLOAD_DIR', $path);
            $img = $dataImagen;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            
            $nombre.= '.jpg';
            $data = base64_decode($img);
            $file = UPLOAD_DIR .$nombre;
            $success = file_put_contents($file, $data);
            
            
                if ($success){
                      
                    $dql = "SELECT count(img.id) as existencia, img.src as src, img.id as id  FROM DGAdminBundle:ImagenesDetalleMantenimiento img"
                                 . " WHERE img.proyecto =".$idProyecto.""
                                 . " AND img.tipo=3";
            
                        $valor = $em->createQuery($dql)->getArrayResult();
                             
                        $ruta = $valor[0]['src'];
                        $idRegistroImagen = $valor[0]['id'];
                        $exitencia = $valor[0]['existencia'];
                        
                        if ($exitencia==0){
                            $objetoProyecto = $this->getDoctrine()->getRepository('DGAdminBundle:Proyecto')->findById($idProyecto);
                            $objetoImagen = new ImagenesDetalleMantenimiento();
                            $objetoImagen->setSrc($nombre);
                            $objetoImagen->setTipo(3);
                            $objetoImagen->setProyecto($objetoProyecto[0]);
                            $em->persist($objetoImagen);
                            $em->flush();

                        }else{
                            
                            $eliMapaExistente =unlink($path.$ruta);
                            if ($eliMapaExistente){
                                
                                $objetoProyecto = $this->getDoctrine()->getRepository('DGAdminBundle:Proyecto')->findById($idProyecto);
                                $objetoImagen = $this->getDoctrine()->getRepository('DGAdminBundle:ImagenesDetalleMantenimiento')->findById($idRegistroImagen);
                                $objetoImagen[0]->setSrc($nombre);
                                $objetoImagen[0]->setTipo(3);
                                $objetoImagen[0]->setProyecto($objetoProyecto[0]);
                                $em->persist($objetoImagen[0]);
                                $em->flush();
                                
                            }
                            
                          

                        }


                 }
            
             }
       
            
            $dato['estado'] = true;
            $dato['idProyecto']=$objeto[0]->getId();
            return new Response(json_encode($dato)); 
            
            
         }
        
        
        
    }
    

    
    
  }
  