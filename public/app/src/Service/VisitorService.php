<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\VisitorRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class VisitorService implements VisitorServiceInterface
{
    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
        private readonly VisitorRepository $visitorRepository,
        private readonly TagAwareCacheInterface $cache
    ) {
    }

    public function initCountryCodes(): void
    {
        $countryCode = $this->getCountryCodes();

        $this->visitorRepository->initCountryCodes($countryCode);
    }

    public function getCountryCodes(): array
    {
        $countryCodeCacheKey = $this->parameterBag->get('country-code-cache-key');

        $cachedCodes = $this->cache->get($countryCodeCacheKey, function (ItemInterface $item) {
            $item->expiresAfter($this->parameterBag->get('country-code-cache-ttl'));

            $yaml = file_get_contents($this->parameterBag->get('country-code-path'));

            return Yaml::parse($yaml);
        });

        return $cachedCodes ?? [];
    }
}
