<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VirtualCard
 *
 * @ORM\Table(name="virtual_cards")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VirtualCardRepository")
 */
class VirtualCard
{
    use TimestampableTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="card_no", type="string", length=16, unique=true)
     */
    private $cardNo;

    /**
     * @var string
     *
     * @ORM\Column(name="card_type", type="string", length=20)
     */
    private $cardType;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=3)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="effective_on", type="datetime")
     */
    private $effectiveOn;

    /**
     * @var float
     *
     * @ORM\Column(name="amount_on_card", type="decimal", precision=10, scale=3)
     */
    private $amountOnCard;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cardNo
     *
     * @param string $cardNo
     *
     * @return VirtualCard
     */
    public function setCardNo($cardNo)
    {
        $this->cardNo = $cardNo;

        return $this;
    }

    /**
     * Get cardNo
     *
     * @return string
     */
    public function getCardNo()
    {
        return $this->cardNo;
    }

    /**
     * Set cardType
     *
     * @param string $cardType
     *
     * @return VirtualCard
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;

        return $this;
    }

    /**
     * Get cardType
     *
     * @return string
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * Set amount
     *
     * @param float $amount
     *
     * @return VirtualCard
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set effectiveOn
     *
     * @param \DateTime $effectiveOn
     *
     * @return VirtualCard
     */
    public function setEffectiveOn($effectiveOn)
    {
        $this->effectiveOn = $effectiveOn;

        return $this;
    }

    /**
     * Get effectiveOn
     *
     * @return \DateTime
     */
    public function getEffectiveOn()
    {
        return $this->effectiveOn;
    }

    /**
     * Set amountOnCard
     *
     * @param float $amountOnCard
     *
     * @return VirtualCard
     */
    public function setAmountOnCard($amountOnCard)
    {
        $this->amountOnCard = $amountOnCard;

        return $this;
    }

    /**
     * Get amountOnCard
     *
     * @return float
     */
    public function getAmountOnCard()
    {
        return $this->amountOnCard;
    }
}
