<?php

declare(strict_types=1);

namespace Service;

use App\Repository\VisitorRepository;
use App\Repository\VisitRepositoryInterface;
use App\Service\VisitorService;
use App\Service\VisitorServiceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

/**
 * @internal
 *
 * @coversNothing
 */
class VisitorServiceTest extends TestCase
{
    private VisitRepositoryInterface $visitorRepositoryMock;

    private ParameterBagInterface $parameterBagMock;

    private TagAwareCacheInterface $cacheMock;

    private VisitorServiceInterface $service;

    private string $countryCodePath;

    protected function setUp(): void
    {
        $this->visitorRepositoryMock = $this->createMock(VisitorRepository::class);
        $this->parameterBagMock = $this->createMock(ParameterBagInterface::class);
        $this->cacheMock = $this->createMock(TagAwareCacheInterface::class);
        $this->countryCodePath = __DIR__.'/../_data/countries.yaml';
        $this->parameterBagMock->expects($this->any())
            ->method('get')
            ->willReturnMap([
                ['country-code-cache-key', 'country_codes'],
                ['country-code-cache-ttl', 3600],
                ['country-code-path', $this->countryCodePath],
            ])
        ;

        $this->service = new VisitorService($this->parameterBagMock, $this->visitorRepositoryMock, $this->cacheMock);
    }

    public function testInitCountryCodes(): void
    {
        $this->visitorRepositoryMock->expects($this->once())
            ->method('initCountryCodes')
            ->with($this->equalTo(['US', 'CA']))
        ;

        $this->cacheMock->expects($this->any())
            ->method('get')
            ->with(
                $this->equalTo('country_codes'),
                $this->callback(fn ($callback) => is_callable($callback))
            )
            ->willReturnCallback(function ($key, $callback) {
                return $callback($this->createMock(ItemInterface::class));
            })
        ;

        $this->assertFileExists($this->countryCodePath);
        $this->assertIsArray($this->service->getCountryCodes());
        $this->assertSame(['US', 'CA'], $this->service->getCountryCodes());

        $this->service->initCountryCodes();
    }

    public function testGetCountryCodes(): void
    {
        $this->cacheMock->expects($this->any())
            ->method('get')
            ->with(
                $this->equalTo('country_codes'),
                $this->callback(fn ($callback) => is_callable($callback))
            )
            ->willReturnCallback(function ($key, $callback) {
                return $callback($this->createMock(ItemInterface::class));
            })
        ;

        $this->assertFileExists($this->countryCodePath);
        $this->assertSame(['US', 'CA'], $this->service->getCountryCodes());
    }
}
