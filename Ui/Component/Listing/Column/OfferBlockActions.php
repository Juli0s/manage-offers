<?php
/**
 * Copyright (c) 2021 All Rights Reserved.
 * https://opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 * Julien_ManageOffers
 * Julien TRAJMAN <j.trajman@gmail.com> <@Julien0s>
 */

declare(strict_types=1);

namespace Julien\ManageOffers\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class to build edit and delete link for each item.
 */
class OfferBlockActions extends Column
{
    /**
     * Entity name.
     */
    private const ENTITY_NAME = 'Offer';
    /**
     * Url paths.
     * #@+
     */
    private const EDIT_URL_PATH = 'offer/offer/edit';
    private const DELETE_URL_PATH = 'offer/offer/delete';
    /** #@- */

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct(
            $context,
            $uiComponentFactory,
            $components,
            $data
        );
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['offer_id'])) {
                    $entityName = static::ENTITY_NAME;
                    $urlData = ['offer_id' => $item['offer_id']];

                    $editUrl = $this->urlBuilder->getUrl(static::EDIT_URL_PATH, $urlData);
                    $deleteUrl = $this->urlBuilder->getUrl(static::DELETE_URL_PATH, $urlData);

                    $item[$this->getData('name')] = [
                        'edit'   => $this->getActionData($editUrl, (string)__('Edit')),
                        'delete' => $this->getActionData(
                            $deleteUrl,
                            (string)__('Delete'),
                            (string)__('Delete %1', $entityName),
                            (string)__('Are you sure you want to delete a %1 record?', $entityName)
                        )
                    ];
                }
            }
        }

        return $dataSource;
    }

    /**
     * Get action link data array.
     *
     * @param string $url
     * @param string $label
     * @param string|null $dialogTitle
     * @param string|null $dialogMessage
     *
     * @return array
     */
    private function getActionData(
        string $url,
        string $label,
        ?string $dialogTitle = null,
        ?string $dialogMessage = null
    ): array {
        $data = [
            'href'          => $url,
            'label'         => $label,
            'post'          => true,
            '__disableTmpl' => true
        ];

        if ($dialogTitle && $dialogMessage) {
            $data['confirm'] = [
                'title'   => $dialogTitle,
                'message' => $dialogMessage
            ];
        }

        return $data;
    }
}
