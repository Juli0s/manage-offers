<?php
/**
 * Copyright (c) 2021 All Rights Reserved.
 * https://opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 * Julien_ManageOffers
 * Julien TRAJMAN <j.trajman@gmail.com> <@Julien0s>
 */

declare(strict_types=1);

namespace Julien\ManageOffers\Api\Data;

interface OfferInterface
{
    /**
     * String constants for property names
     */
    const OFFER_ID = "offer_id";
    const IS_ACTIVE = "is_active";
    const NAME = "name";
    const LINK = "link";
    const CATEGORIES = "categories";
    const IMAGE = "image";
    const START_DATE = "start_date";
    const END_DATE = "end_date";

    /**
     * Getter for OfferId.
     *
     * @return int|null
     */
    public function getOfferId(): ?int;

    /**
     * Setter for OfferId.
     *
     * @param int|null $offerId
     *
     * @return void
     */
    public function setOfferId(?int $offerId): void;

    /**
     * Getter for IsActive.
     *
     * @return int|null
     */
    public function getIsActive(): ?int;

    /**
     * Setter for IsActive.
     *
     * @param int|null $isActive
     *
     * @return void
     */
    public function setIsActive(?int $isActive): void;

    /**
     * Getter for Name.
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Setter for Name.
     *
     * @param string|null $name
     *
     * @return void
     */
    public function setName(?string $name): void;

    /**
     * Getter for Link.
     *
     * @return string|null
     */
    public function getLink(): ?string;

    /**
     * Setter for Link.
     *
     * @param string|null $link
     *
     * @return void
     */
    public function setLink(?string $link): void;

    /**
     * Getter for Categories.
     *
     * @return string|null
     */
    public function getCategories(): ?string;

    /**
     * Setter for Categories.
     *
     * @param string|null $categories
     *
     * @return void
     */
    public function setCategories(?string $categories): void;

    /**
     * Getter for Image.
     *
     * @return string|null
     */
    public function getImage(): ?string;

    /**
     * Setter for Image.
     *
     * @param string|null $image
     *
     * @return void
     */
    public function setImage(?string $image): void;

    /**
     * Getter for StartDate.
     *
     * @return string|null
     */
    public function getStartDate(): ?string;

    /**
     * Setter for StartDate.
     *
     * @param string|null $startDate
     *
     * @return void
     */
    public function setStartDate(?string $startDate): void;

    /**
     * Getter for EndDate.
     *
     * @return string|null
     */
    public function getEndDate(): ?string;

    /**
     * Setter for EndDate.
     *
     * @param string|null $endDate
     *
     * @return void
     */
    public function setEndDate(?string $endDate): void;
}
