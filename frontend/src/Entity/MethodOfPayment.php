<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MethodOfPaymentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
 *              "security" = "is_granted('ROLE_USER') and object.getSettlementAccount().getUserAccount() == user"
 *          },
 *          "put" = {
 *              "security" = "is_granted('ROLE_USER') and object.getSettlementAccount().getUserAccount() == user"
 *          },
 *          "patch" = {
 *              "security" = "is_granted('ROLE_USER') and object.getSettlementAccount().getUserAccount() == user"
 *          },
 *          "delete" = {
 *              "security" = "is_granted('ROLE_USER') and object.getSettlementAccount().getUserAccount() == user"
 *          }
 *     },
 *     normalizationContext={"groups"={"methodOfPayment:read"}},
 *     denormalizationContext={"groups"={"methodOfPayment:write"}},
 * )
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass=MethodOfPaymentRepository::class)
 */
class MethodOfPayment
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
     * @Groups({"methodOfPayment:read", "methodOfPayment:write"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\Valid()
     * @Groups({"methodOfPayment:read", "methodOfPayment:write"})
     * @ORM\ManyToOne(targetEntity=Icon::class)
     */
    private $icon;

    /**
     * @Assert\Valid()
     * @Groups({"methodOfPayment:read", "methodOfPayment:write"})
     * @ORM\ManyToOne(targetEntity=SettlementAccount::class, inversedBy="methodOfPayments")
     */
    private $settlementAccount;

    /**
     * @Assert\Valid()
     * @Groups({"methodOfPayment:read", "methodOfPayment:write"})
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="methodOfPayment")
     */
    private $transactions;

    public function __construct()
    {
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

    public function getSettlementAccount(): ?SettlementAccount
    {
        return $this->settlementAccount;
    }

    public function setSettlementAccount(?SettlementAccount $settlementAccount): self
    {
        $this->settlementAccount = $settlementAccount;

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
            $transaction->setMethodOfPayment($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getMethodOfPayment() === $this) {
                $transaction->setMethodOfPayment(null);
            }
        }

        return $this;
    }

    public function __toString(): String
    {
        return $this->id;
    }
}
