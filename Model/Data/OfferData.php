<?php
/**
 * Copyright (c) 2021 All Rights Reserved.
 * https://opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 * Julien_ManageOffers
 * Julien TRAJMAN <j.trajman@gmail.com> <@Julien0s>
 */

declare(strict_types=1);

namespace Julien\ManageOffers\Model\Data;

use Julien\ManageOffers\Api\Data\OfferInterface;
use Magento\Framework\DataObject;

class OfferData extends DataObject implements OfferInterface
{
    /**
     * Getter for OfferId.
     *
     * @return int|null
     */
    public function getOfferId(): ?int
    {
        return $this->getData(self::OFFER_ID) === null ? null
            : (int)$this->getData(self::OFFER_ID);
    }

    /**
     * Setter for OfferId.
     *
     * @param int|null $offerId
     *
     * @return void
     */
    public function setOfferId(?int $offerId): void
    {
        $this->setData(self::OFFER_ID, $offerId);
    }

    /**
     * Getter for IsActive.
     *
     * @return int|null
     */
    public function getIsActive(): ?int
    {
        return $this->getData(self::IS_ACTIVE) === null ? null
            : (int)$this->getData(self::IS_ACTIVE);
    }

    /**
     * Setter for IsActive.
     *
     * @param int|null $isActive
     *
     * @return void
     */
    public function setIsActive(?int $isActive): void
    {
        $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Getter for Name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /**
     * Setter for Name.
     *
     * @param string|null $name
     *
     * @return void
     */
    public function setName(?string $name): void
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * Getter for Link.
     *
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->getData(self::LINK);
    }

    /**
     * Setter for Link.
     *
     * @param string|null $link
     *
     * @return void
     */
    public function setLink(?string $link): void
    {
        $this->setData(self::LINK, $link);
    }

    /**
     * Getter for Categories.
     *
     * @return string|null
     */
    public function getCategories(): ?string
    {
        return $this->getData(self::CATEGORIES);
    }

    /**
     * Setter for Categories.
     *
     * @param string|null $categories
     *
     * @return void
     */
    public function setCategories(?string $categories): void
    {
        $this->setData(self::CATEGORIES, $categories);
    }

    /**
     * Getter for Image.
     *
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Setter for Image.
     *
     * @param string|null $image
     *
     * @return void
     */
    public function setImage(?string $image): void
    {
        $this->setData(self::IMAGE, $image);
    }

    /**
     * Getter for StartDate.
     *
     * @return string|null
     */
    public function getStartDate(): ?string
    {
        return $this->getData(self::START_DATE) === null ? null
            : (string)$this->getData(self::START_DATE);
    }

    /**
     * Setter for StartDate.
     *
     * @param string|null $startDate
     *
     * @return void
     */
    public function setStartDate(?string $startDate): void
    {
        $this->setData(self::START_DATE, $startDate);
    }

    /**
     * Getter for EndDate.
     *
     * @return string|null
     */
    public function getEndDate(): ?string
    {
        return $this->getData(self::END_DATE) === null ? null
            : (string)$this->getData(self::END_DATE);
    }

    /**
     * Setter for EndDate.
     *
     * @param string|null $endDate
     *
     * @return void
     */
    public function setEndDate(?string $endDate): void
    {
        $this->setData(self::END_DATE, $endDate);
    }
}
