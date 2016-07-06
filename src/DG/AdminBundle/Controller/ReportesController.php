<?php

namespace DG\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ERP\AdminBundle\Form\ClienteType;
use Symfony\Component\HttpKernel\Exception;
use Doctrine\ORM\Query\ResultSetMapping;
include_once '../src/DG/AdminBundle/Resources/dompdf/dompdf_config.inc.php'; 
/**
 * Cliente controller.
 *
 * @Route("admin/reportes")
 */
class ReportesController extends Controller
{
   
    
    //Reportes de ingresos dentro de caja chica
    /**
     *
     *
     * @Route("/verPDFIngresosCajaChica/{fechaInicio}/{fechaFin}", name="verPDFIngresosCajaChica", options={"expose"=true})
       * @Method({"GET", "POST"})
     */
    public function VerPDFIngresosCajaChica($fechaInicio ,$fechaFin) {
        $em = $this->getDoctrine()->getManager();
      

         $sqlIngreso = "SELECT cch.codigo, cch.persona_que_recibe as recibe, cch.nombre as entrega, cch.cantidad_por as monto
                                    FROM caja_chica cch where cch.estado =1 and cch.tipo_ingreso=1 ";  
           
         
         
        if ($fechaInicio !=0 && $fechaFin!=0){
            
             $sqlIngreso.="and cch.fecha >= '$fechaInicio' and cch.fecha <= '$fechaFin' ";
       
            
        }
       
        $sqlIngreso.="  order by cch.fecha desc ";
  
            $stmt = $em->getConnection()->prepare($sqlIngreso);
            $stmt->execute();
            $datos= $stmt->fetchAll();


        ob_start();
        $html = $this->renderView('cajachica/cajachicaReportes/reporteIngresos.html.php', array(
            'datos'=>$datos,
            'fechaInicio'=>$fechaInicio,
            'fechaFin'=>$fechaFin
           
        ));
        $pdf = new \DOMPDF();
        $pdf->set_paper('A4', 'portrait');
        $pdf->load_html($html);
        $pdf->render();
        $pdf->stream('ReporteComision.pdf', array('Attachment' => 0));
        
    } 
    
    
    
   
    
    
    
    
    
    
}
