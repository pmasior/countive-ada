<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
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
 *     normalizationContext={"groups"={"transaction:read"}},
 *     denormalizationContext={"groups"={"transaction:write"}},
 * )
 * @ApiFilter(DateFilter::class, properties={"addedAt"})
 * @ApiFilter(PropertyFilter::class)
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *          "amount": "partial",
 *          "currency": "exact",
 *          "tags": "partial",
 *          "note": "partial",
 *          "settlementAccount.name": "partial",
 *          "methodOfPayment.name": "partial",
 *          "subcategory.category.name": "partial",
 *          "subcategory.name": "partial"
 *     }
 * )
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
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
     * @Groups({"transaction:read", "transaction:write"})
     * @ORM\Column(type="decimal", precision=21, scale=8)
     */
    private $amount;

    /**
     * @Assert\NotBlank
     * @Assert\Valid()
     * @Groups({"transaction:read", "transaction:write"})
     * @ORM\ManyToOne(targetEntity=Currency::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $currency;

    /**
     * @Assert\NotBlank
     * @Groups({"transaction:read", "transaction:write"})
     * @ORM\Column(type="datetimetz")
     */
    private $addedAt;

    /**
     * @Assert\NotBlank
     * @Groups({"transaction:read", "transaction:write"})
     * @ORM\ManyToOne(targetEntity=Subcategory::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subcategory;

    /**
     * @Assert\Valid()
     * @Groups({"transaction:read", "transaction:write"})
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="transactions")
     */
    private $tags;

    /**
     * @Assert\Length(max=255)
     * @Groups({"transaction:read", "transaction:write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $note;

    /**
     * @Assert\NotBlank
     * @Assert\Valid()
     * @Groups({"transaction:read", "transaction:write"})
     * @ORM\ManyToOne(targetEntity=SettlementAccount::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $settlementAccount;

    /**
     * @Assert\Valid()
     * @Groups({"transaction:read", "transaction:write"})
     * @ORM\ManyToOne(targetEntity=MethodOfPayment::class, inversedBy="transactions")
     */
    private $methodOfPayment;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

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

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getAddedAt(): ?\DateTimeInterface
    {
        return $this->addedAt;
    }

    public function setAddedAt(\DateTimeInterface $addedAt): self
    {
        $this->addedAt = $addedAt;

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
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getSettlementAccount(): ?SettlementAccount
    {
        return $this->settlementAccount;
    }

    public function setSettlementAccount(?SettlementAccount $settlementAccount): self
    {
        $this->settlementAccount = $settlementAccount;

        return $this;
    }

    public function getMethodOfPayment(): ?MethodOfPayment
    {
        return $this->methodOfPayment;
    }

    public function setMethodOfPayment(?MethodOfPayment $methodOfPayment): self
    {
        $this->methodOfPayment = $methodOfPayment;

        return $this;
    }

    public function __toString(): String
    {
        return $this->id;
    }
}
