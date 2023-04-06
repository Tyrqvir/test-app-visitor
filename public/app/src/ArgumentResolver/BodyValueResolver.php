<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class BodyValueResolver implements ValueResolverInterface
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $type = $argument->getType();
        $format = $request->getContentTypeFormat() ?? JsonEncoder::FORMAT;
        $content = $request->getContent();

        yield $this->serializer->deserialize($content, $type, $format);
    }

    /**
     * {@inheritDoc}
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $attrs = $argument->getAttributes(Body::class);

        return \count($attrs) > 0;
    }
}
