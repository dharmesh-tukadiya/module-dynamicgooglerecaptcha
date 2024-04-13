<?php
/**
 * Copyright © DnTukadiya All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace DnTukadiya\DynamicGoogleReCaptcha\Model;

use DnTukadiya\DynamicGoogleReCaptcha\Api\Data\DynamicCaptchaInterface;
use Magento\Framework\Model\AbstractModel;

class DynamicCaptcha extends AbstractModel implements DynamicCaptchaInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\DnTukadiya\DynamicGoogleReCaptcha\Model\ResourceModel\DynamicCaptcha::class);
    }

    /**
     * @inheritDoc
     */
    public function getDynamicCaptchaId()
    {
        return $this->getData(self::DYNAMIC_CAPTCHA_ID);
    }

    /**
     * @inheritDoc
     */
    public function setDynamicCaptchaId($dynamicCaptchaId)
    {
        return $this->setData(self::DYNAMIC_CAPTCHA_ID, $dynamicCaptchaId);
    }

    /**
     * @inheritDoc
     */
    public function getIdentifier()
    {
        return $this->getData(self::IDENTIFIER);
    }

    /**
     * @inheritDoc
     */
    public function setIdentifier($identifier)
    {
        return $this->setData(self::IDENTIFIER, $identifier);
    }

    /**
     * @inheritDoc
     */
    public function getShowControllerPath()
    {
        return $this->getData(self::SHOW_CONTROLLER_PATH);
    }

    /**
     * @inheritDoc
     */
    public function setShowControllerPath($showControllerPath)
    {
        return $this->setData(self::SHOW_CONTROLLER_PATH, $showControllerPath);
    }

    /**
     * @inheritDoc
     */
    public function getCaptchaType()
    {
        return $this->getData(self::CAPTCHA_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setCaptchaType($captchaType)
    {
        return $this->setData(self::CAPTCHA_TYPE, $captchaType);
    }

    /**
     * @inheritDoc
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @inheritDoc
     */
    public function getActionMethod()
    {
        return $this->getData(self::ACTION_METHOD);
    }

    /**
     * @inheritDoc
     */
    public function setActionMethod($actionMethod)
    {
        return $this->setData(self::ACTION_METHOD, $actionMethod);
    }

    /**
     * @inheritDoc
     */
    public function getSubmitControllerPath()
    {
        return $this->getData(self::SUBMIT_CONTROLLER_PATH);
    }

    /**
     * @inheritDoc
     */
    public function setSubmitControllerPath($submitControllerPath)
    {
        return $this->setData(self::SUBMIT_CONTROLLER_PATH, $submitControllerPath);
    }

    /**
     * @inheritDoc
     */
    public function getTargetElementId()
    {
        return $this->getData(self::TARGET_ELEMENT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setTargetElementId($targetElementId)
    {
        return $this->setData(self::TARGET_ELEMENT_ID, $targetElementId);
    }

    public function getWebsiteId()
    {
        return $this->getData(self::WEBSITE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setWebsiteId($websiteId)
    {
        return $this->setData(self::WEBSITE_ID, $websiteId);
    }
}

