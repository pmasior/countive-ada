<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SettlementAccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettlementAccountRepository::class)
 * @ApiResource()
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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $color;

    /**
     * @ORM\ManyToOne(targetEntity=UserAccount::class, inversedBy="settlementAccounts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userAccount;

    /**
     * @ORM\OneToMany(targetEntity=MethodOfPayment::class, mappedBy="settlementAccount")
     */
    private $methodOfPayments;

    /**
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
