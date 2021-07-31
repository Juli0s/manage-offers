<?php
/**
 * Copyright (c) 2021 All Rights Reserved.
 * https://opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 * Julien_ManageOffers
 * Julien TRAJMAN <j.trajman@gmail.com> <@Julien0s>
 */

declare(strict_types=1);

namespace Julien\ManageOffers\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class ImageOffer extends Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$fieldName . '_src'] = $item['image'] ?: '';
                $item[$fieldName . '_alt'] = $item['image'] ? $item['name'] : '';
                $item[$fieldName . '_link'] = $item['image'] ? $item['link'] : '';
            }
        }

        return $dataSource;
    }
}
