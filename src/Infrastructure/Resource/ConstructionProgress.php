<?php
declare(strict_types = 1);
namespace App\Infrastructure\Resource;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
final class ConstructionProgress
{
    #[ORM\Column]
    #[Assert\Range(min: 1, max: 4)]
    #[Assert\NotNull]
    public ?int $quarter = null;

    #[ORM\Column]
    #[Assert\GreaterThan(2020)]
    #[Assert\NotNull]
    public ?int $year = null;
}
