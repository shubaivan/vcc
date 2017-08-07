<?php

namespace AppBundle\Controller;

use AppBundle\Entity\VirtualCardRequest;
use AppBundle\Exception\ValidatorException;
use AppBundle\Service\Enett;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
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

        $requestContentParameters = $this->prepareArray($requestContent);

        $enett = $this->get('app.service.enett');
        $em = $this->getDoctrine()->getManager();

        $data = [];
        $data['amount'] = $requestContentParameters->get('amount');
        $data['currency'] = $requestContentParameters->get('currency');
        $data['effective_on'] = \DateTime::createFromFormat('Y-m-d', $requestContentParameters->get('effective_date'));
        $data['hotel'] = $requestContentParameters->get('hotel');
        $data['hotel_room'] = $requestContentParameters->get('room');
        $data['tourists'] = $requestContentParameters->get('tourists');
        $data['check_in'] = \DateTime::createFromFormat('Y-m-d', $requestContentParameters->get('check_in'));
        $data['check_out'] = \DateTime::createFromFormat('Y-m-d', $requestContentParameters->get('check_out'));
        $data['user'] = $this->getUser();

        try {
            // create virtual card request
            $objectManager = $this->get('app.service.object_manager');
            /** @var VirtualCardRequest $virtualCardRequest */
            $virtualCardRequest = $objectManager->createEntityByParam(
                $data,
                [VirtualCardRequest::GROUP_POST],
                VirtualCardRequest::class
            );

            $em->persist($virtualCardRequest);
            $em->flush();

            $cardDetails = $enett->createMultiUseCard($virtualCardRequest);
            $objectManager->validateEntity($cardDetails, []);
            $em->persist($cardDetails);
            $em->flush();

            return new JsonResponse([
                'success' => true,
                'data' => $cardDetails,
            ]);
        } catch (ValidatorException $e) {
            return new JsonResponse([
                'success' => false,
                'data' => $e,
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'data' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @param array $array
     *
     * @return ParameterBag
     */
    private function prepareArray(array $array)
    {
        $parameters = new ParameterBag();
        array_walk_recursive($array, function ($value, $key) use (&$parameters) {
            $parameters->set($key, $value);
        });

        return $parameters;
    }
}
