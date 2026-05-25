<?php

declare(strict_types=1);

namespace PhpList\Core\Domain\Subscription\Service;

use PhpList\Core\Domain\Configuration\Repository\ConfigRepository;
use PhpList\Core\Domain\Subscription\Model\SubscribePage;
use PhpList\Core\Domain\Subscription\Model\SubscribePageData;
use PhpList\Core\Domain\Subscription\Repository\SubscriberPageDataRepository;

class SubscribePageConfigMigrationService
{
    public function __construct(
        private readonly ConfigRepository $configRepository,
        private readonly SubscriberPageDataRepository $pageDataRepository,
    ) {
    }

    private const SUBSCRIBE_PAGE_SUFFIXES = [
        'subscribemessage',
        'subscribesubject',
        'confirmmessage',
        'confirmsubject',
        'confirmationmessage',
    ];

    public function copyToPageData(SubscribePage $page): void
    {
        $pageId = $page->getId();
        if ($pageId === null) {
            return;
        }

        $configValues = [];
        foreach (self::SUBSCRIBE_PAGE_SUFFIXES as $suffix) {
            $value = $this->configRepository->findValueByItem($suffix . ':' . $pageId);
            if ($value === null) {
                continue;
            }
            $configValues[$suffix] = $value;
        }

        if ($configValues === []) {
            return;
        }

        $existingData = $this->pageDataRepository->getByPage($page);
        $existingNames = [];
        foreach ($existingData as $pageData) {
            $existingNames[$pageData->getName()] = true;
        }

        $updatedData = $existingData;
        foreach ($configValues as $name => $value) {
            if (isset($existingNames[$name])) {
                continue;
            }

            $newPageData = (new SubscribePageData())
                ->setId($pageId)
                ->setName($name)
                ->setData($value);

            $this->pageDataRepository->persist($newPageData);
            $updatedData[] = $newPageData;
        }

        $page->setData($updatedData);
    }

    public function copyToConfig(SubscribePage $page, array $data): void
    {
    }
}
