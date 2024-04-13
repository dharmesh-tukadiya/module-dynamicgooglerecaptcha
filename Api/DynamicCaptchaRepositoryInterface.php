<?php
/**
 * Copyright © DnTukadiya All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace DnTukadiya\DynamicGoogleReCaptcha\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface DynamicCaptchaRepositoryInterface
{

    /**
     * Save dynamic_captcha
     * @param \DnTukadiya\DynamicGoogleReCaptcha\Api\Data\DynamicCaptchaInterface $dynamicCaptcha
     * @return \DnTukadiya\DynamicGoogleReCaptcha\Api\Data\DynamicCaptchaInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \DnTukadiya\DynamicGoogleReCaptcha\Api\Data\DynamicCaptchaInterface $dynamicCaptcha
    );

    /**
     * Retrieve dynamic_captcha
     * @param string $dynamicCaptchaId
     * @return \DnTukadiya\DynamicGoogleReCaptcha\Api\Data\DynamicCaptchaInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($dynamicCaptchaId);

    /**
     * Retrieve dynamic_captcha matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \DnTukadiya\DynamicGoogleReCaptcha\Api\Data\DynamicCaptchaSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete dynamic_captcha
     * @param \DnTukadiya\DynamicGoogleReCaptcha\Api\Data\DynamicCaptchaInterface $dynamicCaptcha
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \DnTukadiya\DynamicGoogleReCaptcha\Api\Data\DynamicCaptchaInterface $dynamicCaptcha
    );

    /**
     * Delete dynamic_captcha by ID
     * @param string $dynamicCaptchaId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($dynamicCaptchaId);
}

