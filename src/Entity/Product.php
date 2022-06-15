<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
#[ORM\Table(name: 'products')]
#[ApiResource]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2)]
    private $price_per_unit = 0.00;

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero]
    private $stock;

    #[ORM\Column(type: 'string', length: 255)]
    private $unit_type;

    #[ORM\ManyToMany(targetEntity: Tags::class)]
    #[ORM\JoinTable(name: "products_tags")]
    #[ORM\JoinColumn(name: "products_id", referencedColumnName: "id")]
    private $Tags;

    #[ORM\Column(type: 'json', nullable: true)]
    private $images = [];

    #[ORM\Column(type: 'boolean')]
    private $deleted = false;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $onSale;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2, nullable: true)]
    private $originalPrice;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $subtitle;

    public function __construct()
    {
        $this->Tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPricePerUnit(): ?string
    {
        return $this->price_per_unit;
    }

    public function setPricePerUnit(string $price_per_unit): self
    {
        $this->price_per_unit = $price_per_unit;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getUnitType(): ?string
    {
        return $this->unit_type;
    }

    public function setUnitType(string $unit_type): self
    {
        $this->unit_type = $unit_type;

        return $this;
    }

    /**
     * @return Collection<int, Tags>
     */
    public function getTags(): Collection
    {
        return $this->Tags;
    }

    public function addTag(Tags $tag): self
    {
        if (!$this->Tags->contains($tag)) {
            $this->Tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tags $tag): self
    {
        $this->Tags->removeElement($tag);

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getOnSale(): ?bool
    {
        return $this->onSale;
    }

    public function setOnSale(?bool $onSale): self
    {
        $this->onSale = $onSale;

        return $this;
    }

    public function getOriginalPrice(): ?string
    {
        return $this->originalPrice;
    }

    public function setOriginalPrice(?string $originalPrice): self
    {
        $this->originalPrice = $originalPrice;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }
}
