<?php

namespace App\Entity;

use App\Repository\MethodOfPaymentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Icon::class)
     */
    private $iconId;

    /**
     * @ORM\ManyToOne(targetEntity=SettlementAccount::class, inversedBy="methodOfPayments")
     */
    private $settlementAccount;

    /**
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

    public function getIconId(): ?Icon
    {
        return $this->iconId;
    }

    public function setIconId(?Icon $iconId): self
    {
        $this->iconId = $iconId;

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
}
