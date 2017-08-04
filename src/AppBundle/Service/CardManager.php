<?php

namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class CardManager
{
    /**
     * @var int
     */
    private $minimalAmount;

    /**
     * @var int
     */
    private $fullAmountDaysThreshold;

    /**
     * CardManager constructor.
     * @param integer $minimalAmount1
     * @param integer $fullAmountDaysThreshold1
     */
    public function __construct(
        $minimalAmount1,
        $fullAmountDaysThreshold1
    ) {
        // TODO: Change to values from config.yml
        $this->minimalAmount = $minimalAmount1;
        $this->fullAmountDaysThreshold = $fullAmountDaysThreshold1;
    }

    public function getOnCardAmount(\DateTime $effectiveDate, $amount)
    {
        $interval = new \DateInterval("P{$this->fullAmountDaysThreshold}D");
        $effectiveDate = clone $effectiveDate;
        $effectiveDate->sub($interval);
        $datNow = new \DateTime();

        return ($effectiveDate <= $datNow) ? $amount : $this->minimalAmount;
    }
}
