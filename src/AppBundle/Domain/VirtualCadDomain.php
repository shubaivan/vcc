<?php

namespace AppBundle\Domain;

use AppBundle\Repository\VirtualCardRepository;

class VirtualCadDomain
{
    /**
     * @var VirtualCardRepository
     */
    private $virtualCardRepository;

    /**
     * VirtualCadDomain constructor.
     *
     * @param VirtualCardRepository $virtualCardRepository
     */
    public function __construct(VirtualCardRepository $virtualCardRepository)
    {
        $this->virtualCardRepository = $virtualCardRepository;
    }

    /**
     * @return \AppBundle\Entity\VirtualCard[]
     */
    public function getVirtualCardDiscrepancyAmount()
    {
        return $this->getVirtualCardRepository()
            ->getVirtualCardDiscrepancyAmount();
    }

    /**
     * @return VirtualCardRepository
     */
    private function getVirtualCardRepository()
    {
        return $this->virtualCardRepository;
    }
}
