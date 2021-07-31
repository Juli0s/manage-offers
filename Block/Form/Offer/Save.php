<?php
/**
 * Copyright (c) 2021 All Rights Reserved.
 * https://opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 * Julien_ManageOffers
 * Julien TRAJMAN <j.trajman@gmail.com> <@Julien0s>
 */

declare(strict_types=1);

namespace Julien\ManageOffers\Block\Form\Offer;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Save entity button.
 */
class Save extends GenericButton implements ButtonProviderInterface
{
    /**
     * Retrieve Save button settings.
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return $this->wrapButtonSettings(
            'Save',
            'save primary',
            '',
            [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save'
            ],
            10
        );
    }
}
