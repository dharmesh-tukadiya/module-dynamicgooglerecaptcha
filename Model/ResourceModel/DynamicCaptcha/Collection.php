<?php
/**
 * Copyright © DnTukadiya All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace DnTukadiya\DynamicGoogleReCaptcha\Model\ResourceModel\DynamicCaptcha;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'dynamic_captcha_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \DnTukadiya\DynamicGoogleReCaptcha\Model\DynamicCaptcha::class,
            \DnTukadiya\DynamicGoogleReCaptcha\Model\ResourceModel\DynamicCaptcha::class
        );
    }
}

