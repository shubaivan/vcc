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
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=8)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="effective_on", type="datetime")
     */
    private $effectiveOn;

    /**
     * @var string
     *
     * @ORM\Column(name="amount_on_card", type="decimal", precision=10, scale=8)
     */
    private $amountOnCard;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime")
     */
    private $createdOn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_on", type="datetimetz")
     */
    private $updatedOn;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
    private $user;

	/**
	 * @var array
	 *
	 * @ORM\Column(name="purpose_details", type="json_array")
	 */
    private $purposeDetails;


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
     * @param string $amount
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
     * @return string
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
     * @param string $amountOnCard
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
     * @return string
     */
    public function getAmountOnCard()
    {
        return $this->amountOnCard;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return VirtualCard
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set updatedOn
     *
     * @param \DateTime $updatedOn
     *
     * @return VirtualCard
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * Get updatedOn
     *
     * @return \DateTime
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set purposeDetails
     *
     * @param array $purposeDetails
     *
     * @return VirtualCard
     */
    public function setPurposeDetails($purposeDetails)
    {
        $this->purposeDetails = $purposeDetails;

        return $this;
    }

    /**
     * Get purposeDetails
     *
     * @return array
     */
    public function getPurposeDetails()
    {
        return $this->purposeDetails;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return VirtualCard
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
