<?php
/**
 * Copyright © DnTukadiya All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace DnTukadiya\DynamicGoogleReCaptcha\Api\Data;

interface DynamicCaptchaInterface
{

    const TARGET_ELEMENT_ID = 'target_element_id';
    const DYNAMIC_CAPTCHA_ID = 'dynamic_captcha_id';
    const SHOW_CONTROLLER_PATH = 'show_controller_path';
    const ACTION_METHOD = 'action_method';
    const SUBMIT_CONTROLLER_PATH = 'submit_controller_path';
    const CAPTCHA_TYPE = 'captcha_type';
    const IDENTIFIER = 'identifier';
    const STATUS = 'status';
    const WEBSITE_ID = 'website_id';

    /**
     * Get dynamic_captcha_id
     * @return string|null
     */
    public function getDynamicCaptchaId();

    /**
     * Set dynamic_captcha_id
     * @param string $dynamicCaptchaId
     * @return \DnTukadiya\DynamicGoogleReCaptcha\DynamicCaptcha\Api\Data\DynamicCaptchaInterface
     */
    public function setDynamicCaptchaId($dynamicCaptchaId);

    /**
     * Get identifier
     * @return string|null
     */
    public function getIdentifier();

    /**
     * Set identifier
     * @param string $identifier
     * @return \DnTukadiya\DynamicGoogleReCaptcha\DynamicCaptcha\Api\Data\DynamicCaptchaInterface
     */
    public function setIdentifier($identifier);

    /**
     * Get show_controller_path
     * @return string|null
     */
    public function getShowControllerPath();

    /**
     * Set show_controller_path
     * @param string $showControllerPath
     * @return \DnTukadiya\DynamicGoogleReCaptcha\DynamicCaptcha\Api\Data\DynamicCaptchaInterface
     */
    public function setShowControllerPath($showControllerPath);

    /**
     * Get captcha_type
     * @return string|null
     */
    public function getCaptchaType();

    /**
     * Set captcha_type
     * @param string $captchaType
     * @return \DnTukadiya\DynamicGoogleReCaptcha\DynamicCaptcha\Api\Data\DynamicCaptchaInterface
     */
    public function setCaptchaType($captchaType);

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \DnTukadiya\DynamicGoogleReCaptcha\DynamicCaptcha\Api\Data\DynamicCaptchaInterface
     */
    public function setStatus($status);

    /**
     * Get action_method
     * @return string|null
     */
    public function getActionMethod();

    /**
     * Set action_method
     * @param string $actionMethod
     * @return \DnTukadiya\DynamicGoogleReCaptcha\DynamicCaptcha\Api\Data\DynamicCaptchaInterface
     */
    public function setActionMethod($actionMethod);

    /**
     * Get submit_controller_path
     * @return string|null
     */
    public function getSubmitControllerPath();

    /**
     * Set submit_controller_path
     * @param string $submitControllerPath
     * @return \DnTukadiya\DynamicGoogleReCaptcha\DynamicCaptcha\Api\Data\DynamicCaptchaInterface
     */
    public function setSubmitControllerPath($submitControllerPath);

    /**
     * Get target_element_id
     * @return string|null
     */
    public function getTargetElementId();

    /**
     * Set target_element_id
     * @param string $targetElementId
     * @return \DnTukadiya\DynamicGoogleReCaptcha\DynamicCaptcha\Api\Data\DynamicCaptchaInterface
     */
    public function setTargetElementId($targetElementId);

    /**
     * Get website_id
     * @return int|null
     */
    public function getWebsiteId();

    /**
     * Set website_id
     * @param string $websiteId
     * @return \DnTukadiya\DynamicGoogleReCaptcha\DynamicCaptcha\Api\Data\DynamicCaptchaInterface
     */
    public function setWebsiteId($websiteId);
}

