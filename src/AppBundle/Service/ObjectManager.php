<?php

namespace AppBundle\Service;

use AppBundle\Exception\DeserializeException;
use AppBundle\Exception\ValidatorException;
use Doctrine\ORM\EntityManager;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Serializer;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ObjectManager
{
    /**
     * @var Serializer
     */
    private $jmsSerializer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * ObjectManager constructor.
     *
     * @param Serializer            $jmsSerializer
     * @param ValidatorInterface    $validator
     */
    public function __construct(
        Serializer $jmsSerializer,
        ValidatorInterface $validator,
        TokenStorageInterface $tokenStorageInterface,
        EntityManager $em
    ) {
        $this->jmsSerializer = $jmsSerializer;
        $this->validator = $validator;
    }

    /**
     * @param array $arrayData
     * @param array $arrayGroup
     * @param $className
     *
     * @return object
     */
    public function createEntityByParam(
        array $arrayData,
        array $arrayGroup,
        $className
    ) {
        $jmsSerializer = $this->getSerializer();

        try {
            $data = $jmsSerializer->serialize($arrayData, 'json');

            /** @var object $entity */
            $entity = $jmsSerializer->deserialize(
                $data,
                $className,
                'json',
                DeserializationContext::create()
                    ->setGroups($arrayGroup)
            );
        } catch (\Exception $e) {
            throw new DeserializeException($e->getMessage());
        }

        $this->validateEntity($entity, $arrayGroup);

        return $entity;
    }

    /**
     * @param object $entity
     * @param array  $validateGroups
     *
     * @throws ValidatorException
     */
    public function validateEntity(
        $entity,
        array $validateGroups
    ) {
        $validateGroups = $validateGroups ? $validateGroups : null;
        $errors = $this->getValidatorInterface()
            ->validate($entity, null, $validateGroups);
        if (count($errors)) {
            $validatorException = new ValidatorException();
            $validatorException->addError([$errors]);

            throw $validatorException;
        }
    }

    /**
     * @return Serializer
     */
    private function getSerializer()
    {
        return $this->jmsSerializer;
    }

    /**
     * @return ValidatorInterface
     */
    private function getValidatorInterface()
    {
        return $this->validator;
    }

    /**
     * @return TokenStorageInterface
     */
    private function getTokenStorageInterface()
    {
        return $this->tokenStorageInterface;
    }

    /**
     * @return EntityManager
     */
    private function getEntityManager()
    {
        return $this->em;
    }
}
