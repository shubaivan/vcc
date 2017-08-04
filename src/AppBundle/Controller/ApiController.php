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
 * @Route("/api")
 */
class ApiController extends Controller
{
    /**
     * @Route("/test", name="api_test")
     */
    public function testAction(Request $request)
    {
		$requestContent = json_decode($request->getContent(), true);
		$requestContent = $requestContent['data'];

		$enett = $this->get(Enett::class);
        $em = $this->getDoctrine()->getManager();
        $validator = $this->get('validator');

        // create virual card request
        $virtualCardRequest = new VirtualCardRequest();
        $virtualCardRequest->setAmount($requestContent['amount']);
        $virtualCardRequest->setCurrency($requestContent['currency']);
        $virtualCardRequest->setEffectiveOn(\DateTime::createFromFormat('Y-m-d', $requestContent['effective_date']));
        $virtualCardRequest->setPurposeDetails($requestContent['reason']);
        $virtualCardRequest->setUser($this->getUser());
        $isValid = $validator->validate($virtualCardRequest);

        if ($isValid->count()) {
        	$outErrs = array();

        	foreach ($isValid as $err) {
        		$outErrs[$err->getPropertyPath()][] = $err->getMessage();
			}

			return new JsonResponse(array('success' => false, 'errors' => $outErrs));
		}

        $em->persist($virtualCardRequest);
        $em->flush();

        $cardDetails = $enett->createMultiUseCard($virtualCardRequest);
        $em->flush();

        return new JsonResponse([
            'success' => true,
            'data' => $cardDetails,
        ]);
    }
}
