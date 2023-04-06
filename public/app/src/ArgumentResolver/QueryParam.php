<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use Attribute;
use JetBrains\PhpStorm\Pure;
use Stringable;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class QueryParam implements Stringable
{
    public function __construct(private ?string $name = null, private bool $required = false)
    {
    }

    #[Pure]
 public function __toString(): string
 {
     return "QueryParam[name='".$this->getName()."', required='".$this->isRequired()."']";
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

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }
}
