<?php

namespace App\Entity;


use App\Repository\IngredientRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;    // Sert pour la validation des données de notre table

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
#[UniqueEntity('name')]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank()]               // Utiliser :  use Symfony\Component\Validator\Constraints as Assert;   pour pouvoir utiliser : Assert\...()
    #[Assert\Length(min: 2, max: 50)]  // Utiliser :  use Symfony\Component\Validator\Constraints as Assert;   pour pouvoir utiliser : Assert\...()
    private string $name;

    #[ORM\Column(type: 'float')]
    #[Assert\NotNull()]         // Utiliser :  use Symfony\Component\Validator\Constraints as Assert;   pour pouvoir utiliser : Assert\...()
    #[Assert\Positive()]       
    #[Assert\LessThan(200)]    
    private float $price;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull()]         // Utiliser :  use Symfony\Component\Validator\Constraints as Assert;   pour pouvoir utiliser : Assert\...()
    private ?\DateTimeImmutable $createdAt;


    // CONSTRUCTEUR
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();      // On met "\" devant DateTimeImmutable() pour ne pas importer la class (use ...)
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
