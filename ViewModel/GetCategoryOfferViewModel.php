<?php
/**
 * Copyright (c) 2021 All Rights Reserved.
 * https://opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 * Julien_ManageOffers
 * Julien TRAJMAN <j.trajman@gmail.com> <@Julien0s>
 */

declare(strict_types=1);

namespace Julien\ManageOffers\ViewModel;

use IntlDateFormatter;
use Julien\ManageOffers\Model\ResourceModel\OfferModel\OfferCollection;
use Julien\ManageOffers\Model\ResourceModel\OfferModel\OfferCollectionFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class GetCategoryOfferViewModel implements ArgumentInterface
{
    /**
     * @var
     */
    private $offers;
    /**
     * @var OfferCollectionFactory
     */
    private $offerCollectionFactory;
    /**
     * @var int
     */
    private $categoryId;
    /**
     * @var TimezoneInterface
     */
    private $timezone;

    /**
     * @param OfferCollectionFactory $offerCollectionFactory
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        OfferCollectionFactory $offerCollectionFactory,
        TimezoneInterface $timezone
    ) {
        $this->offerCollectionFactory = $offerCollectionFactory;
        $this->timezone = $timezone;
    }

    /**
     * @param $category
     * @return array
     */
    public function getBlockAllowed($category): array
    {
        $this->categoryId = $category->getId();
        if (!$category->getId()) {
            return [];
        }

        if (!$this->getOffers()) {
            return [];
        }

        $allowed = [];
        foreach ($this->offers as $key => $offer) {
            if (!$offer->getIsActive()) {
                $this->offers->removeItemByKey($key);
                continue;
            }
            $today = $this->timezone->date()->getTimestamp();
            $startDateTimeStamp = $today-1;
            $endDateTimeStamp = $today+1;
            if ($offer->getStartDate()) {
                $startDate = $this->timezone->formatDateTime(
                    $offer->getStartDate(),
                    IntlDateFormatter::SHORT,
                    IntlDateFormatter::NONE,
                    null,
                    true
                );
                $startDateTimeStamp = $this->timezone->date($startDate)->getTimestamp();
            }
            if ($offer->getEndDate()) {
                $endDate = $this->timezone->formatDateTime(
                    $offer->getEndDate(),
                    IntlDateFormatter::SHORT,
                    IntlDateFormatter::NONE,
                    null,
                    true
                );
                $endDateTimeStamp = $this->timezone->date($endDate)->getTimestamp();
            }

            if ($startDateTimeStamp > $today || $endDateTimeStamp < $today) {
                $this->offers->removeItemByKey($key);
                continue;
            }

            $allowed[] = $offer;
        }

        return $allowed;
    }

    private function getOffers()
    {
        if (!$this->offers) {
            /** @var OfferCollection $collection */
            $collection = $this->offerCollectionFactory->create();
            $collection->addFieldToFilter('categories', [
                ['eq' => $this->categoryId],
                ['like' => '%,' . $this->categoryId],
                ['like' => '%' . $this->categoryId . ',%'],
            ]);
            $this->offers = $collection;
        }

        return $this->offers;
    }

    public function getOffersData()
    {
        $offersData = [];
        if ($this->offers) {
            foreach ($this->offers as $offer) {
                $offersData[] = $offer->getData();
            }
        }

        return $offersData;
    }
}
