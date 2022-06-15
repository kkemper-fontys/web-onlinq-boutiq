<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderCouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderCouponRepository::class)]
#[ApiResource]
class OrderCoupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Coupon::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $coupon;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'couponLines')]
    #[ORM\JoinColumn(nullable: false)]
    private $masterOrder;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $priceReduction;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $percentageReduction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoupon(): ?coupon
    {
        return $this->coupon;
    }

    public function setCoupon(?coupon $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }

    public function getMasterOrder(): ?Order
    {
        return $this->masterOrder;
    }

    public function setMasterOrder(?Order $masterOrder): self
    {
        $this->masterOrder = $masterOrder;

        return $this;
    }

    public function getPriceReduction(): ?string
    {
        return $this->priceReduction;
    }

    public function setPriceReduction(?string $priceReduction): self
    {
        $this->priceReduction = $priceReduction;

        return $this;
    }

    public function getPercentageReduction(): ?int
    {
        return $this->percentageReduction;
    }

    public function setPercentageReduction(?int $percentageReduction): self
    {
        $this->percentageReduction = $percentageReduction;

        return $this;
    }
}
