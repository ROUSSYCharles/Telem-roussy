<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Product
{
    /** @var int|null numéro du produit */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    /** @var string|null nom du produit */
    #[ORM\Column]
    private ?string $name;

    /** @var string|null description du produit */
    #[ORM\Column(nullable: true, length: 2000)]
    private ?string $description;

    /** @var \DateTimeImmutable  date d'ajout au catalogue */
    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    /** @var int|null quantité en stock */
   #[ORM\Column(nullable: true)]
    private ?int $quantityInStock;

    /** @var float|null prix HT */
    #[ORM\Column(type: 'integer')]
    private ?float $price;

    /** @var string|null nom de l'image */
    #[ORM\Column(nullable: true)]
    private ?string $imageName;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Product
     */
    public function setName(?string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Product
     */
    public function setDescription(?string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     * @return Product
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): Product
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantityInStock(): ?int
    {
        return $this->quantityInStock;
    }

    /**
     * @param int|null $quantityInStock
     * @return Product
     */
    public function setQuantityInStock(?int $quantityInStock): Product
    {
        $this->quantityInStock = $quantityInStock;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     * @return Product
     */
    public function setPrice(?float $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @param string|null $imageName
     * @return Product
     */
    public function setImageName(?string $imageName): Product
    {
        $this->imageName = $imageName;
        return $this;
    }
}