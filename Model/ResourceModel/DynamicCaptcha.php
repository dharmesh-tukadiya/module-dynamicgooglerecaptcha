<?php
/**
 * Copyright © DnTukadiya All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace DnTukadiya\DynamicGoogleReCaptcha\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class DynamicCaptcha extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('dntukadiya_dynamicgooglerecaptcha_dynamic_captcha', 'dynamic_captcha_id');
    }
}

