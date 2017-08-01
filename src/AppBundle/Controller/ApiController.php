<?php

namespace AppBundle\Controller;

use AppBundle\Service\Enett;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api")
 */
class ApiController extends Controller
{
    /**
     * @Route("/", name="api_test")
     */
    public function testAction(Request $request)
    {
    	$enett = $this->get(Enett::class);

    	$cardDetails = $enett->createMultiUseCard();

        return new JsonResponse([
        	'success' => true,
			'data' => $cardDetails,
		]);
    }
}
