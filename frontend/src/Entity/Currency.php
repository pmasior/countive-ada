<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CurrencyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get" = {
 *              "security" = "is_granted('ROLE_USER')"
 *          }
 *      },
 *     itemOperations={
 *          "get"={
 *              "security" = "is_granted('ROLE_USER')"
 *          }
 *     },
 *     normalizationContext={"groups"={"currency:read"}},
 *     denormalizationContext={"groups"={"currency:write"}},
 * )
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass=CurrencyRepository::class)
 */
class Currency
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(min=3, max=3)
     * @Assert\NotBlank
     * @Groups({"currency:read"})
     * @ORM\Column(type="string", length=3)
     */
    private $shortName;

    /**
     * @Assert\Length(max=255)
     * @Assert\NotBlank
     * @Groups({"currency:read"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
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

    public function __toString(): String
    {
        return $this->id;
    }
}
