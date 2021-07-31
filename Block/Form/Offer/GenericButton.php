<?php
/**
 * Copyright (c) 2021 All Rights Reserved.
 * https://opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 * Julien_ManageOffers
 * Julien TRAJMAN <j.trajman@gmail.com> <@Julien0s>
 */

declare(strict_types=1);

namespace Julien\ManageOffers\Block\Form\Offer;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\UrlInterface;

/**
 * Generic (form) button for Offer entity.
 */
class GenericButton
{
    /**
     * @var Context
     */
    private $context;
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
        $this->urlBuilder = $context->getUrlBuilder();
    }

    /**
     * Get Offer entity id.
     *
     * @return int
     */
    public function getOfferId(): int
    {
        return (int)$this->context->getRequest()->getParam('offer_id');
    }

    /**
     * Wrap button specific options to settings array.
     *
     * @param string $label
     * @param string $class
     * @param string $onclick
     * @param array $dataAttribute
     * @param int $sortOrder
     *
     * @return array
     */
    protected function wrapButtonSettings(
        string $label,
        string $class,
        string $onclick = '',
        array $dataAttribute = [],
        int $sortOrder = 0
    ): array {
        return [
            'label'          => __($label),
            'on_click'       => $onclick,
            'data_attribute' => $dataAttribute,
            'class'          => $class,
            'sort_order'     => $sortOrder
        ];
    }

    /**
     * Get url.
     *
     * @param string $route
     * @param array $params
     *
     * @return string
     */
    protected function getUrl(string $route, array $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
