<?php

namespace AppBundle\Service;

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
     * @return array
     */
    public function createMultiUseCard(VirtualCardRequest $vcRequest)
    {
        $amountOnCard = $this->getCardManager()
            ->getOnCardAmount($vcRequest->getEffectiveOn(), $vcRequest->getAmount());

        return [
            'card_no' => '1111111',
            'expiry_date' => '12/2018',
            'card_cvv' => '123',
            'card_name' => 'TEST CARD',
        ];
    }

    public function amendCard()
    {
    }

    /**
     * @return CardManager
     */
    private function getCardManager()
    {
        return $this->cardManager;
    }
}
