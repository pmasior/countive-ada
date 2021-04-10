<?php

namespace App\Entity;

use App\Repository\SubcategoryBudgetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubcategoryBudgetRepository::class)
 */
class SubcategoryBudget
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=21, scale=8)
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Subcategory::class, inversedBy="subcategoryBudgets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subcategory;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $since;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $until;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSubcategory(): ?Subcategory
    {
        return $this->subcategory;
    }

    public function setSubcategory(?Subcategory $subcategory): self
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    public function getSince(): ?\DateTimeInterface
    {
        return $this->since;
    }

    public function setSince(\DateTimeInterface $since): self
    {
        $this->since = $since;

        return $this;
    }

    public function getUntil(): ?\DateTimeInterface
    {
        return $this->until;
    }

    public function setUntil(\DateTimeInterface $until): self
    {
        $this->until = $until;

        return $this;
    }
}
