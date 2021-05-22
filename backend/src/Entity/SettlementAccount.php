<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SettlementAccountRepository;
use App\Validator\IsValidOwner;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
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
 *              "security" = "is_granted('ROLE_USER') and object.getUserAccount() == user"
 *          },
 *          "put" = {
 *              "security" = "is_granted('ROLE_USER') and object.getUserAccount() == user"
 *          },
 *          "patch" = {
 *              "security" = "is_granted('ROLE_USER') and object.getUserAccount() == user"
 *          },
 *          "delete" = {
 *              "security" = "is_granted('ROLE_USER') and object.getUserAccount() == user"
 *          }
 *     },
 *     normalizationContext={"groups"={"settlementAccount:read"}},
 *     denormalizationContext={"groups"={"settlementAccount:write"}},
 * )
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass=SettlementAccountRepository::class)
 */
class SettlementAccount
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(max=255)
     * @Assert\NotBlank
     * @Groups({"settlementAccount:read", "settlementAccount:write"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\Length(max=25)
     * @Assert\NotBlank
     * @Groups({"settlementAccount:read", "settlementAccount:write"})
     * @ORM\Column(type="string", length=25)
     */
    private $color;

    /**
     * @Assert\Valid()
     * @IsValidOwner()
     * @Groups({"settlementAccount:read", "settlementAccount:write"})
     * @ORM\ManyToOne(targetEntity=UserAccount::class, inversedBy="settlementAccounts")
     * @ORM\JoinColumn(nullable=false)
     * @SerializedName("user")
     */
    private $userAccount;

    /**
     * @Assert\Valid()
     * @Groups({"settlementAccount:read", "settlementAccount:write"})
     * @ORM\OneToMany(targetEntity=MethodOfPayment::class, mappedBy="settlementAccount")
     */
    private $methodOfPayments;

    /**
     * @Assert\Valid()
     * @Groups({"settlementAccount:read", "settlementAccount:write"})
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="settlementAccount", orphanRemoval=true)
     */
    private $transactions;

    public function __construct()
    {
        $this->methodOfPayments = new ArrayCollection();
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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

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
     * @return Collection|MethodOfPayment[]
     */
    public function getMethodOfPayments(): Collection
    {
        return $this->methodOfPayments;
    }

    public function addMethodOfPayment(MethodOfPayment $methodOfPayment): self
    {
        if (!$this->methodOfPayments->contains($methodOfPayment)) {
            $this->methodOfPayments[] = $methodOfPayment;
            $methodOfPayment->setSettlementAccount($this);
        }

        return $this;
    }

    public function removeMethodOfPayment(MethodOfPayment $methodOfPayment): self
    {
        if ($this->methodOfPayments->removeElement($methodOfPayment)) {
            // set the owning side to null (unless already changed)
            if ($methodOfPayment->getSettlementAccount() === $this) {
                $methodOfPayment->setSettlementAccount(null);
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
            $transaction->setSettlementAccount($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getSettlementAccount() === $this) {
                $transaction->setSettlementAccount(null);
            }
        }

        return $this;
    }

    public function __toString(): String
    {
        return $this->id;
    }
}
