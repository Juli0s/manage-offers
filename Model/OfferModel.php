<?php
/**
 * Copyright (c) 2021 All Rights Reserved.
 * https://opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 * Julien_ManageOffers
 * Julien TRAJMAN <j.trajman@gmail.com> <@Julien0s>
 */

declare(strict_types=1);

namespace Julien\ManageOffers\Model;

use Julien\ManageOffers\Model\ResourceModel\OfferResource;
use Magento\Framework\Model\AbstractModel;

class OfferModel extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'offers_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(OfferResource::class);
    }
}
