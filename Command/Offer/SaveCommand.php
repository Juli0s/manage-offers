<?php
/**
 * Copyright (c) 2021 All Rights Reserved.
 * https://opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 * Julien_ManageOffers
 * Julien TRAJMAN <j.trajman@gmail.com> <@Julien0s>
 */

declare(strict_types=1);

namespace Julien\ManageOffers\Command\Offer;

use Exception;
use Julien\ManageOffers\Api\Data\OfferInterface;
use Julien\ManageOffers\Model\OfferModel;
use Julien\ManageOffers\Model\OfferModelFactory;
use Julien\ManageOffers\Model\ResourceModel\OfferResource;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;

/**
 * Save Offer Command.
 */
class SaveCommand
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var OfferModelFactory
     */
    private $modelFactory;
    /**
     * @var OfferResource
     */
    private $resource;

    /**
     * @param LoggerInterface $logger
     * @param OfferModelFactory $modelFactory
     * @param OfferResource $resource
     */
    public function __construct(
        LoggerInterface $logger,
        OfferModelFactory $modelFactory,
        OfferResource $resource
    ) {
        $this->logger = $logger;
        $this->modelFactory = $modelFactory;
        $this->resource = $resource;
    }

    /**
     * Save Offer.
     *
     * @param OfferInterface|DataObject $offer
     *
     * @return int
     * @throws CouldNotSaveException
     */
    public function execute($offer): int
    {
        try {
            /** @var OfferModel $model */
            $model = $this->modelFactory->create();
            $model->addData($offer->getData());
            $model->setHasDataChanges(true);

            if (!$model->getId()) {
                $model->isObjectNew(true);
            }
            $this->resource->save($model);
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not save Offer. Original message: {message}'),
                [
                    'message'   => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            throw new CouldNotSaveException(__('Could not save Offer.'));
        }

        return (int)$model->getEntityId();
    }
}
