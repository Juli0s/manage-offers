<?php
/**
 * Copyright (c) 2021 All Rights Reserved.
 * https://opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 * Julien_ManageOffers
 * Julien TRAJMAN <j.trajman@gmail.com> <@Julien0s>
 */

declare(strict_types=1);

namespace Julien\ManageOffers\Ui\DataProvider;

use Julien\ManageOffers\Query\Offer\GetListQuery;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\SearchResultFactory;

/**
 * DataProvider component.
 */
class OfferDataProvider extends DataProvider
{
    /**
     * @var GetListQuery
     */
    private $getListQuery;
    /**
     * @var SearchResultFactory
     */
    private $searchResultFactory;
    /**
     * @var array
     */
    private $loadedData = [];
    /**
     * @var Filesystem\Directory\WriteInterface
     */
    private $filesystem;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ReportingInterface $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param GetListQuery $getListQuery
     * @param SearchResultFactory $searchResultFactory
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     * @throws FileSystemException
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        GetListQuery $getListQuery,
        SearchResultFactory $searchResultFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        $this->getListQuery = $getListQuery;
        $this->searchResultFactory = $searchResultFactory;
        $this->filesystem = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritDoc
     */
    public function getSearchResult()
    {
        $searchCriteria = $this->getSearchCriteria();
        $result = $this->getListQuery->execute($searchCriteria);

        return $this->searchResultFactory->create(
            $result->getItems(),
            $result->getTotalCount(),
            $searchCriteria,
            'offer_id'
        );
    }

    /**
     * Get data.
     *
     * @return array
     */
    public function getData(): array
    {
        if ($this->loadedData) {
            return $this->loadedData;
        }

        $this->loadedData = parent::getData();
        $itemsById = [];
        $imageArray = [];
        $categoryArray = [];
        foreach ($this->loadedData['items'] as $i => &$item) {
            $image = $item['image'];
            $imageArray[$i] = $image;
            if ($image) {
                unset($item['image']);
                $item['image'][0]['type'] = 'image';
                $item['image'][0]['name'] = $item['name'];
                $item['image'][0]['url'] = $image;
                $item['image'][0]['size'] = $this->getFileSize($image);
            }

            $categories = $item['categories'];
            $categoryArray[$i] = $categories;
            if ($categories !== '') {
                $j = 0;
                unset($item['categories']);
                foreach (explode(',', $categories) as $category) {
                    $item['categories'][$j] = $category;
                    $j++;
                }
            }
            $itemsById[(int)$item['offer_id']] = $item;
        }

        $id = $this->request->getParam('offer_id', null);
        if ($id) {
            $imageArray = [];
            $categoryArray = [];
            $this->loadedData['entity'] = $itemsById[(int)$id];
        }

        foreach ($imageArray as $key => $value) {
            $this->loadedData['items'][$key]['image'] = $value;
        }

        foreach ($categoryArray as $key => $value) {
            $this->loadedData['items'][$key]['categories'] = $value;
        }

        return $this->loadedData;
    }

    /**
     * @param $file
     * @return mixed
     * @throws NoSuchEntityException
     */
    private function getFileSize($file)
    {
        $store = $this->storeManager->getStore();

        $filePath = str_replace(
            $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA),
            '',
            $file
        );

        return $this->filesystem->stat($filePath)['size'];
    }
}
