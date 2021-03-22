<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
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
    private $icon_id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="categories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\OneToMany(targetEntity=Subcategory::class, mappedBy="category_id", orphanRemoval=true)
     */
    private $subcategories;

    /**
     * @ORM\OneToMany(targetEntity=Tag::class, mappedBy="category_id", orphanRemoval=true)
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity=CategoryBudget::class, mappedBy="category_id", orphanRemoval=true)
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

    public function getIconId(): ?Icon
    {
        return $this->icon_id;
    }

    public function setIconId(?Icon $icon_id): self
    {
        $this->icon_id = $icon_id;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

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
            $subcategory->setCategoryId($this);
        }

        return $this;
    }

    public function removeSubcategory(Subcategory $subcategory): self
    {
        if ($this->subcategories->removeElement($subcategory)) {
            // set the owning side to null (unless already changed)
            if ($subcategory->getCategoryId() === $this) {
                $subcategory->setCategoryId(null);
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
            $tag->setCategoryId($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getCategoryId() === $this) {
                $tag->setCategoryId(null);
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
            $categoryBudget->setCategoryId($this);
        }

        return $this;
    }

    public function removeCategoryBudget(CategoryBudget $categoryBudget): self
    {
        if ($this->categoryBudgets->removeElement($categoryBudget)) {
            // set the owning side to null (unless already changed)
            if ($categoryBudget->getCategoryId() === $this) {
                $categoryBudget->setCategoryId(null);
            }
        }

        return $this;
    }
}
