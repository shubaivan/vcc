<?php

namespace AppBundle\Controller;

use AppBundle\Entity\VirtualCardRequest;
use AppBundle\Exception\DeserializeException;
use AppBundle\Exception\ValidatorException;
use AppBundle\Service\Enett;
use JMS\Serializer\DeserializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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

        $enett = $this->get(Enett::class);
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
        try {
            // create virtual card request
            $virtualCardRequest = $this->createEntityByParam($data, [VirtualCardRequest::GROUP_POST]);
            $em->persist($virtualCardRequest);
            $em->flush();

            $cardDetails = $enett->createMultiUseCard($virtualCardRequest);
            $this->validateEntity($cardDetails, []);
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

    /**
     * {@inheritdoc}
     */
    private function createEntityByParam(array $arrayData, array $arrayGroup)
    {
        $jmsSerializer = $this->get('jms_serializer');
        try {
            $data = $jmsSerializer->serialize($arrayData, 'json');

            /** @var VirtualCardRequest $entity */
            $entity = $jmsSerializer->deserialize(
                $data,
                VirtualCardRequest::class,
                'json',
                DeserializationContext::create()
                    ->setGroups($arrayGroup)
            );
        } catch (\Exception $e) {
            throw new DeserializeException($e->getMessage());
        }
        $entity->setUser($this->getUser());
        $this->validateEntity($entity, $arrayGroup);

        return $entity;
    }

    /**
     * @param object $entity
     * @param array $validateGroups
     * @throws ValidatorException
     */
    private function validateEntity(
        $entity,
        array $validateGroups
    ) {
        $validator = $this->get('validator');
        $validateGroups = $validateGroups ? $validateGroups : null;
        $errors = $validator->validate($entity, null, $validateGroups);
        if (count($errors)) {
            $validatorException = new ValidatorException();
            $validatorException->addError([$errors]);
            throw $validatorException;
        }
    }
}
