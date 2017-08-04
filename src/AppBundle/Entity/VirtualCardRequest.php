<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation;

/**
 * VirtualCardRequest
 *
 * @ORM\Table(name="virtual_card_requests")
 * @ORM\Entity()
 */
class VirtualCardRequest implements \JsonSerializable
{
    const GROUP_POST = 'post_virtual_card';

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
     * @Annotation\Groups({
     *     "post_virtual_card"
     * })
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=3)
     * @Assert\NotNull(groups={"post_virtual_card"})
     * @Assert\GreaterThan(value="0")
     */
    private $amount;

    /**
     * @var string
     *
     * @Annotation\Groups({
     *     "post_virtual_card"
     * })
     *
     * @ORM\Column(name="currency", type="string", length=4)
     * @Assert\NotNull(groups={"post_virtual_card"})
     */
    private $currency;

    /**
     * @var \DateTime
     *
     * @Annotation\Groups({
     *     "post_virtual_card"
     * })
     * @ORM\Column(name="effective_on", type="datetime")
     * @Assert\NotNull(groups={"post_virtual_card"})
     * @Assert\Date(groups={"post_virtual_card"})
     */
    private $effectiveOn;

    /**
     * @var User
     *
     * @Annotation\Groups({
     *     "post_virtual_card"
     * })
     * @Annotation\Type("AppBundle\Entity\User")
     * @Annotation\SerializedName("user")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Assert\NotNull(groups={"post_virtual_card"})
     */
    private $user;

    /**
     * @var string
     *
     * @Annotation\Groups({
     *     "post_virtual_card"
     * })
     *
     * @ORM\Column(name="hotel", type="string", length=100)
     * @Assert\NotBlank(groups={"post_virtual_card"})
     */
    private $hotel;

    /**
     * @var string
     *
     * @Annotation\Groups({
     *     "post_virtual_card"
     * })
     *
     * @ORM\Column(name="hotel_room", type="string", length=100)
     * @Assert\NotBlank(groups={"post_virtual_card"})
     */
    private $hotelRoom;

    /**
     * @var string
     *
     * @Annotation\Groups({
     *     "post_virtual_card"
     * })
     *
     * @ORM\Column(name="tourists", type="string", length=200)
     * @Assert\NotBlank(groups={"post_virtual_card"})
     */
    private $tourists;

    /**
     * @var \DateTime
     *
     * @Annotation\Groups({
     *     "post_virtual_card"
     * })
     *
     * @ORM\Column(name="check_in", type="date")
     * @Assert\NotNull(groups={"post_virtual_card"})
     * @Assert\Date(groups={"post_virtual_card"})
     */
    private $checkIn;

    /**
     * @var \DateTime
     *
     * @Annotation\Groups({
     *     "post_virtual_card"
     * })
     *
     * @ORM\Column(name="check_out", type="date")
     * @Assert\NotNull(groups={"post_virtual_card"})
     * @Assert\Date(groups={"post_virtual_card"})
     */
    private $checkOut;

    /**
     * @var string
     *
     * @Annotation\Groups({
     *     "post_virtual_card"
     * })
     *
     * @ORM\Column(name="provider_request", type="json_array", nullable=true)
     */
    private $providerRequest;

    /**
     * @var string
     *
     * @Annotation\Groups({
     *     "post_virtual_card"
     * })
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
     * Set user
     *
     * @param User $user
     *
     * @return VirtualCardRequest
     */
    public function setUser(User $user = null)
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

    /**
     * @return string
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * @param string $hotel
     */
    public function setHotel($hotel)
    {
        $this->hotel = $hotel;
    }

    /**
     * @return string
     */
    public function getHotelRoom()
    {
        return $this->hotelRoom;
    }

    /**
     * @param string $hotelRoom
     */
    public function setHotelRoom($hotelRoom)
    {
        $this->hotelRoom = $hotelRoom;
    }

    /**
     * @return string
     */
    public function getTourists()
    {
        return $this->tourists;
    }

    /**
     * @param string $tourists
     */
    public function setTourists($tourists)
    {
        $this->tourists = $tourists;
    }

    /**
     * @return \DateTime
     */
    public function getCheckIn()
    {
        return $this->checkIn;
    }

    /**
     * @param \DateTime $checkIn
     */
    public function setCheckIn($checkIn)
    {
        $this->checkIn = $checkIn;
    }

    /**
     * @return \DateTime
     */
    public function getCheckOut()
    {
        return $this->checkOut;
    }

    /**
     * @param \DateTime $checkOut
     */
    public function setCheckOut($checkOut)
    {
        $this->checkOut = $checkOut;
    }

    public function jsonSerialize()
    {
        return [
            "id" => $this->getId(),
            "amount" => $this->getAmount()
        ];
    }
}
