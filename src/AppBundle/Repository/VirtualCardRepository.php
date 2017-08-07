<?php

namespace AppBundle\Repository;

use AppBundle\Entity\VirtualCard;
use Doctrine\ORM\EntityRepository;

/**
 * VirtualCardRepository.
 */
class VirtualCardRepository extends EntityRepository
{
    /**
     * @return VirtualCard[]|[]
     */
    public function getVirtualCardDiscrepancyAmount()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb
            ->select('vc')
            ->from('AppBundle:VirtualCard', 'vc')
            ->where('vc.amount != vc.amountOnCard');

        $query = $qb->getQuery();

        return $query->getResult();
    }
}
