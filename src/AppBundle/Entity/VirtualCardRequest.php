<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * VirtualCardRequest
 *
 * @ORM\Table(name="virtual_card_requests")
 * @ORM\Entity()
 */
class VirtualCardRequest
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
     * @var float
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=3)
	 * @Assert\NotNull()
	 * @Assert\GreaterThan(value="0")
     */
    private $amount;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="currency", type="string", length=4)
	 * @Assert\NotNull()
	 */
    private $currency;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="effective_on", type="datetime")
	 * @Assert\NotNull()
	 * @Assert\Date()
     */
    private $effectiveOn;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 * @Assert\NotNull()
     */
    private $user;

    /**
     * @var array
     *
     * @ORM\Column(name="purpose_details", type="json_array")
	 * @Assert\NotNull()
     */
    private $purposeDetails;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="provider_request", type="json_array", nullable=true)
	 */
    private $providerRequest;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="provider_response", type="json_array", nullable=true)
	 */
    private $providerResponse;


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
     * Set amount
     *
     * @param float $amount
     *
     * @return VirtualCardRequest
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
     * @return VirtualCardRequest
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
     * Set purposeDetails
     *
     * @param array $purposeDetails
     *
     * @return VirtualCardRequest
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
     * @return VirtualCardRequest
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

	/**
	 * @return string
	 */
	public function getCurrency()
	{
		return $this->currency;
	}

	/**
	 * @param string $currency
	 */
	public function setCurrency($currency)
	{
		$this->currency = $currency;
	}

	/**
	 * @return string
	 */
	public function getProviderRequest()
	{
		return $this->providerRequest;
	}

	/**
	 * @param string $providerRequest
	 */
	public function setProviderRequest($providerRequest)
	{
		$this->providerRequest = $providerRequest;
	}

	/**
	 * @return string
	 */
	public function getProviderResponse()
	{
		return $this->providerResponse;
	}

	/**
	 * @param string $providerResponse
	 */
	public function setProviderResponse($providerResponse)
	{
		$this->providerResponse = $providerResponse;
	}
}
