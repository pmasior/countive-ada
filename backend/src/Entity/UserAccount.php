<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserAccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     securityMessage="Only owner can perform this operation.",
 *     collectionOperations={
 *          "post" = {
 *              "security" = "is_granted('IS_AUTHENTICATED_ANONYMOUSLY')",
 *              "validation_groups" = {"Default", "user:create"}
 *          }
 *     },
 *     itemOperations={
 *          "get" = {
 *              "security" = "is_granted('ROLE_USER') and object == user"
 *          },
 *          "put" = {
 *              "security" = "is_granted('ROLE_USER') and object == user"
 *          },
 *          "delete" = {
 *              "security" = "is_granted('ROLE_USER') and object == user"
 *          }
 *     },
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}},
 *     shortName="users"
 * )
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass=UserAccountRepository::class)
 * @UniqueEntity("email")
 */
class UserAccount implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Email()
     * @Assert\Length(max=180)
     * @Assert\NotBlank
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @Assert\Length(max=255)
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank(groups={"user:create"})
     * @Groups({"user:write"})
     * @SerializedName("password")
     */
    private $plainPassword;


    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="userAccount", orphanRemoval=true)
     */
    private $categories;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\OneToMany(targetEntity=SettlementAccount::class, mappedBy="userAccount", orphanRemoval=true)
     */
    private $settlementAccounts;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->settlementAccounts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
         $this->plainPassword = null;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setUserAccount($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getUserAccount() === $this) {
                $category->setUserAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SettlementAccount[]
     */
    public function getSettlementAccounts(): Collection
    {
        return $this->settlementAccounts;
    }

    public function addSettlementAccount(SettlementAccount $settlementAccount): self
    {
        if (!$this->settlementAccounts->contains($settlementAccount)) {
            $this->settlementAccounts[] = $settlementAccount;
            $settlementAccount->setUserAccount($this);
        }

        return $this;
    }

    public function removeSettlementAccount(SettlementAccount $settlementAccount): self
    {
        if ($this->settlementAccounts->removeElement($settlementAccount)) {
            // set the owning side to null (unless already changed)
            if ($settlementAccount->getUserAccount() === $this) {
                $settlementAccount->setUserAccount(null);
            }
        }

        return $this;
    }

    public function __toString(): String
    {
        return $this->id;
    }
}
