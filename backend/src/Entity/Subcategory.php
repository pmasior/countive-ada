<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SubcategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     securityMessage="Only owner can perform this operation.",
 *     collectionOperations={
 *          "get" = {
 *              "security" = "is_granted('ROLE_USER')"
 *          },
 *          "post" = {
 *              "security" = "is_granted('ROLE_USER')"
 *          }
 *      },
 *     itemOperations={
 *          "get"={
 *              "security" = "is_granted('ROLE_USER') and object.getCategory().getUserAccount() == user"
 *          },
 *          "put" = {
 *              "security" = "is_granted('ROLE_USER') and object.getCategory().getUserAccount() == user"
 *          },
 *          "patch" = {
 *              "security" = "is_granted('ROLE_USER') and object.getCategory().getUserAccount() == user"
 *          },
 *          "delete" = {
 *              "security" = "is_granted('ROLE_USER') and object.getCategory().getUserAccount() == user"
 *          }
 *     },
 *     normalizationContext={"groups"={"subcategory:read"}},
 *     denormalizationContext={"groups"={"subcategory:write"}},
 * )
 * @ApiFilter(PropertyFilter::class)
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
     * @Assert\Length(max=100)
     * @Assert\NotBlank
     * @Groups({"subcategory:read", "subcategory:write", "category:item:get"})
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @Assert\Valid()
     * @Groups({"subcategory:read", "subcategory:write"})
     * @ORM\ManyToOne(targetEntity=Icon::class)
     */
    private $icon;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=25)
     * @Groups({"subcategory:read", "subcategory:write"})
     * @ORM\Column(type="string", length=25)
     */
    private $color;

    /**
     * @Assert\NotBlank
     * @Assert\Valid()
     * @Groups({"subcategory:read", "subcategory:write"})
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="subcategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @Groups({"subcategory:read", "subcategory:write"})
     * @ORM\OneToMany(targetEntity=SubcategoryBudget::class, mappedBy="subcategory", orphanRemoval=true)
     */
    private $subcategoryBudgets;

    /**
     * @Groups({"subcategory:read", "subcategory:write"})
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

    public function __toString(): String
    {
        return $this->id;
    }
}
