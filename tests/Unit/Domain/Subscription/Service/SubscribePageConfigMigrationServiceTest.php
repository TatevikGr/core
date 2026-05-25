<?php

declare(strict_types=1);

namespace PhpList\Core\Tests\Unit\Domain\Subscription\Service;

use PhpList\Core\Domain\Configuration\Repository\ConfigRepository;
use PhpList\Core\Domain\Subscription\Model\SubscribePage;
use PhpList\Core\Domain\Subscription\Model\SubscribePageData;
use PhpList\Core\Domain\Subscription\Repository\SubscriberPageDataRepository;
use PhpList\Core\Domain\Subscription\Service\SubscribePageConfigMigrationService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SubscribePageConfigMigrationServiceTest extends TestCase
{
    private ConfigRepository|MockObject $configRepository;
    private SubscriberPageDataRepository|MockObject $pageDataRepository;
    private SubscribePageConfigMigrationService $service;

    protected function setUp(): void
    {
        $this->configRepository = $this->createMock(ConfigRepository::class);
        $this->pageDataRepository = $this->createMock(SubscriberPageDataRepository::class);
        $this->service = new SubscribePageConfigMigrationService(
            configRepository: $this->configRepository,
            pageDataRepository: $this->pageDataRepository,
        );
    }

    public function testCopyToPageDataSkipsPagesWithoutId(): void
    {
        $page = $this->getMockBuilder(SubscribePage::class)
            ->onlyMethods(['getId'])
            ->getMock();
        $page->method('getId')->willReturn(null);

        $this->configRepository
            ->expects($this->never())
            ->method('findValueByItem');

        $this->pageDataRepository
            ->expects($this->never())
            ->method('getByPage');

        $this->service->copyToPageData($page);
    }

    public function testCopyToPageDataSkipsWhenNoConfigValuesFound(): void
    {
        $page = $this->getMockBuilder(SubscribePage::class)
            ->onlyMethods(['getId'])
            ->getMock();
        $page->method('getId')->willReturn(1);

        $this->configRepository
            ->expects($this->exactly(5))
            ->method('findValueByItem')
            ->willReturn(null);

        $this->pageDataRepository
            ->expects($this->never())
            ->method('getByPage');

        $this->service->copyToPageData($page);
    }

    public function testCopyToPageDataAddsOnlyMissingDataEntries(): void
    {
        $page = $this->getMockBuilder(SubscribePage::class)
            ->onlyMethods(['getId', 'setData'])
            ->getMock();
        $page->method('getId')->willReturn(1);
        $page->method('setData')->willReturnSelf();

        $existing = (new SubscribePageData())
            ->setId(1)
            ->setName('confirmsubject')
            ->setData('existing intro');

        $this->configRepository
            ->expects($this->exactly(5))
            ->method('findValueByItem')
            ->willReturnMap([
                ['subscribemessage:1', 'message from config'],
                ['subscribesubject:1', null],
                ['confirmmessage:1', null],
                ['confirmsubject:1', null],
                ['confirmationmessage:1', null],
            ]);

        $this->pageDataRepository
            ->expects($this->once())
            ->method('getByPage')
            ->with($page)
            ->willReturn([$existing]);

        $this->pageDataRepository
            ->expects($this->once())
            ->method('persist')
            ->with($this->callback(static function (SubscribePageData $pageData): bool {
                return $pageData->getId() === 1
                    && $pageData->getName() === 'subscribemessage'
                    && $pageData->getData() === 'message from config';
            }));

        $page
            ->expects($this->once())
            ->method('setData')
            ->with($this->callback(static function (array $data): bool {
                if (count($data) !== 2) {
                    return false;
                }

                $dataByName = [];
                foreach ($data as $item) {
                    if (!$item instanceof SubscribePageData) {
                        return false;
                    }
                    $dataByName[$item->getName()] = $item->getData();
                }

                return isset($dataByName['confirmsubject'], $dataByName['subscribemessage'])
                    && $dataByName['confirmsubject'] === 'existing intro'
                    && $dataByName['subscribemessage'] === 'message from config';
            }))
            ->willReturnSelf();

        $this->service->copyToPageData($page);
    }
}
