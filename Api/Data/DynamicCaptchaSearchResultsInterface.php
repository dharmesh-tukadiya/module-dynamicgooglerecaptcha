<?php
/**
 * Copyright © DnTukadiya All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace DnTukadiya\DynamicGoogleReCaptcha\Api\Data;

interface DynamicCaptchaSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get dynamic_captcha list.
     * @return \DnTukadiya\DynamicGoogleReCaptcha\Api\Data\DynamicCaptchaInterface[]
     */
    public function getItems();

    /**
     * Set identifier list.
     * @param \DnTukadiya\DynamicGoogleReCaptcha\Api\Data\DynamicCaptchaInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

