<?php

namespace AppBundle\Controller;

use AppBundle\Entity\VirtualCardRequest;
use AppBundle\Service\Enett;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/test")
 */
class ApiController extends Controller
{
    /**
     * @Route("/", name="api_test")
     */
    public function testAction(Request $request)
    {
        $u = $request->getContent();
        $enett = $this->get(Enett::class);

        $requestContent = json_decode($request->getContent(), true);
        $virtualCard = new VirtualCardRequest();
        $cardDetails = $enett->createMultiUseCard($virtualCard);

        return new JsonResponse([
            'success' => true,
            'data' => $cardDetails,
        ]);
    }
}
