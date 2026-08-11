<?php
declare(strict_types = 1);
namespace App\Infrastructure\Resource;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource]
final class Building
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    public ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    public string $name = '';

    #[ORM\Column]
    #[Assert\NotBlank]
    public string $address = '';

    #[ORM\Embedded(class: ConstructionProgress::class, columnPrefix: 'finish_')]
    #[Assert\Valid]
    public ConstructionProgress $constructionProgress;
}
