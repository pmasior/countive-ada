<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TagRepository;
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
 *     normalizationContext={"groups"={"tag:read"}},
 *     denormalizationContext={"groups"={"tag:write"}},
 * )
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(max=25)
     * @Assert\NotBlank()
     * @Groups({"tag:read", "tag:write"})
     * @ORM\Column(type="string", length=25)
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @Groups({"tag:read", "tag:write"})
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="tags")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @Assert\Valid()
     * @Groups({"tag:read", "tag:write"})
     * @ORM\ManyToMany(targetEntity=Transaction::class, mappedBy="tags")
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
            $transaction->addTag($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            $transaction->removeTag($this);
        }

        return $this;
    }

    public function __toString(): String
    {
        return $this->id;
    }
}
