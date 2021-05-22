<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryRepository;
use App\Validator\IsValidOwner;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Symfony\Component\Validator\Constraints as Assert;

/* TODO:
 *              "security" = "is_granted('CATEGORY_CREATE', object)"
 *              "security" = "is_granted('CATEGORY_RETRIEVE', object)"
 * use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *          "name": "partial",
 *          "subcategories": "exact",
 *          "subcategories.name": "partial"
 *     }
 * )
*/

/**
 * @ApiResource(
 *     securityMessage="Only owner can perform this operation.",
 *     collectionOperations={
 *          "get" = {
 *              "security" = "is_granted('ROLE_USER')"
 *          },
 *          "post" = {
 *              "security" = "is_granted('ROLE_USER')",
 *              "denormalization_context" = {"groups"={"category:write", "category:collection:post"}}
 *          }
 *      },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"category:read", "category:item:get"}},
 *              "security" = "is_granted('CATEGORY_RETRIEVE', object)"
 *          },
 *          "put" = {
 *              "security" = "is_granted('CATEGORY_REPLACE', object)"
 *
 *          },
 *          "patch" = {
 *              "security" = "is_granted('CATEGORY_UPDATE', object)"
 *          },
 *          "delete" = {
 *              "security" = "is_granted('CATEGORY_REMOVE', object)"
 *          }
 *     },
 *     normalizationContext={"groups"={"category:read"}},
 *     denormalizationContext={"groups"={"category:write"}},
 *     attributes={
 *          "formats"={
 *              "jsonld", "json", "html", "csv"={"text/csv"}, "yaml"={"text/yaml"}
 *          }
 *     }
 * )
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ORM\EntityListeners({"App\Doctrine\CategorySetOwnerListener"})
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
     * @Assert\NotBlank
     * @Assert\Length(max=100)
     * @Groups({"category:read", "category:write"})
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @Assert\Valid()
     * @Groups({"category:read", "category:write"})
     * @ORM\ManyToOne(targetEntity=Icon::class)
     */
    private $icon;

//     TODO: is needed? @Assert\Valid() (also in other entities)
    /**
     * @Assert\Valid()
     * @IsValidOwner()
     * @Groups({"category:read", "category:collection:post"})
     * @ORM\ManyToOne(targetEntity=UserAccount::class, inversedBy="categories")
     * @ORM\JoinColumn(nullable=false)
     * @SerializedName("user")
     */
    private $userAccount;

    /**
     * @Assert\Valid()
     * @Groups({"category:read", "category:write"})
     * @ORM\OneToMany(targetEntity=Subcategory::class, mappedBy="category", orphanRemoval=true)
     */
    private $subcategories;

    /**
     * @Assert\Valid()
     * @Groups({"category:read", "category:write"})
     * @ORM\OneToMany(targetEntity=Tag::class, mappedBy="category", orphanRemoval=true)
     */
    private $tags;

    /**
     * @Assert\Valid()
     * @Groups({"category:read", "category:write"})
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
