<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SubcategoryBudgetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
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
 *              "security" = "is_granted('ROLE_USER') and object.getSubcategory().getCategory().getUserAccount() == user"
 *          },
 *          "put" = {
 *              "security" = "is_granted('ROLE_USER') and object.getSubcategory().getCategory().getUserAccount() == user"
 *          },
 *          "patch" = {
 *              "security" = "is_granted('ROLE_USER') and object.getSubcategory().getCategory().getUserAccount() == user"
 *          },
 *          "delete" = {
 *              "security" = "is_granted('ROLE_USER') and object.getSubcategory().getCategory().getUserAccount() == user"
 *          }
 *     },
 *     normalizationContext={"groups"={"subcategoryBudget:read"}},
 *     denormalizationContext={"groups"={"subcategoryBudget:write"}},
 * )
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass=SubcategoryBudgetRepository::class)
 * @ORM\EntityListeners({"App\Doctrine\SettlementAccountSetOwnerListener"})
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
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern="/\d{1,13}\.?\d{0,8}/",
     *     message="This value is incorrect. It should have scale = 8 and precision = 21"
     * )
     * @Groups({"subcategory:read", "subcategory:write", "category:item:get"})
     * @ORM\Column(type="decimal", precision=21, scale=8)
     */
    private $amount;

    /**
     * @Assert\NotBlank
     * @Assert\Valid()
     * @Groups({"category:item:get"})
     * @ORM\ManyToOne(targetEntity=Subcategory::class, inversedBy="subcategoryBudgets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subcategory;

    /**
     * @Assert\NotBlank
     * @Groups({"category:item:get"})
     * @ORM\Column(type="datetimetz")
     */
    private $since;

    /**
     * @Assert\NotBlank
     * @Groups({"category:item:get"})
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

    public function __toString(): String
    {
        return $this->id;
    }
}
