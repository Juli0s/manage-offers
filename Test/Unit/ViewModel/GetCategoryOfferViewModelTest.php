<?php
/**
 * Copyright (c) 2021 All Rights Reserved.
 * https://opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 * Julien_ManageOffers
 * Julien TRAJMAN <j.trajman@gmail.com> <@Julien0s>
 */

declare(strict_types=1);

namespace Julien\ManageOffers\Test\Unit\ViewModel;

use Julien\ManageOffers\Model\Data\OfferData;
use Julien\ManageOffers\Model\OfferModel;
use Julien\ManageOffers\Model\ResourceModel\OfferResource;
use Magento\Framework\Model\Context;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetCategoryOfferViewModelTest extends TestCase
{
    /**
     * @var OfferData|MockObject
     */
    private $offerData;
    /**
     * @var ObjectManager
     */
    private $objectManager;
    /**
     * @var OfferResource|mixed|MockObject
     */
    private $resourceMock;
    /**
     * @var Context|mixed|MockObject
     */
    private $contextMock;

    /**
     *
     */
    protected function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);
        $this->resourceMock = $this->createMock(OfferResource::class);
        $this->contextMock = $this->createMock(Context::class);

        $this->offerData = $this->objectManager->getObject(
            OfferData::class,
            [
                'context'  => $this->contextMock,
                'resource' => $this->resourceMock,
            ]
        );
    }

    /**
     * Test offer Id
     */
    public function testOfferId()
    {
        $offerId = '8';

        $this->offerData->setData(OfferData::OFFER_ID, $offerId);

        $expected = $offerId;
        $actual = $this->offerData->getOfferId();
        self::assertEquals($expected, $actual);
    }

    /**
     * Test offer name
     */
    public function testOfferName()
    {
        $name = 'Test name';

        $this->offerData->setData(OfferData::NAME, $name);

        $expected = $name;
        $actual = $this->offerData->getName();
        self::assertEquals($expected, $actual);
    }

    /**
     * test offer is active
     */
    public function testIsActive()
    {
        $isActive = 1;

        $this->offerData->setData(OfferData::IS_ACTIVE, $isActive);

        $expected = $isActive;
        $actual = $this->offerData->getIsActive();
        self::assertEquals($expected, $actual);
    }

    /**
     * Test offer Link
     */
    public function testLink()
    {
        $link = 'https://www.magento.com';

        $this->offerData->setData(OfferData::LINK, $link);

        $expected = $link;
        $actual = $this->offerData->getLink();
        self::assertEquals($expected, $actual);
    }

    /**
     * test offer Categories
     */
    public function testCategories()
    {
        $categoriesId = '7,5';

        $this->offerData->setData(OfferData::CATEGORIES, $categoriesId);

        $expected = $categoriesId;
        $actual = $this->offerData->getCategories();
        self::assertEquals($expected, $actual);
    }

    /**
     * test offer Start Date
     */
    public function testStartDate()
    {
        $startDate = '2021-07-12';

        $this->offerData->setData(OfferData::START_DATE, $startDate);

        $expected = $startDate;
        $actual = $this->offerData->getStartDate();
        self::assertEquals($expected, $actual);
    }

    /**
     * Test end Date
     */
    public function testEndDate()
    {
        $endDate = '2021-08-01';

        $this->offerData->setData(OfferData::END_DATE, $endDate);

        $expected = $endDate;
        $actual = $this->offerData->getEndDate();
        self::assertEquals($expected, $actual);
    }
}
