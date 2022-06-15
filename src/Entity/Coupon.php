<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
#[ApiResource]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    private $code;

    #[ORM\Column(type: 'decimal', precision: 10, scale: '0', nullable: true)]
    private $priceReduction;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $percentageReduction;

    #[ORM\Column(type: 'integer')]
    private $timesUsable;

    #[ORM\Column(type: 'integer')]
    private $timesUsed = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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

    public function setPercentageReduction(int $percentageReduction): self
    {
        $this->percentageReduction = $percentageReduction;

        return $this;
    }

    public function getTimesUsable(): ?int
    {
        return $this->timesUsable;
    }

    public function setTimesUsable(int $timesUsable): self
    {
        $this->timesUsable = $timesUsable;

        return $this;
    }

    public function getTimesUsed(): ?int
    {
        return $this->timesUsed;
    }

    public function setTimesUsed(int $timesUsed): self
    {
        $this->timesUsed = $timesUsed;

        return $this;
    }
}
