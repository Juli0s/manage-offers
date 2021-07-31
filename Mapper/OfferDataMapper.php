<?php
/**
 * Copyright (c) 2021 All Rights Reserved.
 * https://opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 * Julien_ManageOffers
 * Julien TRAJMAN <j.trajman@gmail.com> <@Julien0s>
 */

declare(strict_types=1);

namespace Julien\ManageOffers\Mapper;

use Julien\ManageOffers\Api\Data\OfferInterface;
use Julien\ManageOffers\Api\Data\OfferInterfaceFactory;
use Julien\ManageOffers\Model\OfferModel;
use Magento\Framework\DataObject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Converts a collection of Offer entities to an array of data transfer objects.
 */
class OfferDataMapper
{
    /**
     * @var OfferInterfaceFactory
     */
    private $entityDtoFactory;

    /**
     * @param OfferInterfaceFactory $entityDtoFactory
     */
    public function __construct(
        OfferInterfaceFactory $entityDtoFactory
    ) {
        $this->entityDtoFactory = $entityDtoFactory;
    }

    /**
     * Map magento models to DTO array.
     *
     * @param AbstractCollection $collection
     *
     * @return array|OfferInterface[]
     */
    public function map(AbstractCollection $collection): array
    {
        $results = [];
        /** @var OfferModel $item */
        foreach ($collection->getItems() as $item) {
            /** @var OfferInterface|DataObject $entityDto */
            $entityDto = $this->entityDtoFactory->create();
            $entityDto->addData($item->getData());

            $results[] = $entityDto;
        }

        return $results;
    }
}
