<?php
/**
 * Copyright (c) 2021 All Rights Reserved.
 * https://opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 * Julien_ManageOffers
 * Julien TRAJMAN <j.trajman@gmail.com> <@Julien0s>
 */

declare(strict_types=1);

namespace Julien\ManageOffers\Model\ResourceModel\OfferModel;

use Julien\ManageOffers\Model\OfferModel;
use Julien\ManageOffers\Model\ResourceModel\OfferResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class OfferCollection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'offers_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(OfferModel::class, OfferResource::class);
    }
}
