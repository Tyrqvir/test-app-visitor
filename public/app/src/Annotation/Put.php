<?php

declare(strict_types=1);

namespace App\Annotation;

use Attribute;
use Symfony\Component\Routing\Annotation\Route;

#[Attribute]
class Put extends Route
{
    public function getMethods(): array
    {
        return [HttpMethod::PUT->name];
    }
}
