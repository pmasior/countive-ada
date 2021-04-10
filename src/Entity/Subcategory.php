<?php

namespace App\Entity;

use App\Repository\SubcategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubcategoryRepository::class)
 */
class Subcategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Icon::class)
     */
    private $icon;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $color;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="subcategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=SubcategoryBudget::class, mappedBy="subcategory", orphanRemoval=true)
     */
    private $subcategoryBudgets;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="subcategory", orphanRemoval=true)
     */
    private $transactions;

    public function __construct()
    {
        $this->subcategoryBudgets = new ArrayCollection();
        $this->transactions = new ArrayCollection();
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

    public function getIcon(): ?Icon
    {
        return $this->icon;
    }

    public function setIcon(?Icon $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|SubcategoryBudget[]
     */
    public function getSubcategoryBudgets(): Collection
    {
        return $this->subcategoryBudgets;
    }

    public function addSubcategoryBudget(SubcategoryBudget $subcategoryBudget): self
    {
        if (!$this->subcategoryBudgets->contains($subcategoryBudget)) {
            $this->subcategoryBudgets[] = $subcategoryBudget;
            $subcategoryBudget->setSubcategory($this);
        }

        return $this;
    }

    public function removeSubcategoryBudget(SubcategoryBudget $subcategoryBudget): self
    {
        if ($this->subcategoryBudgets->removeElement($subcategoryBudget)) {
            // set the owning side to null (unless already changed)
            if ($subcategoryBudget->getSubcategory() === $this) {
                $subcategoryBudget->setSubcategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setSubcategory($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getSubcategory() === $this) {
                $transaction->setSubcategory(null);
            }
        }

        return $this;
    }
}
