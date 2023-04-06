<?php

declare(strict_types=1);

namespace App\Annotation;

enum HttpMethod
{
    case GET;

    case POST;

    case PATCH;

    case PUT;

    case DELETE;
}
