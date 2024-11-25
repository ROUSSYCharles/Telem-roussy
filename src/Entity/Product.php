<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    /** @var int|null numéro du produit */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    /** @var string|null nom du produit */
    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le nom du produit doit être indiqué')]
    #[Assert\Length(
        min: 5,
        max: 120,
        minMessage: 'Le nom du produit doit faire au moins {{ limit }} caractères',
        maxMessage: 'Le nom du produit doit faire au plus {{ limit }} caractères'
    )]
    private ?string $name;

    /** @var string|null description du produit */
    #[ORM\Column(nullable: true, length: 2000)]
    #[Assert\Length(min: 10, minMessage: 'La description doit faire au moins {{ limit }} caractères',
)]
    private ?string $description;

    /** @var \DateTimeImmutable  date d'ajout au catalogue */
    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    /** @var int|null quantité en stock */
   #[ORM\Column(nullable: true)]
   #[Assert\PositiveOrZero(message: 'La quantité doit être supérieure à zéro')]
    private ?int $quantityInStock;

    /** @var int|null prix HT */
    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'Le prix est obligatoire')]
    #[Assert\Positive(message: 'Le prix doit être strictement supérieur à zéro')]
    private ?int $price;

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
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int|null $price
     * @return Product
     */
    public function setPrice(?int $price): Product
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