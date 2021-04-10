<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ApiResource()
 */
class Category
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
     * @ORM\ManyToOne(targetEntity=UserAccount::class, inversedBy="categories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userAccount;

    /**
     * @ORM\OneToMany(targetEntity=Subcategory::class, mappedBy="category", orphanRemoval=true)
     */
    private $subcategories;

    /**
     * @ORM\OneToMany(targetEntity=Tag::class, mappedBy="category", orphanRemoval=true)
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity=CategoryBudget::class, mappedBy="category", orphanRemoval=true)
     */
    private $categoryBudgets;

    public function __construct()
    {
        $this->subcategories = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->categoryBudgets = new ArrayCollection();
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

    public function getUserAccount(): ?UserAccount
    {
        return $this->userAccount;
    }

    public function setUserAccount(?UserAccount $userAccount): self
    {
        $this->userAccount = $userAccount;

        return $this;
    }

    /**
     * @return Collection|Subcategory[]
     */
    public function getSubcategories(): Collection
    {
        return $this->subcategories;
    }

    public function addSubcategory(Subcategory $subcategory): self
    {
        if (!$this->subcategories->contains($subcategory)) {
            $this->subcategories[] = $subcategory;
            $subcategory->setCategory($this);
        }

        return $this;
    }

    public function removeSubcategory(Subcategory $subcategory): self
    {
        if ($this->subcategories->removeElement($subcategory)) {
            // set the owning side to null (unless already changed)
            if ($subcategory->getCategory() === $this) {
                $subcategory->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->setCategory($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getCategory() === $this) {
                $tag->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CategoryBudget[]
     */
    public function getCategoryBudgets(): Collection
    {
        return $this->categoryBudgets;
    }

    public function addCategoryBudget(CategoryBudget $categoryBudget): self
    {
        if (!$this->categoryBudgets->contains($categoryBudget)) {
            $this->categoryBudgets[] = $categoryBudget;
            $categoryBudget->setCategory($this);
        }

        return $this;
    }

    public function removeCategoryBudget(CategoryBudget $categoryBudget): self
    {
        if ($this->categoryBudgets->removeElement($categoryBudget)) {
            // set the owning side to null (unless already changed)
            if ($categoryBudget->getCategory() === $this) {
                $categoryBudget->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString(): String
    {
        return $this->id;
    }
}
