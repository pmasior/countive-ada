<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\IconRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get" = {
 *              "security" = "is_granted('IS_AUTHENTICATED_ANONYMOUSLY')"
 *          }
 *      },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"category:read", "category:item:get"}},
 *              "security" = "is_granted('IS_AUTHENTICATED_ANONYMOUSLY')"
 *          }
 *     },
 *     normalizationContext={"groups"={"icon:read"}},
 *     denormalizationContext={"groups"={"icon:write"}},
 * )
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass=IconRepository::class)
 */
class Icon
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
     * @Groups({"icon:read"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

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

    public function __toString(): String
    {
        return $this->id;
    }
}
