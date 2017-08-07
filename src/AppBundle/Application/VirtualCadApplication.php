<?php

namespace AppBundle\Application;

use AppBundle\Domain\VirtualCadDomain;
use AppBundle\Service\CardManager;
use AppBundle\Service\Enett;

class VirtualCadApplication
{
    /**
     * @var VirtualCadDomain
     */
    private $virtualCadDomain;

    /**
     * @var CardManager
     */
    private $cardManager;

    /**
     * VirtualCadApplication constructor.
     *
     * @param VirtualCadDomain $virtualCadDomain
     * @param CardManager      $cardManager
     */
    public function __construct(
        VirtualCadDomain $virtualCadDomain,
        CardManager $cardManager
    ) {
        $this->virtualCadDomain = $virtualCadDomain;
        $this->cardManager = $cardManager;
    }

    public function proccess()
    {
        $virtualCardDiscrepancyAmounts = $this->getVirtualCadDomain()
            ->getVirtualCardDiscrepancyAmount();

        foreach ($virtualCardDiscrepancyAmounts as $virtualCardDiscrepancyAmount) {
            $amount = $virtualCardDiscrepancyAmount->getAmount();
            $effectiveDate = $virtualCardDiscrepancyAmount->getEffectiveOn();
            if ($amount === $this->getCardManager()->getOnCardAmount($effectiveDate, $amount)) {
                //Process Enett
            }
        }
    }

    private function getVirtualCadDomain()
    {
        return $this->virtualCadDomain;
    }

    /**
     * @return CardManager
     */
    private function getCardManager()
    {
        return $this->cardManager;
    }
}
