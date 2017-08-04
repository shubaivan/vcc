<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    /**
     * @Route("/", name="dashboard")
     */
    public function dashboardAction()
    {
        $requests = $this->getDoctrine()->getRepository('AppBundle:VirtualCardRequest')->findBy(array(), array('createdOn' => 'DESC'));

        return $this->render('dashboard/dashboard.html.twig', array(
            'vc_requests' => $requests
        ));
    }
}
