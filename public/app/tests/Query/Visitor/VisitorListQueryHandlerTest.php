<?php

declare(strict_types=1);

namespace App\Tests\Query\Visitor;

use App\Message\Query\Visitor\VisitorListQuery;
use App\Message\Query\Visitor\VisitorListQueryHandler;
use App\Repository\VisitRepositoryInterface;
use App\Service\VisitorService;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class VisitorListQueryHandlerTest extends TestCase
{
    protected function setUp(): void
    {
        $this->visitRepository = $this->createMock(VisitRepositoryInterface::class);
        $this->visitorServiceMock = $this->createMock(VisitorService::class);
        $this->handler = new VisitorListQueryHandler($this->visitRepository, $this->visitorServiceMock);
    }

    public function testCommandHandler(): void
    {
        $countryCodes = ['US', 'GB', 'CA'];
        $expectedResult = [
            'US' => 10,
            'GB' => 5,
            'CA' => 3,
        ];

        $this->visitRepository->expects($this->once())
            ->method('findValueByCodes')
            ->with($countryCodes)
            ->willReturn(new \ArrayIterator([10, 5, 3]))
        ;

        $this->visitorServiceMock->expects($this->once())
            ->method('getCountryCodes')
            ->willReturn($countryCodes)
        ;

        $handler = new VisitorListQueryHandler($this->visitRepository, $this->visitorServiceMock);

        $result = $handler(new VisitorListQuery());

        $this->assertSame($expectedResult, $result);
    }
}
