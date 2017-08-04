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
        $virtualCardRequest->setHotel($requestContent['booking_details']['hotel']);
		$virtualCardRequest->setHotelRoom($requestContent['booking_details']['room']);
		$virtualCardRequest->setTourists($requestContent['booking_details']['tourists']);
		$virtualCardRequest->setCheckIn(\DateTime::createFromFormat('Y-m-d', $requestContent['booking_details']['check_in']));
		$virtualCardRequest->setCheckOut(\DateTime::createFromFormat('Y-m-d', $requestContent['booking_details']['check_out']));
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
