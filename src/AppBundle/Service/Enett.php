<?php

namespace AppBundle\Service;

use AppBundle\Entity\VirtualCard;
use AppBundle\Entity\VirtualCardRequest;

class Enett
{
    /**
     * @var CardManager
     */
    private $cardManager;

    /**
     * Enett constructor.
     * @param $cardManager
     */
    public function __construct(CardManager $cardManager)
    {
        $this->cardManager = $cardManager;
    }

    /**
     * @param VirtualCardRequest $vcRequest
     * @return VirtualCard
     */
    public function createMultiUseCard(VirtualCardRequest $vcRequest)
    {
        $amountOnCard = $this->getCardManager()
            ->getOnCardAmount($vcRequest->getEffectiveOn(), $vcRequest->getAmount());

        $card = new VirtualCard();

        $card
            ->setAmount($vcRequest->getAmount())
            ->setAmountOnCard($amountOnCard)
            ->setCardNo($this->amendCard())
            ->setCardType($vcRequest->getCurrency())
            ->setEffectiveOn($vcRequest->getEffectiveOn());

        return $card;
    }

    public function amendCard()
    {
        return rand(pow(10, 13), pow(10, 16)-1);
    }

    /**
     * @return CardManager
     */
    private function getCardManager()
    {
        return $this->cardManager;
    }
}
