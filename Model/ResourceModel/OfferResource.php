<?php
/**
 * Copyright (c) 2021 All Rights Reserved.
 * https://opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 * Julien_ManageOffers
 * Julien TRAJMAN <j.trajman@gmail.com> <@Julien0s>
 */

declare(strict_types=1);

namespace Julien\ManageOffers\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class OfferResource extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'offers_resource_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('offer', 'offer_id');
        $this->_useIsObjectNew = true;
    }
}
