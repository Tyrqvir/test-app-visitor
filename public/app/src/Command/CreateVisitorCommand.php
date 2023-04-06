<?php

declare(strict_types=1);

namespace App\Command;

use App\Common\CQRS\Message\Contracts\CommandMessageInterface;
use App\Enum\SerializedGroup;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateVisitorCommand implements CommandMessageInterface
{
    public function __construct(
        #[Groups(SerializedGroup::CREATE)]
        #[Assert\Type('string')]
        #[Assert\Length(
            max: 2,
            maxMessage: 'Country code should have maximum 2 characters',
        )]
        private readonly string $countryCode,
    ) {
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }
}
