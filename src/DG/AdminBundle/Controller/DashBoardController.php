<?php //

namespace DG\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\AdminBundle\Entity\ClientePotencial;
use DG\AdminBundle\Form\ClientePotencialType;
use Symfony\Component\HttpKernel\Exception;


/**
 * ClientePotencial controller.
 *
 * @Route("admin/dashboard")
 */
class DashBoardController extends Controller
{
    /**
     * Lists all ClientePotencial entities.
     *
     * @Route("/", name="dashboard_index",options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        
        return $this->render('dashboard/index.html.twig', array(
            
        ));
    }
    
     /**
     * Lists all ClientePotencial entities.
     *
     * @Route("/crm", name="dashboard_indexCRM",options={"expose"=true})
     * @Method("GET")
     */
    public function CRMAction()
    {
        
        return $this->render('dashboard/dashboardcrm.html.twig', array(
            
        ));
    }
    
    
    
    /**
     * Lists all ClientePotencial entities.
     *
     * @Route("/cajaChica", name="caja_chica_dashboard",options={"expose"=true})
     * @Method("GET")
     */
    public function CajaChicaction()
    {
        
       return $this->render('cajachica/index.html.twig', array(
            
        ));
    }
    
    
     /**
     * Lists all ClientePotencial entities.
     *
     * @Route("/proyecto", name="proyecto_dashboard",options={"expose"=true})
     * @Method("GET")
     */
    public function ProyectosAction()
    {
        
        return $this->render('dashboard/dashboardproyecto.html.twig', array(
            
        ));
    }
    
    
    
 }
