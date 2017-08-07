<?php

namespace AppBundle\Service;

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
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->minimalAmount = $config['minimal_amount'];
        $this->fullAmountDaysThreshold = $config['full_amount_days_threshold'];
    }

    /**
     * @param \DateTime $effectiveDate
     * @param $amount
     *
     * @return int|mixed
     */
    public function getOnCardAmount(\DateTime $effectiveDate, $amount)
    {
        $interval = new \DateInterval("P{$this->fullAmountDaysThreshold}D");
        $effectiveDate = clone $effectiveDate;
        $effectiveDate->sub($interval);
        $datNow = new \DateTime();

        return ($effectiveDate <= $datNow) ? $amount : $this->minimalAmount;
    }
}
