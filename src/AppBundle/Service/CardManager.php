<?php

namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class CardManager
{
	private $minimalAmount;
	private $fullAmountDaysThreshold;

	/**
	 * CardManager constructor.
	 */
	public function __construct()
	{
		// TODO: Change to values from config.yml
		$this->minimalAmount = 1;
		$this->fullAmountDaysThreshold = 1;
	}


	public function getOnCardAmount(\DateTime $effectiveDate, $amount) {
		$interval = new \DateInterval("P{$this->fullAmountDaysThreshold}D");
		$effectiveDate = clone $effectiveDate;
		$effectiveDate->sub($interval);
		$datNow = new \DateTime();

		return ($effectiveDate <= $datNow) ? $amount : $this->minimalAmount;
	}
}