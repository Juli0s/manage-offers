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
use Julien\ManageOffers\Model\OfferModel;
use Julien\ManageOffers\Model\OfferModelFactory;
use Julien\ManageOffers\Model\ResourceModel\OfferResource;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

/**
 * Delete Offer by id Command.
 */
class DeleteByIdCommand
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
     * Delete Offer.
     *
     * @param int $entityId
     *
     * @return void
     * @throws CouldNotDeleteException|NoSuchEntityException
     */
    public function execute(int $entityId)
    {
        try {
            /** @var OfferModel $model */
            $model = $this->modelFactory->create();
            $this->resource->load($model, $entityId, 'offer_id');

            if (!$model->getData('offer_id')) {
                throw new NoSuchEntityException(
                    __('Could not find Offer with id: `%id`', ['id' => $entityId])
                );
            }

            $this->resource->delete($model);
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not delete Offer. Original message: {message}'),
                [
                    'message'   => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            throw new CouldNotDeleteException(__('Could not delete Offer.'));
        }
    }
}
